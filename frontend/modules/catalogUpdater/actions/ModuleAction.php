<?php

namespace frontend\modules\catalogUpdater\actions;

use common\actions\IAppAction;
use frontend\modules\catalogUpdater\Classes\CatalogArrayHelper;
use frontend\modules\catalogUpdater\interfaces\ICatalogFileParser;
use frontend\modules\catalogUpdater\interfaces\ICatalogUpdatePostForm;
use frontend\modules\catalogUpdater\interfaces\ICategories;
use frontend\modules\catalogUpdater\interfaces\IGoods;
use frontend\modules\catalogUpdater\interfaces\IModuleAction;
use yii\base\Model;

class ModuleAction implements IModuleAction
{
	/** @var Model|ICatalogUpdatePostForm $form */
	private $form;
	/** @var IGoods $modelGoods */
	private $modelGoods;
	/** @var ICategories $modelCategories */
	private $modelCategories;

	/** @var array $messages */
	private $messages = null;
	private $status = IAppAction::ACTION_FAIL;
	private $parser;
	private $vendor_key;

	public function __construct($config, ICatalogUpdatePostForm $form, IGoods $modelGoods, ICategories $modelCategories)
	{
		/** @var Model|ICatalogUpdatePostForm $form */
		$this->form = $form;
		$this->modelGoods = $modelGoods;
		$this->modelCategories = $modelCategories;

		$this->form->load(\Yii::$app->request->post()[$config],'');
	}

	public function run(): bool
	{
		if ($this->form->validate()) {
			$this->parser = \Yii::$container->get(ICatalogFileParser::class, ['form' => $this->form]);

			$tree = CatalogArrayHelper::createCatalogTree($this->parser->getArray(), $this->form->getCategoryDepth());
			$columns = CatalogArrayHelper::createColumnArray($this->form->getColumns(), $this->form->getCategoryDepth());

			$this->vendor_key = array_search(IGoods::FIELD_VENDOR_CODE, $columns, true);

			$this->parseTree($tree, null, $columns);

			if (!isset($this->messages)) {
				$this->status = IAppAction::ACTION_SUCCESS;
				$this->addMessages(['status' => ['Finished']]);
			} else {
				$this->addMessages(['status' => ['Finished with errors']]);
			}
		} else {
			$this->addMessages($this->form->getErrors() );
			$this->status = IAppAction::ACTION_FAIL;
		}

		return $this->status;
	}

	/**
	 * Parse current category and save categories and goods to database
	 *
	 * @param $tree array Current category of catalog in tree form
	 * @param $parent_id integer Parent category id from db
	 * @param $columns array Array of columns
	 */
	public function parseTree($tree, $parent_id, $columns)
	{
		/** @var IGoods $goods */
		$goods = null;
		$category = null;

		foreach ($tree as $id => $item) {
			if (is_numeric($id)) {
				$goods = ($this->modelGoods)::findOne([IGoods::FIELD_VENDOR_CODE => $item[$this->vendor_key]]);

				if ($goods == null) {
					$goods = \Yii::$container->get(IGoods::class);
					$goods->setAttribute(IGoods::FIELD_CATEGORY_ID, $parent_id);
				}
				foreach ($columns as $key => $colName) {
					if ($goods->hasAttribute($colName) && isset($item[$key])) {
						$goods->{$colName} = $item[$key];
					}
				}
				if (!$goods->save()) {
					$this->addMessages($goods->getErrors());
				};
			} else {
				$category = ($this->modelCategories)::findOne(['name' => $id, 'parent' => $parent_id]);
				if ($category == null) {
					$category = \Yii::$container->get(ICategories::class);
					$category->setAttributes([
						ICategories::FIELD_NAME => $id,
					    ICategories::FIELD_PARENT => $parent_id
					]);
					if (!$category->save()) {
						$this->addMessages($category->getErrors());
					};
				}
				$this->parseTree($item, $category->id, $columns);
			}
		}
	}

	public function getMessages(): array
	{
		return $this->messages;
	}

	public function getStatus(): string
	{
		return $this->status ? 'Success' : 'Fail';
	}

	private function addMessages(array $messages)
	{
		$this->messages[] = $messages;
	}
}