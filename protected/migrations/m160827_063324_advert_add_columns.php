<?php

class m160827_063324_advert_add_columns extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Advert', 'country_id', 'integer');
        $this->addColumn('Advert', 'region_id', 'integer');
        $this->addColumn('Advert', 'city_id', 'integer');
    }

    public function down()
    {
        $this->dropColumn('Advert', 'country_id');
        $this->dropColumn('Advert', 'region_id');
        $this->dropColumn('Advert', 'city_id');
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