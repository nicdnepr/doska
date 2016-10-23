<?php

class m160924_200637_add_region_columns_to_Advert_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Advert', 'country_name', 'string');
		$this->addColumn('Advert', 'city_name', 'string');
	}

	public function down()
	{
        $this->dropColumn('Advert', 'country_name');
        $this->dropColumn('Advert', 'city_name');
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