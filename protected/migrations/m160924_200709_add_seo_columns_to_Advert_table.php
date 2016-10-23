<?php

class m160924_200709_add_seo_columns_to_Advert_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Advert', 'seo_keywords', 'string');
        $this->addColumn('Advert', 'seo_description', 'string');
    }

    public function down()
    {
        $this->dropColumn('Advert', 'seo_keywords');
        $this->dropColumn('Advert', 'seo_description');
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