<?php
define('TGS_START', microtime(true));
define('TGS_ROOT', __DIR__);
define('TGS_ROOT_URL', explode('/', $_SERVER['PHP_SELF'])[1]);

require TGS_ROOT .'/core/vendor/autoload.php';

$system = system_instance();
$system->bootRoute();
?>
