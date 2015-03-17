<?php

class InstallController extends Controller
{
	public function actionIndex()
	{
            
                $status = array(); 
                $status[] = $this->createDIR();
                $status[] = $this->createDB();
                
            
		$this->render('index', array(
                    'status'=>$status,
                ));
	}
        
        
        protected function createDIR() {
            $patch = Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..';   
            foreach(array(
                'protected'.DIRECTORY_SEPARATOR.'runtime', 
                'protected'.DIRECTORY_SEPARATOR.'data',
                'assets') as $dir) {
                $patchdir = $patch.DIRECTORY_SEPARATOR.$dir;
                if(!is_dir($patchdir)) { 
                    mkdir($patchdir, 0777);
                } 
            } 
           
            return array(
                'ok',
                'Все необходимые директории были установлены',
            );
        }

	 
        
        /**
       *
       * @param InstallForm $installForm
       */
       protected function createDB() {
            ob_start();
            $patch = Yii::getPathOfAlias('application.migrations');
            $names = scandir($patch);
            $db = Yii::app()->getDb();
            foreach($names as $name) {
                $exp = explode('.', $name);
                if(sizeof($exp) === 2) {
                    list($className, $expr) = $exp;
                    if($expr === 'php') {
                        include_once $patch.DIRECTORY_SEPARATOR.$name;
                        if(class_exists($className) && !$this->migrationExists($className)) {
                            $migration = new $className() ;
                            $migration->setDbConnection($db);
                            $migration->up();
                        }
                    }
                }
            }
            ob_clean();
            return array(
                'ok',
                'База данных была успешно создана',
            );
       }
       
       /**
        * 
        * @param type $name
        * @return boolean
        */
       public function migrationExists($name) {
           $db = Yii::app()->getDb();
           $list = CHtml::listData($db->createCommand()
			->select('version, apply_time')
			->from('tbl_migration')
			->order('version DESC') 
			->queryAll(), 'version', 'apply_time');
           return isset($list[$name]);
       }
}