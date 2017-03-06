<?php

namespace frontend\modules\catalogUpdater\components;

use frontend\modules\catalogUpdater\interfaces\ICatalogFileParser;
use frontend\modules\catalogUpdater\interfaces\ICatalogUpdatePostForm;

/**
 * Class XlsxFileParser one of parsers, provided by third-party code
 * @package frontend\modules\catalogUpdater\components
 */
class XlsxFileParser implements ICatalogFileParser
{
	/** @var null|\PHPExcel $excel */
	private $excel = null;

	public function __construct(ICatalogUpdatePostForm $form)
	{
		$this->excel = \PHPExcel_IOFactory::load($form->getFileInstance()->tempName);
	}

	public function getArray(): array
	{
		return $this->excel->getActiveSheet()->toArray();
	}
}