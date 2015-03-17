<?php

class m150317_104559_settings extends CDbMigration
{
	public function up()
	{
            $this->createTable('Settings', array(
                'key'=>'string',
                'value'=>'string',
            ));
	}

	public function down()
	{
		echo "m150317_104559_settings does not support migration down.\n";
		return false;
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