<?php
$host     = "sql207.infinityfree.com";
$user     = "if0_41635783";
$password = "123yas321mine";  // same password you use to login to infinityfree
$database = "if0_41635783_car_louage";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
?>