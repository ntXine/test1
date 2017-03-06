<?php

namespace frontend\modules\catalogUpdater\interfaces;

use yii\db\ActiveRecordInterface;

interface IGoods extends ActiveRecordInterface
{
	const FIELD_CATEGORY_ID = 'category_id';
	const FIELD_VENDOR_CODE = 'vendor_code';

	public function getErrors($attribute = null);
}