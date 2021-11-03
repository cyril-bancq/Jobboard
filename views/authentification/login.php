<?php
session_start();

use App\App;

require '../vendor/autoload.php';

$auth = App::getAuth();
$user = App::getAuth()->user();
$companies = App::getAuth()->companie();

$error = false;

if (!empty($_POST)) {
    $user = $auth->loginUser($_POST['email'], $_POST['password']);
    $companies = $auth->loginCompanie($_POST['email'], $_POST['password']);
    if ($user || $companies) {
        header('Location: ' . $router->url('index') . '?login=1');
        exit();
    }
    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Login</title>
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
    <?php if ($error) : ?>
        <div class="alert alert-danger">
            Identifiant ou mot de passe incorrect
        </div>
    <?php endif ?>

    <?php if (isset($_GET['forbid'])) : ?>
        <div class="alert alert-danger">
            L'accès à la page est interdit
        </div>
    <?php endif ?>
    <main>
    <div class="div_form" id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-6">
                    <div id="login-box" class="col-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 id="login_title" class="text-center form_text">Login</h3>
                            <div class="form-group" id="email_block">
                                <label for="email" class="form_text">Email :</label><br>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group" id="password_block">
                                <label for="password" class="form_text">Password :</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group" id="remember_me_block">
                                <label for="remember-me" class="form_text"><span>Remember me</span>
                                    <span><input id="remember_me" name="remember-me" type="checkbox"></span>
                                </label><br>
                            </div>
                            <div class="row">
                                <div id="login_link" class="col-auto">
                                    <button class="form_text btn btn-primary">Login</button>
                                </div>
                                <div id="register_link" class="col-auto">
                                    <a href="<?= $router->url('register') ?>" class="form_text btn btn-warning">Register</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</body>
</html>