<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil — Car & Louage</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 2.5rem; text-align: center; max-width: 420px; width: 100%; }
    h1 { color: #004e64; margin-bottom: 1rem; }
    p { color: #555; margin-bottom: 1rem; }
    a { color: #004e64; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>
<div class="card">
  <h1>🚌 Car&Louage</h1>
  <p>Bienvenue, <strong><?= $_SESSION['nom'] ?></strong> ! 👋</p>
  <p>Rôle : <?= $_SESSION['role'] ?></p>
  <a href="logout.php">Se déconnecter</a>
</div>
</body>
</html>