<?php



/**
 * Description of ServerHostHelper
 *
 * @author vench
 */
class ServerHostHelper {
    
    
    /**
     *
     * @var IServerHostModel
     */
    private $model = null;
    
    public function __construct($model = NULL) {
        $this->model = $model;
    }   
    
    /**
     * 
     * @return IServerHostModel
     */
    public function getServerHost() {
        if(is_null($this->model)) {
            throw new Exception('Model not Found');
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
        $model->setFileConf($fileConf);
        $linies = file($fileConf);
        foreach($linies as $line) {
            $line = trim($line);
            if(preg_match('/^([a-zA-Z]{1,})\s*(.*)/ui', $line, $match)) {
                if(sizeof($match) == 3) {
                    list(, $key, $value) = $match;                    
                    call_user_func_array(array($model, 'set'.$key), array($value));
                }
            } else if(preg_match('/^\<VirtualHost\s*(.*):(.*)\>/ui', $line, $match)) {
                if(sizeof($match) == 3) {
                    $model->setPort($match[2]);
                    $model->setIP($match[1]);
                }
            }
        }
        return $model;
    }
    
    /**
     * 
     * @return string
     */
    public function getVHost() {
        $model = $this->getServerHost();
        $str = "<VirtualHost {$model->getIP()}:{$model->getPort()}>\n";
        $str .= "\tServerAdmin {$model->getServerAdmin()}\n"; 
        $str .= "\tServerName {$model->getServerName()}\n";
        $str .= "\tServerAlias {$model->getServerAlias()}\n";
        $str .= "\tDocumentRoot {$model->getDocumentRoot()}\n";
        $str .= "\tErrorLog {$model->getErrorLog()}\n";
        $str .= "\tCustomLog {$model->getCustomLog()}\n";
        $str .= "</VirtualHost>\n";
        return $str;  
    }
    
} 
