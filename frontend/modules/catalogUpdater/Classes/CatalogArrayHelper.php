<?php

namespace frontend\modules\catalogUpdater\Classes;


/**
 * Class CatalogArrayHelper outlines some array methods
 * @package frontend\modules\catalogUpdater\Classes
 */
class CatalogArrayHelper
{
	/**
	 * Resort plain array of rows into tree-array with categories
	 *
	 * @param $array array Initial array of rows
	 * @param int $levels category depth level (1 to 3 hardcoded, needs to be reviewed)
	 *
	 * @return array|null
	 */
	public static function createCatalogTree( $array, int $levels)
	{
		/** @var array $tree */
		$tree = null;

		foreach ($array as $row) {
			if ($levels>1) {
				if ($row[1] == null) {
					$tree[$row[0]][] = $row;
				} else {
					if ($levels>2) {
						if( $row[2] == null ) {
							$tree[$row[0]][$row[1]][] = $row;
						}
						else {
							$tree[$row[0]][$row[1]][$row[2]][] = $row;
						}
					} else {
						$tree[$row[0]][$row[1]][] = $row;
					}
				}
			} else {
				$tree[$row[0]][] = $row;
			}
		}

		return $tree;
	}

	/**
	 * Makes columns array indexed as in input string, trimming empty values
	 *
	 * @param string $columns Input string like 'a;b;c;d;e;;f' etc
	 * @param int $levels category depth level (to shift indexes to actual columns)
	 *
	 * @return array like ('2'=>'a', '3'=>'b) etc
	 */
	public static function createColumnArray($columns, int $levels)
	{
		$colArray = [];
		$array = explode(';',$columns);
		foreach ($array as $position => $item) {
			if ($item !== '') {
				$colArray[$position + $levels] = $item;
			}
		}
		return $colArray;
	}
}