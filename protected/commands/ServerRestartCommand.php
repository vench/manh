<?php



/**
 * Класс ServerCommand команда перезапускающая сервер
 *
 * @author vench
 */
class ServerRestartCommand extends CConsoleCommand {
    
    public function run($args) {
        echo "Restart server\n";
         
        if(Settings::getServerRestart()) {
            Yii::app()->exec->stopServer();
            Yii::app()->exec->startServer();
            Settings::setServerRestart(FALSE);
        } 
    }
 
}
