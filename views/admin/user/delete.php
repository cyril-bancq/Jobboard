<?php

use App\App;
use App\Table\UserTable;

require '../vendor/autoload.php';
$pdo = App::getPDO();
$table = new UserTable($pdo);
$table->delete($params['id']);
header('Location:' . $router->url('admin_user') . "?delete=1");
?>