<?php
use App\App;

require '../vendor/autoload.php';
$pdo = App::getPDO();
$user = App::getAuth()->user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Les Bons Jobs</title>
</head>    
<body>
    <header class="index_header">
        <nav class="nav">
            <a class="nav_alogo" href="<?= $router->url('index') ?>"><img class="nav_logo" src="image/logo.png"></a>
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
    <main class="index_main">
        <div class="div_index_form">
        <?php if ($user && isset($_GET['login'])): ?>
        <div class="text-center">
                <div class="alert alert-success">Welcome <?= $user->first_name ?></div>
        </div>
        <?php endif ?>
            <div class="primary_title">
                <h1>Our ads your knowledge.</h1>
            </div>
            <div class="div_form">
                <form class="index_form" method="GET">
                    <input class="form-control" type="text" id="what" name="what" placeholder="Post or companies" required>
                    <input class="form-control" type="text" id="where" name="where" placeholder="Localisation" required>
                    <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>

            <div class="cv_title">
                <a class="p_secondary_title" href="login.html"><p>Post your cv - It only takes a few clicks</p></a>
            </div>
            <div class="companies_title">
                <a class="p_secondary_title" href="login.html"><p>Companies : Post an ads - Our talents close to you</p></a>
            </div>
        </div>
    </main>
    <a href="<?= $router->url() ?>"></a>
</body>
</html>