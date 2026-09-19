<?php
$host     = "mysql";
$user     = "root";
$password = "root";
$database = "car_louage";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
?>