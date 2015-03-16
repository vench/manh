<?php

class APIController extends Controller
{
    
    
    
        public function filters() {
            return array(
                'accessControl', 
                'testSignature'
            );
        }
        
        public function filterTestSignature($filterChain) {
            //тут может быть реализация проверки подписи клиента
            $filterChain->run();
        }
    
    
	public function actionIndex() {
		$this->renderJSON('API Hello!');
	}
        
        /**
         * 
         * @param int $offset
         * @param int $limit
         */
        public function actionHosts($page = 1, $start = 0, $limit = 10) {   
            $criteria = new CDbCriteria();
            $criteria->offset = $start;
            $criteria->limit = $limit;
            $dataProvider = new CActiveDataProvider(new ServerHost('search'), array(
			'criteria'=>$criteria,
	     ));            
             $this->renderJSON(array(
                    'offset'=>$criteria->offset,
                    'limit'=>$criteria->limit,
                    'total'=>$dataProvider->getTotalItemCount(),
                    'data'=>$dataProvider->getData(),
             ));
        }
        
        /**
         * 
         */
        public function actionAddHost() {
            $req = $this->getRequestData();  
            $model = new ServerHost();
            if(isset($req['ServerHost'])) {
                $model->attributes = $req['ServerHost'];
                if($model->validate()) {
                     $this->getServerCommand()->addHost($model);
                     $model->save();
                     $this->renderJSON(array(
                        'success'=>TRUE, 
                        'message'=>'Success add new host',
                        'model' =>$model,
                    ));
                }
                $this->renderJSON(array(
                    'success'=>FALSE,
                    'message'=>$this->getErrorStr($model),
                ));
            }
            $this->renderJSON(array(
                    'success'=>FALSE, 
                    'message'=>'Nothing to add',
                ));
        }
        
        /**
         *  
         */
        public function actionUpdateHost() {
            $req = $this->getRequestData(); 
            $pk = isset($req['ServerHost']['Id']) ? $req['ServerHost']['Id'] : NULL;
            $model = ServerHost::model()->findByPk($pk);
            if(is_null($model)) {
               $this->renderJSON(array(
                    'success'=>FALSE, 
                    'message'=>'Model not found',
                ));
            }
            if(isset($req['ServerHost'])) {
                $model->attributes = $req['ServerHost'];
                if($model->save()) {
                    $this->getServerCommand()->removeHost($model);
                    $this->getServerCommand()->addHost($model);
                    $this->renderJSON(array(
                        'success'=>TRUE, 
                        'message'=>'Success update host',
                    ));
                }
                $this->renderJSON(array(
                    'success'=>FALSE,
                    'message'=>$this->getErrorStr($model),
                ));
            }
            $this->renderJSON(array(
                    'success'=>FALSE,
                    'message'=>('Nothing to update'),
                ));
        }
        
        /**
         * 
         */
        public function actionRemoveHost() {
            $req = $this->getRequestData(); 
            $pk = isset($req['ServerHost']['Id']) ? $req['ServerHost']['Id']: NULL;
            $model = ServerHost::model()->findByPk($pk);
            if(is_null($model)) {
               $this->renderJSON(array(
                    'success'=>FALSE, 
                    'message'=>'Model not found',
                ));
            } 
            if($model->delete()) {
                $this->getServerCommand()->removeHost($model);
                $this->renderJSON(array(
                    'success'=>TRUE,
                ));
            }
            $this->renderJSON(array(
                    'success'=>FALSE,
                    'message'=>$this->getErrorStr($model),
             ));
        }
        
        /**
         * 
         * @return array
         */
        public function getRequestData() {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body, true);             
            return $data;
        }

        /**
         * 
         * @param mixed $data
         */
        public function renderJSON($data) {
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        
        /**
         * 
         * 
         * @return ServerCommand
         */
        public function getServerCommand() {
            return Yii::app()->exec;
        }
 
        /**
         * 
         * @param CActiveRecord $model
         * @return string
         */
        public function getErrorStr(CActiveRecord $model) {
            $str = '';
            foreach ($model->getErrors() as $key=>$errors) {
                $str .= $model->getAttributeLabel($key).': '. join(',', $errors)."\n" ;
            }
            return $str;
        }
}