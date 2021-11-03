<?php

use App\App;
use App\Table\PostTable;

require '../vendor/autoload.php';
$pdo = App::getPDO();
$table = new PostTable($pdo);
$table->delete($params['id']);
header('Location:' . $router->url('admin_ads') . "?delete=1");
?>