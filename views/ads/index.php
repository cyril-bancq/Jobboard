<?php

use App\App;
use App\Helpers\Applied;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\AppliedTable;
use App\Table\PostTable;
use App\Validators\AppliedValidator;

$pdo = require '../vendor/autoload.php';
$pdo = App::getPDO();
App::getAuth()->requireRole('user', 'admin');
$user = App::getAuth()->user();

$table = new PostTable($pdo);
[$ads, $pagination]= $table->findPaginated();

$applied = new Applied();
$applied->setPeopleId($user->id);

$errors = [];



if (!empty($_POST)) {
    $pdo = App::getPDO();
    $appliedTable = new AppliedTable($pdo);
    $v = new AppliedValidator($_POST, $appliedTable, $applied->getId());
    ObjectHelper::hydrate($applied, $_POST, ['motivation_people', 'people_id', 'advertissement_id']);
    if ($v->validate()) {
        $appliedTable->create($applied);
        header('Location: ' . $router->url('ads') . "?applied=1");
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($applied, $errors);

$link = $router->url('ads');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/advertissement.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Advertissements</title>
</head>    
<body>
    <header class="index_header">
        <nav class="nav">
            <a class="nav_alogo" href="<?= $router->url('index') ?>"><img class="nav_logo" src="/image/logo.png"></a>
            <a class="nav_advertissement" href="<?= $router->url('ads') ?>">Advertissement</a>
            <a class="nav_companies" href="<?= $router->url('companies') ?>">Companies</a>
            <a class="nav_people" href="<?= $router->url('myprofil') ?>">Profil</a>
            <?php if ($user): ?>
            <a class="nav_welcome"><?= "Name : " . "<strong> $user->first_name </strong>" . " - " . "Role : " . "<strong> $user->role </strong>" ?></a>
            <?php endif ?>
            <?php if (!$user): ?>
            <a class="nav_login" href="<?= $router->url('login') ?>">Login</a>
            <?php endif ?>
            <?php if ($user || isset($_GET['login'])): ?>
            <a class="nav_space" href="">|</a>
            <a class="nav_logout" href="<?= $router->url('logout') ?>">Logout</a>
            <?php endif ?>
            <a href="<?= $router->url('admin_ads') ?>" class="btn btn-danger">Admin</a>
        </nav>
    </header>
    <main>
        <?php if (isset($_GET['applied'])): ?>
        <div class="text-center">
            <div class="alert alert-success">You have applied for this position</div>
        </div>
        <?php endif ?>
          <div class="row mx-2">
            <?php foreach($ads as $ad): ?>
                <?php $applied->setAdvertissementId($ad->getId()) ?>
              <div class="col-md-3">
                <?php require 'card.php' ?>
              </div>
              <?php endforeach ?>
          </div>
    </main>
    <div class="d-flex justify-content-evenly my-4">
        <?= $pagination->previousPage($link); ?>
        <?= $pagination->nextPage($link); ?>
    </div>
</body>
</html>