<?php

use App\App;
use App\Table\UserTable;
use App\HTML\Form;
use App\Validators\UserValidator;
use App\ObjectHelper;

$pdo = App::getPDO();
$user = App::getAuth()->user();
$userTable = new UserTable($pdo);
App::getAuth()->requireRole('user', 'admin');
$users = $userTable->findByID($user->id);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new UserValidator($_POST, $userTable, $users->getID());
    ObjectHelper::hydrate($users, $_POST, ['name', 'first_name', 'email', 'address', 'postal_code', 'city', 'phone', 'birthdate', 'cv', 'website', 'description']);
    if ($v->validate()) {
        $userTable->update($users);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($users, $errors);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/profil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>My Profil</title>
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
    <div class="container rounded bg-white mt-5 mb-5" style="border: 2px solid #008dd5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?= $users->first_name ?></span><span class="text-black-50"><?= $users->email ?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">My Profil</h4>
                </div>
                <form action="" method="POST">
                <div class="row mt-3">
                    <div class="col-md-6"><?= $form->input('name', 'Name :'); ?></div>
                    <div class="col-md-6"><?= $form->input('first_name', 'First Name :'); ?></div>
                    <div class="col-md-12"><?= $form->input('phone', 'Phone number :'); ?></div>
                    <div class="col-md-12"><?= $form->input('address', 'Address :'); ?></div>
                    <div class="col-md-12"><?= $form->input('postal_code', 'Postal Code :'); ?></div>
                    <div class="col-md-12"><?= $form->input('city', 'City :'); ?></div>
                    <div class="col-md-12"><?= $form->input('email', 'Email :'); ?></div>
                    <div class="col-md-12"><?= $form->input('birthdate', 'Birthdate :'); ?></div>
                    <div class="col-md-6"><?= $form->input('cv', 'cv :'); ?></div>
                    <div class="col-md-6"><?= $form->input('website', 'website :'); ?></div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" onclick="return confirm('Do you really want edit your profil ?')">Save Profile</button></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5 mt-4">   
            <br><div class="col-md-12"><?= $form->textarea('description', 'Description :'); ?></div> <br>
            </div>
        </div>
            </form>
    </div>
</div>
</body>
</html>