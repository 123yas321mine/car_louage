<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include '../connexion.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";
$erreur  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depart  = trim($_POST['ville_depart']);
    $arrivee = trim($_POST['ville_arrivee']);
    $date    = $_POST['date_voyage'];
    $heure   = $_POST['heure_depart'];
    $places  = $_POST['places_total'];
    $prix    = $_POST['prix'];
    $type    = $_POST['type_vehicule'];

    $sql = "INSERT INTO voyages 
            (ville_depart, ville_arrivee, date_voyage, heure_depart,
             places_total, places_dispo, prix, type_vehicule)
            VALUES 
            ('$depart', '$arrivee', '$date', '$heure',
             '$places', '$places', '$prix', '$type')";

    if (mysqli_query($conn, $sql)) {
        $message = "Voyage ajouté avec succès !";
    } else {
        $erreur = "Erreur: " . mysqli_error($conn);
    }
}

$voyages = mysqli_query($conn, "SELECT * FROM voyages ORDER BY date_voyage DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter Voyage — Car & Louage</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
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
    .back { color: #888; font-size: 0.88rem; text-decoration: none; display: inline-block; margin-bottom: 1.5rem; }
    .back:hover { color: #004e64; }
    .form-group { margin-bottom: 1rem; }
    label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 0.3rem; }
    input, select {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid #ddd;
      border-radius: 8px;
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.2s;
    }
    input:focus, select:focus { border-color: #004e64; }
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
    .btn:hover { background: #003d4f; }
    .success {
      background: #eafaf1;
      color: #27ae60;
      border: 1px solid #a9dfbf;
      border-radius: 8px;
      padding: 0.75rem;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    .error {
      background: #fdf0f0;
      color: #004e64;
      border: 1px solid #b3d9e0;
      border-radius: 8px;
      padding: 0.75rem;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    h2 { color: #333; margin: 2rem 0 1rem; font-size: 1.1rem; }
    table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    th { background: #f5f5f5; padding: 8px; border: 1px solid #ddd; text-align: left; }
    td { padding: 8px; border: 1px solid #ddd; }
    tr:hover td { background: #fafafa; }
  </style>
</head>
<body>
<div class="card">
  <h1>➕ Ajouter un voyage</h1>
  <a href="dashboard.php" class="back">← Retour au dashboard</a>

  <?php if ($message): ?>
    <div class="success">✅ <?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($erreur): ?>
    <div class="error">❌ <?php echo $erreur; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-row">
      <div class="form-group">
        <label>Ville de départ</label>
        <input type="text" name="ville_depart" placeholder="Ex: Tunis" required />
      </div>
      <div class="form-group">
        <label>Ville d'arrivée</label>
        <input type="text" name="ville_arrivee" placeholder="Ex: Sfax" required />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Date du voyage</label>
        <input type="date" name="date_voyage" required />
      </div>
      <div class="form-group">
        <label>Heure de départ</label>
        <input type="time" name="heure_depart" required />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Nombre de places</label>
        <input type="number" name="places_total" min="1" placeholder="Ex: 6" required />
      </div>
      <div class="form-group">
        <label>Prix (TND)</label>
        <input type="number" name="prix" step="0.001" placeholder="Ex: 12.500" required />
      </div>
    </div>
    <div class="form-group">
      <label>Type de véhicule</label>
      <select name="type_vehicule" required>
        <option value="louage">🚗 Louage</option>
        <option value="bus">🚌 Bus</option>
      </select>
    </div>
    <button type="submit" class="btn">Ajouter le voyage</button>
  </form>

  <h2>📋 Liste des voyages</h2>
  <table>
    <tr>
      <th>Départ</th>
      <th>Arrivée</th>
      <th>Date</th>
      <th>Heure</th>
      <th>Places</th>
      <th>Prix</th>
      <th>Type</th>
    </tr>
    <?php while ($v = mysqli_fetch_assoc($voyages)): ?>
    <tr>
      <td><?= $v['ville_depart'] ?></td>
      <td><?= $v['ville_arrivee'] ?></td>
      <td><?= $v['date_voyage'] ?></td>
      <td><?= $v['heure_depart'] ?></td>
      <td><?= $v['places_dispo'] ?>/<?= $v['places_total'] ?></td>
      <td><?= $v['prix'] ?> TND</td>
      <td><?= $v['type_vehicule'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
