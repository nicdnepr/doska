<?php

class m160629_205154_update_category extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Category', 'url', 'string');

        $this->createIndex('Category_url', 'Category', 'url', true);
    }

    public function down()
    {
        $this->dropColumn('Category', 'url');
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