<?php

use yii\db\Migration;
use yii\db\Schema;

class m150414_163850_create_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => 'pk',
            'cat_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'brand_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'subtitle' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'price' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'discount' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'stock' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'visible' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'image_url' => Schema::TYPE_STRING . " NOT NULL DEFAULT '/images/320x150.gif'",
            'rating' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "0/0"',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }

}
