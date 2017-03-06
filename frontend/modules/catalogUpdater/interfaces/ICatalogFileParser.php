<?php

namespace frontend\modules\catalogUpdater\interfaces;


/**
 * Interface ICatalogFileParser for parsers
 * @package frontend\modules\catalogUpdater\interfaces
 */
interface ICatalogFileParser
{
	/**
	 * @return array Array of rows from uploaded file
	 */
	public function getArray(): array;
}