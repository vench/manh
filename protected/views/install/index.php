<?php
/* @var $this InstallController */

$this->breadcrumbs=array(
	'Инсталлятор',
);
?>
<h1>Инсталлятор</h1>


<?php
$ok = TRUE;
foreach($status as $st) {
    list($key, $text) = $st;
    if($ok && $key != 'ok') {
        $ok = FALSE;
    }
    ?>
<div class="<?php if($key == 'ok'):?>flash-success <?php else: ?>flash-error<?php endif;?> ">
  <?php echo $text; ?>
</div>
 <?php
}


if($ok) {
    ?>
<div class="flash-success">
  Система успешно установлена. Для продолжения перейдите на  <?php echo CHtml::link('главную страницу', array('/site/index')); ?>.
</div>
<?php
}
?>

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