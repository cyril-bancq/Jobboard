<?php

use App\App;
use App\Helpers\Companies;
use App\Table\CompaniesTable;
use App\HTML\Form;
use App\Validators\CompaniesValidator;
use App\ObjectHelper;

$user = App::getAuth()->user();
$errors = [];
$companies = new Companies();
App::getAuth()->requireRole('admin');

if (!empty($_POST)) {
    $pdo = App::getPDO();
    $companiesTable = new CompaniesTable($pdo);
    $v = new CompaniesValidator($_POST, $companiesTable, $companies->getId());
    ObjectHelper::hydrate($companies, $_POST, ['name', 'activities', 'address', 'postal_code', 'city', 'siret', 'password', 'number_employes', 'website', 'phone', 'email', 'contact_name']);
    if ($v->validate()) {
        $companiesTable->create($companies);
        header('Location: ' . $router->url('admin_companies_edit', ['id' => $companies->getId()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($companies, $errors);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Admin</title>
</head>
<body>
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
    <?php if (!empty($errors)): ?>
        <div class="text-center">
            <div class="alert alert-danger">This companie has not been created, please correct your mistakes</div>
        </div>
    <?php endif ?>
    <h3>Create a Companie</h3>
    <?php require('_companies.php') ?>
    </main>
</body>
</html>