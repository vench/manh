<?php

/**
 * This is the model class for table "Settings".
 *
 * The followings are the available columns in table 'Settings':
 * @property string $key
 * @property string $value
 */
class Settings extends CActiveRecord
{
        const KEY_SERVER_RESTART = 'SERVER.RESTART';
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key, value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('key, value', 'safe', 'on'=>'search'),
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
			'key' => 'Key',
			'value' => 'Value',
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

		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         * @param string $key
         * @param string $default
         * @return string|null
         */
        public static function getValue($key, $default = NULL) {
            $model = self::model()->find('key=:key', array(
                ':key'=>$key,
            ));
            return !is_null($model) ? $model->value : $default;
        }
        
        /**
         * 
         * @param string $key
         * @param string $value
         * @return \Settings
         */
        public static function setValue($key, $value) {
            $model = self::model()->find('key=:key', array(
                ':key'=>$key,
            ));
            if(is_null($model)) {
                $model = new Settings();
                $model->key = $key;
            }
            $model->value = $value;
            $model->save();
            return $model;
        }
        
        /**
         * Заявка на перезагрузку сервера в планировщике
         * @return boolean
         */
        public static function getServerRestart() {
            $value = self::getValue(self::KEY_SERVER_RESTART, 'false');
            return strtolower($value) == 'true';
        }
        
        /**
         * 
         * @param boolean $value
         */
        public static function setServerRestart($value) {
            self::setValue(self::KEY_SERVER_RESTART, $value ? 'true' : 'false');
        }
}
