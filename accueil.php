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
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 2.5rem;
      width: 100%;
      max-width: 500px;
      text-align: center;
    }
    .logo {
      font-size: 2rem;
      font-weight: bold;
      color: #004e64;
      margin-bottom: 0.3rem;
    }
    .welcome {
      color: #777;
      font-size: 1rem;
      margin-bottom: 2rem;
    }
    .welcome strong { color: #004e64; }
    .nav-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .nav-btn {
      display: block;
      padding: 1.2rem 1rem;
      background: #004e64;
      color: white;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      font-size: 0.95rem;
      transition: background 0.2s;
    }
    .nav-btn:hover { background: #003347; }
    .nav-btn .icon {
      display: block;
      font-size: 1.8rem;
      margin-bottom: 0.4rem;
    }
    .logout {
      display: inline-block;
      margin-top: 1.2rem;
      color: #e74c3c;
      text-decoration: none;
      font-size: 0.88rem;
    }
    .logout:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="card">
  <div class="logo">🚌 Car&Louage</div>
  <p class="welcome">
    Bienvenue, <strong><?= $_SESSION['nom'] ?></strong> !
  </p>

  <div class="nav-grid">
    <a href="recherche.php" class="nav-btn">
      <span class="icon">🔍</span>
      Rechercher un voyage
    </a>
    <a href="mes_reservations.php" class="nav-btn">
      <span class="icon">🎫</span>
      Mes réservations
    </a>
  </div>

  <a href="logout.php" class="logout">Se déconnecter</a>
</div>
</body>
</html>