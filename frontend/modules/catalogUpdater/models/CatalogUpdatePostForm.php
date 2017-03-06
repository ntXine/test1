<?php

namespace frontend\modules\catalogUpdater\models;

use frontend\modules\catalogUpdater\interfaces\ICatalogUpdatePostForm;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Catalog Update Post form
 */
class CatalogUpdatePostForm extends Model implements ICatalogUpdatePostForm
{
	/** @var  int $parser_price_subcategory */
	public $parser_price_subcategory;
	/** @var  string $columns */
	public $columns;
	/** @var  UploadedFile $file */
	public $file;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['parser_price_subcategory', 'required'],
			['parser_price_subcategory', 'integer', 'min' => 1, 'max' => 3],

			//TODO Add rule to match columns collection pattern
			['columns', 'required'],
			['columns', 'string', 'max' => 255],

			['file', 'required'],
			[
				'file',
				'file',
			    'maxFiles' => 1,
			    'mimeTypes' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			],
		];
	}

	public function load($data, $formName = null)
	{
		$retValue = false;
		if (parent::load($data, $formName)) {
			$this->file = UploadedFile::getInstanceByName('parser_config[file]');
			if ($this->file != null) {
				$retValue = true;
			}
		};
		return $retValue;
	}

	public function getCategoryDepth(): int
	{
		return $this->parser_price_subcategory;
	}

	public function getFileInstance(): UploadedFile
	{
		return $this->file;
	}

	public function getColumns(): string
	{
		return $this->columns;
	}

	public function getMimeType(): string
	{
		return $this->file->type;
	}
}
