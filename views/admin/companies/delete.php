<?php

use App\App;
use App\Table\CompaniesTable;

require '../vendor/autoload.php';
$pdo = App::getPDO();
$table = new CompaniesTable($pdo);
$table->delete($params['id']);
header('Location:' . $router->url('admin_companies') . "?delete=1");
?>