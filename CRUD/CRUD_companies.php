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
    $sql = "SELECT $col FROM companies WHERE $condition";

    $stmt = dbConnect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->mysqli_stmt::get_result();
    $user = $result->fetchAll();
    return $user;
}

function RegisterDB(string $name, string $activities, string $address, int $postal_code, string $city, int $siret, string $password, int $number_employes, string $website, string $phone, string $email, string $contact_name)
{
    $sql = "INSERT INTO companies VALUES ('', '$name', '$activities', '$address', $postal_code, '$city', $siret, '$password', $number_employes, '$website', '$phone', '$email', '$contact_name')";

    dbConnect()->exec($sql);
}

function DeleteDB(string $condition)
{

    $sql = "DELETE FROM companies WHERE $condition ";
    dbConnect()->exec($sql);
}
function UpdateDB(string $data, string $newData, string $condition)
{
    $sql = "UPDATE companies SET $data = '$newData' WHERE $condition";
    dbConnect()->exec($sql);
}

?>
