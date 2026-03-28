<<<<<<< HEAD
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
=======
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
>>>>>>> a61736a70788c7030ddd0726fd0540e9677f32f9
?>