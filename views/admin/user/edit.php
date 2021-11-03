<?php

use App\App;
use App\Table\UserTable;
use App\HTML\Form;
use App\Validators\UserValidator;
use App\ObjectHelper;

$pdo = App::getPDO();
$user = App::getAuth()->user();
$userTable = new UserTable($pdo);
App::getAuth()->requireRole('admin');
$users = $userTable->findByID($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new UserValidator($_POST, $userTable, $users->getId());
    ObjectHelper::hydrate($users, $_POST, ['name', 'first_name', 'email', 'address', 'postal_code', 'city', 'phone', 'birthdate', 'cv', 'website', 'password','description']);
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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Admin</title>
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a href="<?= $router->url('admin_ads') ?>" class="navbar-brand">Panel Admin</a>
           <ul class="navbar-nav">
               <li>
                   <a class="nav-link" href="<?= $router->url('admin_ads') ?>">Advertissements</a>
               </li>
               <li>
                   <a class="nav-link" href="<?= $router->url('admin_user') ?>">User</a>
               </li>
               <li>
                   <a class="nav-link" href="<?= $router->url('admin_companies') ?>">Companies</a>
               </li>
               <li class="nav-item">
                <?php if ($user): ?>
                    <a class="nav-link active"><?= "Name : " . "<strong> $user->first_name </strong>" . " - " . "Role : " . "<strong> $user->role </strong>"?></a>
                <?php endif ?>
               </li>
               <li class="nav-item">
                   <form action="<?= $router->url('logout') ?>" method="POST" style="display:inline">
                        <button type="submit" class="nav-link" style="background:transparent; border:none;">Logout</button>
                   </form>
               </li>
           </ul>
        </nav>
    </header>
    <main class="container mt-4">
    <?php if ($success): ?>
        <div class="text-center">
            <div class="alert alert-success">This user has been modified</div>
        </div>
    <?php endif ?>
    <?php if (!empty($errors)): ?>
        <div class="text-center">
            <div class="alert alert-danger">This user has not been modified please fill in the fields</div>
        </div>
    <?php endif ?>
    <?php if (isset($_GET['created'])): ?>
        <div class="text-center">
            <div class="alert alert-success">This user has been created</div>
        </div>
    <?php endif ?>
    <h3>User : <?= htmlentities($users->getFirstname() . " " . $users->getName()) ?></h3>
    <?php require('_user.php') ?>
    </main>
</body>
</html>