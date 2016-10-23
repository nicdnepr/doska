<?php

class m160925_122036_add_fio_columns_to_User_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('User', 'f_name', 'string');
        $this->addColumn('User', 'l_name', 'string');
        $this->addColumn('User', 'phone', 'string');
        $this->addColumn('User', 'notes', 'text');
        $this->addColumn('User', 'expiry', 'date');
    }

    public function down()
    {
        $this->dropColumn('User', 'f_name');
        $this->dropColumn('User', 'l_name');
        $this->dropColumn('User', 'phone');
        $this->dropColumn('User', 'notes');
        $this->dropColumn('User', 'expiry');
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