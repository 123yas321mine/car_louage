<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include '../connexion.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    mysqli_query($conn, "DELETE FROM voyages WHERE id_voyage = '$id'");
    header("Location: liste_voyages.php");
    exit();
}

$voyages = mysqli_query($conn, "SELECT * FROM voyages ORDER BY date_voyage DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste Voyages — Admin</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 2rem; }
    .card {
      background: white; border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 2rem; max-width: 950px; margin: 0 auto;
    }
    h1 { color: #004e64; margin-bottom: 0.3rem; }
    .nav {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 1.5rem;
      flex-wrap: wrap; gap: 0.5rem;
    }
    a { color: #004e64; text-decoration: none; font-weight: bold; }
    a:hover { text-decoration: underline; }
    table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    th {
      background: #004e64; color: white;
      padding: 10px 8px; text-align: left;
    }
    td { padding: 8px; border-bottom: 1px solid #eee; vertical-align: middle; }
    tr:hover td { background: #f8f9fa; }
    .btn-add {
      display: inline-block; padding: 0.6rem 1.2rem;
      background: #2c6e49; color: white;
      border-radius: 8px; font-weight: bold;
    }
    .btn-add:hover { background: #1e5c3a; color: white; }
    .btn-modifier {
      background: #004e64; color: white;
      padding: 0.3rem 0.8rem; border-radius: 5px;
      font-size: 0.78rem; text-decoration: none;
    }
    .btn-modifier:hover { background: #003347; color: white; }
    .btn-supprimer {
      background: #e74c3c; color: white;
      padding: 0.3rem 0.8rem; border-radius: 5px;
      font-size: 0.78rem; text-decoration: none;
      margin-left: 0.3rem;
    }
    .btn-supprimer:hover { background: #c0392b; color: white; }
    .badge-type {
      display: inline-block; padding: 0.15rem 0.5rem;
      border-radius: 10px; font-size: 0.72rem; font-weight: bold;
    }
    .badge-louage { background: #e8f4f8; color: #004e64; }
    .badge-bus { background: #fff3e0; color: #e65100; }
    .empty { text-align: center; padding: 2rem; color: #888; }
  </style>
</head>
<body>
<div class="card">
  <div class="nav">
    <h1>📋 Liste des voyages</h1>
    <div>
      <a href="ajouter_voyage.php" class="btn-add">➕ Ajouter</a>
      &nbsp;
      <a href="dashboard.php">← Dashboard</a>
      &nbsp;
      <a href="../logout.php" style="color:#e74c3c;">Déconnexion</a>
    </div>
  </div>

  <table>
    <tr>
      <th>Départ</th>
      <th>Arrivée</th>
      <th>Date</th>
      <th>Heure</th>
      <th>Places</th>
      <th>Prix</th>
      <th>Type</th>
      <th>Actions</th>
    </tr>
    <?php if (mysqli_num_rows($voyages) == 0): ?>
    <tr><td colspan="8" class="empty">Aucun voyage disponible</td></tr>
    <?php else: ?>
    <?php while ($v = mysqli_fetch_assoc($voyages)): ?>
    <tr>
      <td><?= $v['ville_depart'] ?></td>
      <td><?= $v['ville_arrivee'] ?></td>
      <td><?= $v['date_voyage'] ?></td>
      <td><?= $v['heure_depart'] ?></td>
      <td><?= $v['places_dispo'] ?>/<?= $v['places_total'] ?></td>
      <td><?= $v['prix'] ?> TND</td>
      <td>
        <span class="badge-type badge-<?= $v['type_vehicule'] ?>">
          <?= $v['type_vehicule'] == 'louage' ? '🚗 Louage' : '🚌 Bus' ?>
        </span>
      </td>
      <td>
        <a href="modifier_voyage.php?id=<?= $v['id_voyage'] ?>"
           class="btn-modifier">✏️ Modifier</a>
        <a href="liste_voyages.php?supprimer=<?= $v['id_voyage'] ?>"
           class="btn-supprimer"
           onclick="return confirm('Voulez-vous vraiment supprimer ce voyage ?')">
           🗑 Supprimer
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
    <?php endif; ?>
  </table>
</div>
</body>
</html>