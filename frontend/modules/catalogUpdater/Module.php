<?php

namespace frontend\modules\catalogUpdater;

use frontend\modules\catalogUpdater\actions\ModuleAction;
use frontend\modules\catalogUpdater\interfaces\ICatalogFileParser;
use frontend\modules\catalogUpdater\interfaces\ICatalogUpdatePostForm;
use frontend\modules\catalogUpdater\interfaces\ICategories;
use frontend\modules\catalogUpdater\interfaces\IGoods;
use frontend\modules\catalogUpdater\interfaces\IModuleAction;
use frontend\modules\catalogUpdater\models\CatalogUpdatePostForm;
use frontend\modules\catalogUpdater\models\Categories;
use frontend\modules\catalogUpdater\models\Goods;

/**
 * Class Module uploader module to discover provided file type and select compatible parser
 * @package frontend\modules\catalogUpdater
 */
class Module extends \yii\base\Module
{
	public $parsers;
	public $config;

	/**
	 * Just setting interfaces in container to inverse control
	 */
	public function init()
	{
		$container = \Yii::$container;
		$container->set(ICategories::class, Categories::class);
		$container->set(IGoods::class, Goods::class);
		$container->set(ICatalogUpdatePostForm::class, CatalogUpdatePostForm::class);
		$container->set(IModuleAction::class, ModuleAction::class, [$this->config]);

		// parser interface, depends on mime type of uploaded file (search compatible)
		$container->set(ICatalogFileParser::class, function($container, $params){
			$parser = null;
			if (isset($params['form']) && ($params['form'] instanceof ICatalogUpdatePostForm)) {
				/** @var ICatalogUpdatePostForm $form */
				$form = $params['form'];
				$parserName = $this->parsers[$form->getMimeType()] ?: null;
				if (isset($parserName)) {
					$parser = new $parserName( $form );
				}
			}
			return $parser;
		});

	}
}