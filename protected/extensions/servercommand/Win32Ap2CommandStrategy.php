<?php



/**
 * Description of Win32Ap2CommandStrategy
 * Apache/2.4.10 (Win32) OpenSSL/1.0.1i PHP/5.5.15
 * @author vench
 */
class Win32Ap2CommandStrategy extends AServerCommandStrategy  {
    
    /**
     * Пудь до apache
     * @var string 
     */
    public $pathApache = 'C:\\xampp\\apache';
    
    /**
     * Путь к файлу управления хостами
     * @var string 
     */
    public $pathHttpdVhosts = 'C:\\xampp\\apache\\conf\\extra\\httpd-vhosts.conf';
    
    /**
     *
     * @var string NameVirtualHost *:80
     */
    public  $baseNameVirtualHost = '*:80';
    
    public function startServer() {
        $cmd = $this->pathApache.'\\bin\\httpd.exe';
        $this->exec($cmd);
    }
    
    public function stopServer() {  
        $cmd = $this->pathApache.'\\bin\\pv -f -k httpd.exe -q';
        $this->exec($cmd);
    }
    
    public function restartServer() {
        // $this->stopServer();
        // $this->startServer();
        //устанавливаем флаг о необходимости произвести перезагрузку для планировщика
        Settings::setServerRestart(true);
    }
    
    
    public function addHost(IServerHostModel $model) { 
        $hosts = $this->loadHosts();
        if(isset($hosts[$model->getServerName()])) {
            unset($hosts[$model->getServerName()]);
        }
        $host = $this->getWin32Ap2VirtualHostItemInIServerHostModel($model);
        $hosts[] = $host;
        $this->updateFileVHosts($hosts);        
        $this->restartServer();
       
    }
    
    public function removeHost(IServerHostModel $model) {
        $hosts = $this->loadHosts();
        if(isset($hosts[$model->getServerName()])) {
            unset($hosts[$model->getServerName()]);
        }
        $this->updateFileVHosts($hosts); 
        $this->restartServer();
    }
    
    private function exec($cmd) {
         $result = system($cmd);
       // var_dump($result, $cmd);
        return $result;
    }
    
    /**
     * 
     * @param Win32Ap2VirtualHostItem[] $hosts
     */
    protected function updateFileVHosts($hosts) {
        $file = $this->pathHttpdVhosts;
        if(!file_exists($file)) {
            throw new ServerCommandException("File {$file} not found");
	}
        if(!is_writable($file)) {
            throw new ServerCommandException("File {$file} only read!");
        }
        $data = "NameVirtualHost {$this->baseNameVirtualHost}\n\n";
        foreach($hosts as $host) {
            $data .= $host->convertToHttpdVHosts();
            $data .= "\n\n";
        }
        file_put_contents($file, $data);
    }
    
    /**
     * 
     * @param IServerHostModel $model
     * @return \Win32Ap2VirtualHostItem
     */
    protected function getWin32Ap2VirtualHostItemInIServerHostModel(IServerHostModel $model) {
        $host = new Win32Ap2VirtualHostItem();
        $host->ip = $model->getIP();
        $host->port = $model->getPort();        
        $host->serverAdmin = $model->getServerAdmin();
	$host->documentRoot = $model->getDocumentRoot();
	$host->serverName = $model->getServerName();
	$host->serverAlias = $model->getServerAlias();
	$host->errorLog = $model->getErrorLog();
	$host->customLog = $model->getCustomLog();
        return $host;
    }

    /**
     * 
     * @return Win32Ap2VirtualHostItem[]
     * @throws ServerCommandException
     */
    protected function loadHosts() {
        $file = $this->pathHttpdVhosts;
        if(!file_exists($file)) {
            throw new ServerCommandException("File {$file} not found");
	}
	$hosts = array();
		
	$host = NULL;
	$linies = file($file);
	foreach($linies  as $line) {
			$line = trim($line);
			$char = substr($line, 0, 1);
			if($char == '#') {
				continue;
			}
			if($char == '<' && is_null($host)) {
				$host = new Win32Ap2VirtualHostItem();
				preg_match('/^\<\VirtualHost\s*(.*):([0-9]{1,})/u', $line, $matches); 
				$host->ip = $matches[1];
				$host->port = $matches[2]; 
			} else if($char == '<' && !is_null($host)) { 
				$hosts[$host->serverName] = $host;
				$host = NULL;
			} else if(!is_null($host)){
				preg_match('/^([a-zA-Z]*)\s*(.*)/u', $line, $matches); 
				list($a, $key, $value) = ($matches);
				if(strpos($value, '"') !== false) {
					preg_match('/\"(.*)\"/u', $value, $matches); 
					$value = $matches[1]; 		
				}
				$host->setAttribute($key, $value);
			}
	}
        return $hosts;
    }
}
