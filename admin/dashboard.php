<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin — Car & Louage</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
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
    h1 { color: #004e64; margin-bottom: 0.5rem; }
    p { color: #777; margin-bottom: 2rem; }
    .btn {
      display: block;
      width: 100%;
      padding: 0.85rem;
      background: #004e64;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      margin-bottom: 1rem;
      transition: background 0.2s;
    }
    .btn:hover { background: #003d4f; }
    .btn.secondary {
      background: #95a5a6;
    }
    .btn.secondary:hover { background: #7f8c8d; }
    .logout {
      margin-top: 1rem;
      font-size: 0.88rem;
      color: #888;
    }
    .logout a { color: #004e64; text-decoration: none; }
  </style>
</head>
<body>
<div class="card">
  <h1>⚙️ Dashboard Admin</h1>
  <p>Bienvenue, <strong><?= $_SESSION['nom'] ?></strong> 👋</p>

  <a href="ajouter_voyage.php" class="btn">➕ Ajouter un voyage</a>
  <a href="liste_voyages.php" class="btn secondary">📋 Voir tous les voyages</a>

  <div class="logout">
    <a href="../logout.php">Se déconnecter</a>
  </div>
</div>
</body>
</html>