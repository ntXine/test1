<?php

namespace frontend\modules\catalogUpdater\interfaces;

use yii\db\ActiveRecordInterface;

interface ICategories extends ActiveRecordInterface
{
	const   FIELD_NAME = 'name';
	const   FIELD_PARENT = 'parent';
}