<?php

/**
 * This is the model class for table "ServerHost".
 *
 * The followings are the available columns in table 'ServerHost':
 * @property integer $Id
 * @property string $fileConf
 * @property string $ServerAdmin
 * @property string $ServerName
 * @property string $ServerAlias
 * @property string $DocumentRoot
 * @property string $ErrorLog
 * @property string $CustomLog
 */
class ServerHost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ServerHost';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fileConf, ServerAdmin, ServerName, ServerAlias, DocumentRoot, ErrorLog, CustomLog', 'length', 'max'=>255),
			// The following rule is used by search().
                        array('ServerAdmin', 'email'),
                        array('ServerName, ServerAlias', 'url'),
			// @todo Please remove those attributes that should not be searched.
			array('Id, fileConf, ServerAdmin, ServerName, ServerAlias, DocumentRoot, ErrorLog, CustomLog', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'fileConf' => 'File Conf',
			'ServerAdmin' => 'Server Admin',
			'ServerName' => 'Server Name',
			'ServerAlias' => 'Server Alias',
			'DocumentRoot' => 'Document Root',
			'ErrorLog' => 'Error Log',
			'CustomLog' => 'Custom Log',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('fileConf',$this->fileConf,true);
		$criteria->compare('ServerAdmin',$this->ServerAdmin,true);
		$criteria->compare('ServerName',$this->ServerName,true);
		$criteria->compare('ServerAlias',$this->ServerAlias,true);
		$criteria->compare('DocumentRoot',$this->DocumentRoot,true);
		$criteria->compare('ErrorLog',$this->ErrorLog,true);
		$criteria->compare('CustomLog',$this->CustomLog,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServerHost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
