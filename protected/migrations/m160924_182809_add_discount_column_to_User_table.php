<?php

class m160924_182809_add_discount_column_to_User_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('User', 'discount', 'integer DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('User', 'discount');
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