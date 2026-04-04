<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'connexion.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$voyages  = null;
$searched = false;

if (isset($_GET['search'])) {
    $depart  = trim($_GET['ville_depart']);
    $arrivee = trim($_GET['ville_arrivee']);
    $date    = $_GET['date_voyage'];

    $sql = "SELECT * FROM voyages 
            WHERE ville_depart LIKE '%$depart%'
            AND ville_arrivee LIKE '%$arrivee%'
            AND places_dispo > 0";

    if (!empty($date)) {
        $sql .= " AND date_voyage = '$date'";
    }

    $sql .= " ORDER BY date_voyage ASC, heure_depart ASC";

    $voyages  = mysqli_query($conn, $sql);
    $searched = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche — Car & Louage</title>
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
      max-width: 700px;
      margin: 0 auto;
    }
    h1 { color: #004e64; margin-bottom: 0.3rem; }
    h2 { color: #004e64; margin: 2rem 0 1rem; font-size: 1.1rem; }
    p { color: #555; margin-bottom: 1rem; }
    a { color: #004e64; text-decoration: none; font-weight: bold; }
    a:hover { text-decoration: underline; }
    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      font-size: 0.88rem;
    }
    .form-group { margin-bottom: 1rem; }
    label {
      display: block;
      font-size: 0.85rem;
      color: #555;
      margin-bottom: 0.3rem;
    }
    input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid #ddd;
      border-radius: 8px;
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.2s;
    }
    input:focus { border-color: #004e64; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .btn {
      width: 100%;
      padding: 0.85rem;
      background: #004e64;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 0.5rem;
      transition: background 0.2s;
    }
    .btn:hover { background: #003347; }
    .error {
      background: #fdf0f0;
      color: #e74c3c;
      border: 1px solid #f5b7b1;
      border-radius: 8px;
      padding: 0.75rem;
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
    }
    .voyage-card {
      border: 1.5px solid #e0e0e0;
      border-radius: 10px;
      padding: 1rem 1.2rem;
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.8rem;
      transition: border-color 0.2s;
    }
    .voyage-card:hover { border-color: #004e64; }
    .voyage-route {
      font-weight: bold;
      font-size: 1.1rem;
      color: #004e64;
    }
    .voyage-info {
      font-size: 0.85rem;
      color: #666;
      margin-top: 0.3rem;
    }
    .btn-reserver {
      background: #004e64;
      color: white;
      padding: 0.5rem 1.2rem;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      font-size: 0.9rem;
      transition: background 0.2s;
      white-space: nowrap;
    }
    .btn-reserver:hover { background: #003347; text-decoration: none; }
    .badge-type {
      display: inline-block;
      padding: 0.2rem 0.6rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: bold;
    }
    .badge-louage { background: #e8f4f8; color: #004e64; }
    .badge-bus { background: #fff3e0; color: #e65100; }
  </style>
</head>
<body>
<div class="card">
  <div class="nav">
    <h1>🔍 Rechercher un voyage</h1>
    <div>
      Bonjour <strong><?= $_SESSION['nom'] ?></strong> |
      <a href="mes_reservations.php">Mes réservations</a> |
      <a href="logout.php">Déconnexion</a>
    </div>
  </div>

  <form method="GET">
    <div class="form-row">
      <div class="form-group">
        <label>Ville de départ</label>
        <input type="text" name="ville_depart"
               placeholder="ville  de depart"
               value="<?= $_GET['ville_depart'] ?? '' ?>" required />
      </div>
      <div class="form-group">
        <label>Ville d'arrivée</label>
        <input type="text" name="ville_arrivee"
               placeholder="ville d arrivee"
               value="<?= $_GET['ville_arrivee'] ?? '' ?>" required />
      </div>
    </div>
    <div class="form-group">
      <label>Date du voyage (optionnelle)</label>
      <input type="date" name="date_voyage"
             value="<?= $_GET['date_voyage'] ?? '' ?>" />
    </div>
    <input type="hidden" name="search" value="1">
    <button type="submit" class="btn">🔍 Rechercher</button>
  </form>

  <?php if ($searched): ?>
    <h2>Résultats</h2>
    <?php if (mysqli_num_rows($voyages) == 0): ?>
      <div class="error">😔 Aucun voyage trouvé pour cette recherche.</div>
    <?php else: ?>
      <?php while ($v = mysqli_fetch_assoc($voyages)): ?>
      <div class="voyage-card">
        <div>
          <div class="voyage-route">
            <?= $v['ville_depart'] ?> → <?= $v['ville_arrivee'] ?>
          </div>
          <div class="voyage-info">
            📅 <?= $v['date_voyage'] ?> &nbsp;
            🕐 <?= $v['heure_depart'] ?> &nbsp;
            💺 <?= $v['places_dispo'] ?> places &nbsp;
            💰 <?= $v['prix'] ?> TND &nbsp;
            <span class="badge-type badge-<?= $v['type_vehicule'] ?>">
              <?= $v['type_vehicule'] == 'louage' ? '🚗 Louage' : '🚌 Bus' ?>
            </span>
          </div>
        </div>
        <a href="reservation.php?id=<?= $v['id_voyage'] ?>"
           class="btn-reserver">Réserver</a>
      </div>
      <?php endwhile; ?>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
