<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = new PDO('mysql:host=localhost;dbname=jobboard', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO advertissements (`title`, `description`, `date`, `published`, `companies_id`, `contract_type`, `duration`, `salary`, `hour`) VALUES ('Advertissement #$i', 'We are article numbre #$i', '2021-10-12', 1, 10, 'Alternance', '3 years', 5000, 39)");
}
?>