<?php
define('TGS_START', microtime(true));
define('TGS_ROOT', __DIR__);
define('TGS_ROOT_URL', explode('/', $_SERVER['PHP_SELF'])[1]);

require TGS_ROOT .'/core/vendor/autoload.php';

require_once TGS_ROOT .'/core/bootstrap/app.php';
require_once TGS_ROOT  . '/core/routes/Router.php';
?>
