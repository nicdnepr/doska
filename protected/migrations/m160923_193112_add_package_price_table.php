<?php

class m160923_193112_add_package_price_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('package_price', [
            'id' => 'pk',
            'country_id' => 'integer',
            'region_id' => 'integer',
            'sub_region_id' => 'integer',
            'country_name' => 'string',
            'region_name' => 'string',
            'price_1' => 'decimal(10,2)',
            'price_2' => 'decimal(10,2)',
            'price_3' => 'decimal(10,2)'
        ]);

        $this->addForeignKey('fk_package_price_sub_region', 'package_price', 'sub_region_id', 'sub_region', 'id');
        $this->createIndex('idx_unique_price', 'package_price', ['country_id', 'region_id', 'sub_region_id'], true);
    }

    public function down()
    {
        $this->dropTable('package_price');
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}