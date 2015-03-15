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


    public function init() {
        Yii::import('ext.servercommand.*');
        $SERVER_SOFTWARE = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
        if(preg_match('/Apache\/2\.[0-9\.]*\s*\(Ubuntu\)/i', $SERVER_SOFTWARE)) {
            $this->serverCommandStrategy = new UbtAp2CommandStrategy($this); 
        } else {
            $this->serverCommandStrategy = new BlankServerCommandStrategy($this); 
        }   
         
        $key = strtolower(get_class($this->serverCommandStrategy));
        if(isset($this->serverStrategyOptions[$key])) {
            foreach($this->serverStrategyOptions[$key] as $key=>$value){
                $this->serverCommandStrategy->{$key} = $value;
            }
        }
    }
    
    /**
     * 
     * @return AServerCommandStrategy
     */
    public function getServerCommandStrategy() {
        return $this->serverCommandStrategy;
    }            

    public function addHost($serverName, $documentRoot) {
        
        
        
        $this->exec('a2ensite '.basename($confFile).'');
        $this->reloadApache2();
    }

   
    public function stopServer() {
        $this->getServerCommandStrategy()->stopServer();
    }
    
    
    public function restartServer() {
        $this->getServerCommandStrategy()->restartServer();
    }
    
 
}




