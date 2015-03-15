<?php
Yii::import('ext.servercommand.IServerHostModel');

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
 * @property int $port
 * @property string $ip
 */
class ServerHost extends CActiveRecord implements IServerHostModel
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
			array('fileConf, ip, ServerAdmin, ServerName, ServerAlias, DocumentRoot, ErrorLog, CustomLog', 'length', 'max'=>255),
			// The following rule is used by search().
                        array('ServerAdmin', 'email'),
                        array('port', 'numerical', 'integerOnly'=>TRUE),
                        array('ip', 'match', 'pattern'=>'/*|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/ui'),
                        array('ServerName, ServerAlias', 'url'),
			// @todo Please remove those attributes that should not be searched.
			array('Id, port, ip fileConf, ServerAdmin, ServerName, ServerAlias, DocumentRoot, ErrorLog, CustomLog', 'safe', 'on'=>'search'),
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
                        'port'=>'Port',
                        'ip'=>'IP',
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
        
        /** IServerHostModel **/
        public function setPort($port) {
            $this->port = $port;
        }
        
        public function getPort() {
            return  $this->port;
        }
        
        public function setIP($ip) {
            $this->ip = $ip;
        }
        public function getIP() {
            return $this->ip;
        }   
        public function setFileConf($fileConf) {
            $this->fileConf = $fileConf;
        }
        public function getFileConf() {
            return $this->fileConf;
        }  
        public function setServerAdmin($serverAdmin) {
            $this->ServerAdmin = $serverAdmin;
        }
        public function getServerAdmin() {
            return $this->ServerAdmin;
        }
        public function setServerName($serverName) {
            $this->ServerName = $serverName;
        }
        public function getServerName() {
            return $this->ServerName;
        }
        public function setServerAlias($serverAlias) {
            $this->ServerAlias = $serverAlias;
        }
        public function getServerAlias() {
            return $this->ServerAlias;
        }
        public function setDocumentRoot($documentRoot) {
            $this->DocumentRoot = $documentRoot;
        }
        public function getDocumentRoot() {
            return $this->DocumentRoot;
        }
        public function setErrorLog($errorLog) {
            $this->ErrorLog = $errorLog;
        }
        public function getErrorLog() {
            return $this->ErrorLog;
        }
        public function setCustomLog($customLog) {
            $this->CustomLog = $customLog;
        }
        public function getCustomLog() {
            return $this->CustomLog;
        }
        /** /IServerHostModel **/

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
