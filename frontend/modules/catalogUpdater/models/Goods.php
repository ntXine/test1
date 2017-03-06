<?php

namespace frontend\modules\catalogUpdater\models;

use frontend\modules\catalogUpdater\interfaces\IGoods;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $vendor_code
 * @property string $title
 * @property string $price
 * @property string $announce
 * @property string $description
 * @property string $features
 * @property string $weight
 * @property string $volume
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Categories $category
 */
class Goods extends \yii\db\ActiveRecord implements IGoods
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'vendor_code', 'title', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['description', 'features'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['vendor_code', 'weight', 'volume'], 'string', 'max' => 32],
            [['title', 'announce'], 'string', 'max' => 255],
            [['vendor_code'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::class => [
				'class' => TimestampBehavior::class,
				'value' => function () {
					return new Expression('CURRENT_TIMESTAMP()');
				}
			],
		];
	}

	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'vendor_code' => 'Артикул',
            'title' => 'Название',
            'price' => 'Цена',
            'announce' => 'Краткое описание',
            'description' => 'Описание',
            'features' => 'Характеристики',
            'weight' => 'Вес',
            'volume' => 'Объём',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
