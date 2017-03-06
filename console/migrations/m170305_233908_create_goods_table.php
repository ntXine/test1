<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170305_233908_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'vendor_code' => $this->string(32)->notNull()->unique(),
            'title' => $this->string()->notNull(),
            'price' => $this->decimal()->notNull(),
            'announce' => $this->string(),
            'description' => $this->text(),
            'features' => $this->text(),
            'weight' => $this->string(32),
            'volume' => $this->string(32),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);

        $this->addForeignKey(
        	'fk-goods-category_id',
	        'goods',
	        'category_id',
	        'categories',
	        'id',
	        'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    	$this->dropForeignKey('fk-goods-category_id', 'goods');

        $this->dropTable('goods');
    }
}
