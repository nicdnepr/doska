<?php

class m160922_054233_add_sub_region_id_column_to_advert_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Advert', 'sub_region_id', 'integer');
        $this->addForeignKey('fk_Advert_sub_region', 'Advert', 'sub_region_id', 'sub_region', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_Advert_sub_region', 'Advert');
        $this->dropColumn('Advert', 'sub_region_id');
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