<?php

class m150315_133011_server_host extends CDbMigration
{
	public function up()
	{
            $this->createTable('ServerHost', array(
                'Id'=>'pk',
                'fileConf'=>'string',
                'ServerAdmin'=>'string',
                'ServerName'=>'string',
                'ServerAlias'=>'string',
                'DocumentRoot'=>'string',
                'ErrorLog'=>'string',
                'CustomLog'=>'string',    
            ));
	}

	public function down()
	{
		echo "m150315_133011_server_host does not support migration down.\n";
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