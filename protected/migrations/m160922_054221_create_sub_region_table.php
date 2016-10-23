<?php

class m160922_054221_create_sub_region_table extends CDbMigration
{

    public function up()
    {
        $this->createTable('sub_region', [
            'id' => 'pk',
            'name' => 'string'
        ]);

        $this->insertMultiple('sub_region', [
            [
                'name' => 'South East'
            ],
            [
                'name' => 'London'
            ],
            [
                'name' => 'North West'
            ],
            [
                'name' => 'East of England'
            ],
            [
                'name' => 'West Midlands'
            ],
            [
                'name' => 'South West'
            ],
            [
                'name' => 'Yorkshire and the Humber'
            ],
            [
                'name' => 'East Midlands'
            ],
            [
                'name' => 'North East'
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('sub_region');
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