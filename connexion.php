<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "car_louage";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
} else {
    echo "Connexion réussie! 🎉";
}
?>