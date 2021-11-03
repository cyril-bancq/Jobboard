<?php

use App\App;
use App\Table\CompaniesTable;

require '../vendor/autoload.php';
$pdo = App::getPDO();
$user = App::getAuth()->user();
App::getAuth()->requireRole('admin');

[$companies, $pagination] = (new CompaniesTable($pdo))->findPaginated();

$link = $router->url('admin_companies');

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
    <main class="container mt-2">
    <?php if (isset($_GET['delete'])): ?>
        <div class="text-center">
            <div class="alert alert-success">Companies Deleted</div>
        </div>
    <?php endif ?>
        <table class="table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Siret</th>
                <th>Email</th>
                <th>
                    <a href="<?= $router->url("admin_companies_new") ?>" class="btn btn-primary">Create</a>
                </th>
            </thead>
            <tbody>
                <?php foreach($companies as $companie): ?>
                <tr>
                    <td>#<?= htmlentities($companie->getId()) ?></td>
                    <td>
                        <a href="<?= $router->url('admin_companies_edit', ['id' => $companie->getId()]) ?>" class="text-decoration-none">
                        <?= htmlentities($companie->getName()) ?>
                        </a>
                    </td>
                    <td><?= htmlentities($companie->getSiret()) ?></td>
                    <td><?= htmlentities($companie->getEmail()) ?></td>
                    <td>
                        <a href="<?= $router->url('admin_companies_edit', ['id' => $companie->getId()]) ?>" class="btn btn-primary">
                        Edit
                        </a>
                        <form action="<?= $router->url('admin_companies_delete', ['id' => $companie->getId()]) ?>" method="POST"  onsubmit="return confirm('Do you really want to perform this action ?')" style="display: inline">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
    <div class="d-flex justify-content-evenly my-4">
        <?= $pagination->previousPage($link); ?>
        <?= $pagination->nextPage($link); ?>
    </div>
</body>
</html>