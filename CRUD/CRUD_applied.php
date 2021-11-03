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
    $sql = "SELECT $col FROM applied WHERE $condition";

    $stmt = dbConnect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->mysqli_stmt::get_result();
    $user = $result->fetchAll();
    return $user;
}

function RegisterDB(int $advertissement_id, int $people_id, string $motivation_people)
{
    $sql = "INSERT INTO applied VALUES ('', '$advertissement_id', '$people_id', '$motivation_people')";

    dbConnect()->exec($sql);
}

function DeleteDB(string $condition)
{
    $sql = "DELETE FROM applied WHERE $condition ";
    dbConnect()->exec($sql);
}

function UpdateDB(string $data, string $newData, string $condition)
{
    $sql = "UPDATE applied SET $data = '$newData' WHERE $condition";
    dbConnect()->exec($sql);
}

?>
