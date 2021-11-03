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
    $sql = "SELECT $col FROM people WHERE $condition";

    $stmt = dbConnect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->mysqli_stmt::get_result();
    $user = $result->fetchAll();
    return $user;
}

function RegisterDB(string $name, string $first_name, string $password, string $email, string $address, int $postal_code, string $city, string $phone, string $birth_date, string $cv, string $website, string $picture, string $gender)
{
    $sql = "INSERT INTO people VALUES ('', '$name', '$first_name', '$password', '$email', '$address', $postal_code, '$city', '$phone', '$birth_date', '$cv', '$website', '$picture', '$gender')";

    dbConnect()->exec($sql);
}

function DeleteDB(string $condition)
{
    $sql = "DELETE FROM people WHERE $condition ";
    dbConnect()->exec($sql);
}

function UpdateDB(string $data, string $newData, string $condition)
{
    $sql = "UPDATE people SET $data = '$newData' WHERE $condition";
    dbConnect()->exec($sql);
}

?>