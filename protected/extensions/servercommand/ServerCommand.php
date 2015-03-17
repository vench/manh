<?php


 

/**
 * Description of ServerCommand
 *
 * @author vench
 */
class ServerCommand extends CComponent {    

    
    /**
     *
     * @var AServerCommandStrategy
     */
    private $serverCommandStrategy;
    
    /**
     * Имя пользователя от которого будет происходить работа с сервером
     * @var string
     */
    public $serverAdminName = 'root';
    
    /**
     * Пароль администратора
     * @var string 
     */
    public $serverAdminPassword = '';
    
    /**
     * Набор опций который будет установлен в стратегию управления сервера
     * @var array
     */
    public $serverStrategyOptions = array();
    
    /**
     * Класс который будет управлять web сервером
     * @var string 
     */
    public $serverStrategyClass = 'BlankServerCommandStrategy';


    public function init() {
        Yii::import('ext.servercommand.*'); 
        
        if(!class_exists($this->serverStrategyClass) ) {
            $this->serverStrategyClass = 'BlankServerCommandStrategy';
        }
        $ref = new ReflectionClass($this->serverStrategyClass);
        $this->serverCommandStrategy = $ref->newInstanceArgs(array($this)); 
        $key = strtolower( $ref->getName() );
        if(isset($this->serverStrategyOptions[$key])) {
            foreach($this->serverStrategyOptions[$key] as $key=>$value){
                $this->serverCommandStrategy->{$key} = $value;
            }
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getIndexFileContent() {
        return '<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div>TODO write content</div>
    </body>
</html>';
    }
    
    /**
     * 
     * @return AServerCommandStrategy
     */
    public function getServerCommandStrategy() {
        return $this->serverCommandStrategy;
    }            

    /**
     * 
     * @param IServerHostModel $model
     */
    public function addHost(IServerHostModel $model) {   
         $this->normalizeServerHostModel($model);
         $this->getServerCommandStrategy()->addHost($model);
         
         $indexFile = $model->getDocumentRoot().DIRECTORY_SEPARATOR.'index.html';
         file_put_contents($indexFile, $this->getIndexFileContent());  
    }
    
    /**
     * 
     * @param IServerHostModel $model
     */
    public function removeHost(IServerHostModel $model) { 
        $this->getServerCommandStrategy()->removeHost($model);
    }

    /**
     * 
     */
    public function stopServer() {
        $this->getServerCommandStrategy()->stopServer();
    }
    
    /**
     * 
     */
    public function startServer() {
        $this->getServerCommandStrategy()->startServer();
    }
    
    /**
     * 
     */
    public function restartServer() {
        $this->getServerCommandStrategy()->restartServer();
    }
    
    /**
     * 
     * @param IServerHostModel $model
     * @throws ServerCommandException
     */
    protected function normalizeServerHostModel(IServerHostModel $model ) {
        if(!is_dir($model->getDocumentRoot()) && !mkdir($model->getDocumentRoot())) {
             throw new ServerCommandException("Dir is not found");
         }
         if(!is_writable($model->getDocumentRoot())) {
             throw new ServerCommandException("Dir host is read only");
         }
         if(empty($model->getServerName())) {
             throw new ServerCommandException("Server Name empty");
         }
         
         if(empty($model->getServerAlias())) {
             $model->setServerAlias("www.{$model->getServerName()}");
         }
         if(empty($model->getErrorLog())) {
             $model->setErrorLog("logs/{$model->getServerName()}.log");
         }
         if(empty($model->getCustomLog())) {
             $model->setCustomLog("logs/{$model->getServerName()}.log");
         }
    }
 
}




