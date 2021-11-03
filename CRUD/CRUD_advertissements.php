<?php

function dbConnect()
{
    try {
        $connexion = new PDO('mysql:host=localhost;dbname=jobboard', 'root', '');
        $connexion->query('SET NAMES UTF8');
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'erreur !:' . $e->getMessage() . '<br/>';
        exit();
    }
    return $connexion;
}

function SearchDB(string $col, string $condition)
{
    $sql = "SELECT $col FROM advertissements WHERE $condition";

    $stmt = dbConnect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->mysqli_stmt::get_result();
    $user = $result->fetchAll();
    return $user;
}

function RegisterDB(string $title, string $description, string $date, int $published, int $companies_id, string $contract_type, string $duration, int $salary, int $hour)
{
    $sql = "INSERT INTO advertissements VALUES ('', '$title', '$description', '$date', $published, $companies_id, '$contract_type', '$duration', $salary, $hour)";

    dbConnect()->exec($sql);
}

function DeleteDB(string $condition)
{
    $sql = "DELETE FROM advertissements WHERE $condition ";
    dbConnect()->exec($sql);
}

function UpdateDB(string $data, string $newData, string $condition)
{
    $sql = "UPDATE advertissements SET $data = '$newData' WHERE $condition";
    dbConnect()->exec($sql);
}

?>