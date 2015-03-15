<?php

class m150315_194511_model_add_fields extends CDbMigration
{
	public function up()
	{
            $this->addColumn('ServerHost', 'port', 'int');
            $this->addColumn('ServerHost', 'ip', 'string');
	}

	public function down()
	{
		echo "m150315_194511_model_add_fields does not support migration down.\n";
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