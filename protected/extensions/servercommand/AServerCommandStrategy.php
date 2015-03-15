<?php


/**
 * Класс AServerCommandStrategy объявляетинтерфейс управления web сервером
 *
 * @author vench
 */
abstract class AServerCommandStrategy {
    
    /**
     *
     * @var ServerCommand
     */
    private $serverCommand;
    
    final public function __construct(ServerCommand $serverCommand) {
        $this->serverCommand = $serverCommand;
    }
    
    /**
     * 
     * @return ServerCommand
     */
    public function getServerCommand() {
        return $this->serverCommand;
    }
    
    abstract public function startServer();
    
    abstract public function stopServer();
    
    abstract public function restartServer();
    
    abstract public function addHost(IServerHostModel $model);
    
    abstract public function removeHost(IServerHostModel $model);
}
