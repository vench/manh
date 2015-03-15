<?php

 

/**
 * Класс BlankServerCommandStrategy не реализует никакой стратегии сервера, а является пустышкой для тестирования кода
 *
 * @author vench
 */
class BlankServerCommandStrategy extends AServerCommandStrategy {
    public function startServer() {}
    
    public function stopServer() {}
    
    public function restartServer() {}
    
    public function addHost(IServerHostModel $model) {}
    
    public function removeHost(IServerHostModel $model) {}
}
