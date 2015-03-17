<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - О системе';
$this->breadcrumbs=array(
	'О системе',
);
?>
<h1>О системе</h1>

<p>
    По умолчанию, приложение работает с эмулятором сервера. Для того, что бы использовать реальную стратегию работы с сервером, в конфигурационном файле нужно его яно указать. 
    Путь к файлу: <br><code>./protected/config/main.php</code> 
</p>
<pre>
    
'exec'=>array(
                    'class'=>'ext.servercommand.ServerCommand',
                    //Этот параметр необходимо изменить на какую либо реализацию
                    'serverStrategyClass'=>'BlankServerCommandStrategy',

                    //UbtAp2CommandStrategy - Возможная реализация для сервера Apache2 Ubuntu 14
                    //Win32Ap2CommandStrategy - Возможная реализация для сервера Apache2 Win 32
                    'serverStrategyOptions'=>array(
                        //мои настройки сервера на WIN 32 
                        'win32ap2commandstrategy'=>array(
                            'pathApache' => 'C:\\xampp\\apache',
                            'pathHttpdVhosts' => 'C:\\xampp\\apache\\conf\\extra\\httpd-vhosts.conf',
                            'baseNameVirtualHost' => '*:80',
                        ),
                        //мои настройки сервера на Ubuntu 14
                        'ubtap2commandstrategy'=>array(
                            'defaultAppach2Conf' => '/etc/apache2/sites-available/000-default.conf',
                            'appach2DirSitesAvail' => '/etc/apache2/sites-available/',
                        ),
                    ),
),
</pre>
<p>
    Так же, для реализации перезагрузки сервера, нужно установить планировшик с выбранным вами интервалом для скрипта: <br> <code>php ./protected/cron.php serverrestart</code> 
</p>
