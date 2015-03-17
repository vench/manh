<?php



/**
 * Класс UbtAp2CommandStrategy реализует стратегию управления сервером на Ubuntu и Apache2
 *
 * @author vench
 */
class UbtAp2CommandStrategy extends AServerCommandStrategy {
    
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
    
    
    public function startServer() {
        $this->exec('service apache2 start');
    }
    
    public function stopServer() {
        $this->exec('service apache2 stop');
    }
    
    public function restartServer() {
        //$this->exec('service apache2 reload');
        //устанавливаем флаг о необходимости произвести перезагрузку для планировщика
        Settings::setServerRestart(true);
    }
    
    public function addHost(IServerHostModel $model) {
        $confFile = $this->appach2DirSitesAvail.$model->getServerName().'.conf';
        if(!file_exists($confFile)) {
            copy($this->defaultAppach2Conf, $confFile);
        } 
        $model->setFileConf($confFile);
        $helper = new ServerHostHelper($model);
        file_put_contents($confFile, $helper->getVHost());
        
        $this->exec('a2ensite '.basename($confFile).'');  
        $this->restartServer();
    }
    
    public function removeHost(IServerHostModel $model) {
        $confFile = $model->getFileConf();
        $this->exec('a2dissite '.basename($confFile).'');
    }
    
    private function exec($cmd) {
         $result = system($cmd);
        //var_dump($result, $cmd);
        return $result;
    }
}
