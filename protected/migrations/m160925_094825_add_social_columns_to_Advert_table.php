<?php

class m160925_094825_add_social_columns_to_Advert_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Advert', 'facebook_url', 'string');
        $this->addColumn('Advert', 'twitter_url', 'string');
        $this->addColumn('Advert', 'instagram_url', 'string');
        $this->addColumn('Advert', 'gplus_url', 'string');
        $this->addColumn('Advert', 'youtube_url', 'string');
        $this->addColumn('Advert', 'pinterest_url', 'string');
    }

    public function down()
    {
        $this->dropColumn('Advert', 'facebook_url');
        $this->dropColumn('Advert', 'twitter_url');
        $this->dropColumn('Advert', 'instagram_url');
        $this->dropColumn('Advert', 'gplus_url');
        $this->dropColumn('Advert', 'youtube_url');
        $this->dropColumn('Advert', 'pinterest_url');
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