<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'connexion.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$sql = "SELECT r.*, 
        v.ville_depart, v.ville_arrivee, 
        v.date_voyage, v.heure_depart, 
        v.prix, v.type_vehicule
        FROM reservations r
        INNER JOIN voyages v ON r.id_voyage = v.id_voyage
        WHERE r.id_user = '$id_user'
        ORDER BY r.date_reservation DESC";

$reservations = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Réservations — Car & Louage</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      padding: 2rem;
    }
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 2.5rem;
      max-width: 800px;
      margin: 0 auto;
    }
    h1 { color: #004e64; margin-bottom: 0.3rem; }
    p { color: #555; margin-bottom: 1rem; }
    a { color: #004e64; text-decoration: none; font-weight: bold; }
    a:hover { text-decoration: underline; }
    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .total {
      background: #f0f8ff;
      border: 1.5px solid #b8d8e8;
      border-radius: 8px;
      padding: 0.8rem 1.2rem;
      margin-bottom: 1.5rem;
      font-size: 0.88rem;
      color: #004e64;
      font-weight: bold;
    }
    .res-card {
      border: 1.5px solid #e0e0e0;
      border-radius: 10px;
      padding: 1.2rem 1.5rem;
      margin-bottom: 1rem;
      transition: border-color 0.2s;
    }
    .res-card:hover { border-color: #004e64; }
    .res-route {
      font-size: 1.1rem;
      font-weight: bold;
      color: #004e64;
      margin-bottom: 0.5rem;
    }
    .res-info {
      font-size: 0.85rem;
      color: #666;
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 0.5rem;
    }
    .res-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 0.8rem;
      font-size: 0.82rem;
      color: #888;
      border-top: 1px solid #f0f0f0;
      padding-top: 0.8rem;
    }
    .badge-status {
      display: inline-block;
      padding: 0.2rem 0.7rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: bold;
    }
    .badge-confirm {
      background: #eafaf1;
      color: #27ae60;
      border: 1px solid #a9dfbf;
    }
    .badge-annule {
      background: #fdf0f0;
      color: #e74c3c;
      border: 1px solid #f5b7b1;
    }
    .badge-type {
      display: inline-block;
      padding: 0.2rem 0.6rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: bold;
    }
    .badge-louage { background: #e8f4f8; color: #004e64; }
    .badge-bus { background: #fff3e0; color: #e65100; }
    .empty-box {
      text-align: center;
      padding: 3rem;
      color: #888;
    }
    .btn {
      display: inline-block;
      padding: 0.75rem 1.5rem;
      background: #004e64;
      color: white;
      border-radius: 8px;
      font-weight: bold;
      margin-top: 1rem;
      transition: background 0.2s;
    }
    .btn:hover { background: #003347; text-decoration: none; color: white; }
  </style>
</head>
<body>
<div class="card">
  <div class="nav">
    <h1>🎫 Mes Réservations</h1>
    <div style="font-size:0.88rem">
      Bonjour <strong><?= $_SESSION['nom'] ?></strong> |
      <a href="recherche.php">🔍 Rechercher</a> |
      <a href="logout.php">Déconnexion</a>
    </div>
  </div>

  <?php
  $nb = mysqli_num_rows($reservations);
  if ($nb == 0): ?>
    <div class="empty-box">
      <p style="font-size:3rem">🎫</p>
      <p>Vous n'avez encore aucune réservation.</p>
      <a href="recherche.php" class="btn">🔍 Rechercher un voyage</a>
    </div>
  <?php else: ?>
    <div class="total">
      Vous avez <?= $nb ?> réservation(s) au total
    </div>

    <?php while ($r = mysqli_fetch_assoc($reservations)): ?>
    <div class="res-card">
      <div class="res-route">
        <?= $r['ville_depart'] ?> → <?= $r['ville_arrivee'] ?>
      </div>
      <div class="res-info">
        <span>📅 <?= $r['date_voyage'] ?></span>
        <span>🕐 <?= $r['heure_depart'] ?></span>
        <span>💰 <?= $r['prix'] ?> TND</span>
        <span>
          <span class="badge-type badge-<?= $r['type_vehicule'] ?>">
            <?= $r['type_vehicule'] == 'louage' ? '🚗 Louage' : '🚌 Bus' ?>
          </span>
        </span>
      </div>
      <div class="res-footer">
        <span>Réservé le : <?= $r['date_reservation'] ?></span>
        <span class="badge-status <?= $r['statut'] == 'confirmée' ? 'badge-confirm' : 'badge-annule' ?>">
          <?= $r['statut'] == 'confirmée' ? '✅ Confirmée' : '❌ Annulée' ?>
        </span>
      </div>
    </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>
</body>
</html>