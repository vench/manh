<?php

 

/**
 * Description of ServerCommand
 *
 * @author vench
 */
class ServerCommand extends CComponent {
    
    /**
     *
     * @var string
     */
    public $defaultAppach2Conf = '/etc/apache2/sites-available/000-default.conf';
    
    /**
     *
     * @var string 
     */
    public $appach2DirSitesAvail = '/etc/apache2/sites-available/';
    
    public function init() {
        
    }
    
    public function addHost($serverName, $documentRoot) {
        $confFile = $this->appach2DirSitesAvail.$serverName.'.conf';
        if(!file_exists($confFile)) {
            copy($this->defaultAppach2Conf, $confFile);
        }
        
        
        $this->exec('a2ensite '.basename($confFile).'');
        $this->reloadApache2();
    }


    
    /**
     * 
     * @return boolean
     */
    public function reloadApache2() {
        $result = $this->exec('service apache2 reload');
        return true;
    }
    
    /**
     * Method run exec command
     * @param string $command
     * @return string
     */
    public function exec($command) {
        $result = system($command);
        var_dump($result, $command);
        return $result;
    }
}


class ServerHostHelper {
    
    
    /**
     *
     * @var ServerHost
     */
    private $model = null;
    
    public function __construct($model = NULL) {
        $this->model = $model;
    }   
    
    /**
     * 
     * @return ServerHost
     */
    public function getServerHost() {
        if(is_null($this->model)) {
            $this->model = new ServerHost();
        }
        return $this->model;
    }
    
   
    /**
     * 
     * @param string $fileConf Путь к файлу конфигурации
     * @return ServerHost
     */
    public function loadByFile($fileConf = NULL) { 
        $model = $this->getServerHost();
        $model->fileConf = $fileConf;
        $linies = file($fileConf);
        foreach($linies as $line) {
            $line = trim($line);
            preg_match('/^([a-zA-Z]{1,})\s*(.*)/ui', $line, $match);
            if(sizeof($match) == 3) {
                list(, $key, $value) = $match;
                $model->{$key} = $value;
            }
        }
        return $model;
    }
    
    /**
     * 
     */
    public function saveInFile() {
        $model = $this->getServerHost();
        $str = "<VirtualHost *:80>\n";
        $str .= "\tServerAdmin admin@test.com\n"; 
        $str .= "\tServerName test.com\n";
        $str .= "\tServerAlias www.test.com\n";
        $str .= "\tDocumentRoot /var/www/test.com/public_html\n";
        $str .= "\tErrorLog ${APACHE_LOG_DIR}/error.log\n";
        $str .= "\tCustomLog ${APACHE_LOG_DIR}/access.log combined\n";
        $str .= "</VirtualHost>\n";
        file_put_contents($this->fileConf, $str);  
    }
    
} 
