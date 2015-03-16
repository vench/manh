<?php



/**
 * Description of VirtualHost
 *
 * @author vench
 */
class Win32Ap2VirtualHostItem {
        public $ip = '*';
	public $port = 80;
	public $serverAdmin = 'admin@localhost';
	public $documentRoot = '';
	public $serverName = '';
	public $serverAlias = '';
	public $errorLog = '';
	public $customLog = '';
        
        /**
         * 
         * @param type $name
         * @param type $value
         */
        public function setAttribute($name, $value) {
		switch(strtolower($name)) {
                        case 'ip':
				$this->ip = $value;
				break;
                        case 'port':
				$this->port = $value;
				break;
                    
			case 'serveradmin':
				$this->serverAdmin = $value;
				break;
			case 'documentroot':
				$this->documentRoot = $value;
				break;
			case 'servername':
				$this->serverName = $value;
				break;
			case 'serveralias':
				$this->serveralias = $value;
				break;
			case 'errorlog':
				$this->errorLog = $value;
				break;
			case 'customlog':
				$this->customLog = $value;
				break;
			default:  
				break;
		}		
	} 
        
        public function convertToHttpdVHosts() {
		$str = "<VirtualHost {$this->ip}:{$this->port}>\n";
		$str .= "\tServerAdmin {$this->serverAdmin}\n";
		$str .= "\tDocumentRoot \"{$this->documentRoot}\"\n";
		$str .= "\tServerName {$this->serverName}\n";
		$str .= "\tErrorLog \"{$this->errorLog}\"\n";
		$str .= "\tCustomLog \"{$this->customLog}\" common\n";
		$str .= "</VirtualHost>\n";
		
		return $str;
	}
}
