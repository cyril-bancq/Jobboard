<?php

use App\App;
use App\Helpers\Post;

$id = (int)$params['id'];
$title = $params['slug'];

$pdo = App::getPDO();
App::getAuth()->requireRole('user', 'admin');
$query = $pdo->prepare('SELECT * FROM advertissements WHERE ads_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
$ads = $query->fetch();

if ($ads === false) {
    throw new Exception('Any advertissement found');
}


?>

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<div class="text-center">
    <h1>Job advertissement #<?= htmlentities($ads->getID()) ?></h5> 
    <h2><?= $ads->getTitle() ?></h2>
    <p class="text-muted"><?= $ads->getDate()->format('d F Y') ?></p>
    <p><?= $ads->getDescription() ?></p>
</div>