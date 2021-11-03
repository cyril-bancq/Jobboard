<?php

use App\App;

$pdo = require '../vendor/autoload.php';

$user = App::getAuth()->user();

if (isset($_POST['submit'])) {
    $pdo = App::getPDO();
}

$index = $router->url('index');
$register = $router->url('register');

$error = false;

if (!empty($_POST['name']) && !empty($_POST['first_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) 
{
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        $stmt = $pdo->prepare( "SELECT * FROM people WHERE email = ?");
        $stmt->execute([$email]);
        $userEmail= $stmt->fetch();
        if($userEmail) {
            header('Location: ' . $register . '?emailexist=1');
            exit();
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
            $queryRegisterForm = "INSERT INTO `people` (`name`, `first_name`, `email`, `password`) VALUES (:name,:first_name,:email,:password)";
            $res = $pdo->prepare($queryRegisterForm);
            $exec = $res->execute(array(":name" => $name, ":first_name" => $first_name, ":email" => $email, ":password" => $password));
            
            if ($exec) {
                header('Location: ' . $index . '?login=1');
                exit();
            } else {
                echo "Echec";
            }
        }
    } else {
        header('Location: ' . $register . '?password=1');
        exit();
    }
} 
$error = false;
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
    <title>Register</title>
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
        <?php if ($error): ?>
            <div class="text-center">
                <div class="alert alert-danger">You need to fill in all the information</div>
            </div>
        <?php endif ?>
        <?php if (isset($_GET['password'])): ?>
            <div class="text-center">
                <div class="alert alert-danger">Password do not match</div>
            </div>
        <?php endif ?>
        <?php if (isset($_GET['emailexist'])): ?>
            <div class="text-center">
                <div class="alert alert-danger">Email already exist</div>
            </div>
        <?php endif ?>
        <main>
        <div class="div_form" id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-6">
                        <div id="login-box" class="col-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 id="login_title" class="text-center form_text">Register</h3>
                                <div class="form-group" id="name_block">
                                    <label for="name" class="form_text">Name :</label><br>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group" id="first_name_block">
                                    <label for="first_name" class="form_text">First name :</label><br>
                                    <input type="text" name="first_name" id="first_name" class="form-control">
                                </div>
                                <div class="form-group" id="email_block">
                                    <label for="email" class="form_text">Email :</label><br>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group" id="password_block">
                                    <label for="password" class="form_text">Password :</label><br>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group" id="password_block">
                                    <label for="password" class="form_text">Confirm Password</label><br>
                                    <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                                </div>
                                <div class="row">
                                    <div id="register_link" class="col-auto">
                                        <button name="submit" class="form_text btn btn-primary">Register</button>
                                    </div>
                                    <div id="login_link" class="col-auto">
                                        <a href="<?= $router->url('login') ?>" class="form_text btn btn-warning">Login</a>
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