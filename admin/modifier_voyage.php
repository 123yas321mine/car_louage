<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include '../connexion.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = (int)$_GET['id'] ?? 0;

$result = mysqli_query($conn, "SELECT * FROM voyages WHERE id_voyage = '$id'");
$voyage = mysqli_fetch_assoc($result);

if (!$voyage) {
    header("Location: liste_voyages.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depart  = trim($_POST['ville_depart']);
    $arrivee = trim($_POST['ville_arrivee']);
    $date    = $_POST['date_voyage'];
    $heure   = $_POST['heure_depart'];
    $places  = $_POST['places_total'];
    $prix    = $_POST['prix'];
    $type    = $_POST['type_vehicule'];

    $sql = "UPDATE voyages SET
            ville_depart  = '$depart',
            ville_arrivee = '$arrivee',
            date_voyage   = '$date',
            heure_depart  = '$heure',
            places_total  = '$places',
            prix          = '$prix',
            type_vehicule = '$type'
            WHERE id_voyage = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: liste_voyages.php");
        exit();
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Voyage — Admin</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif; background: #f0f2f5;
      min-height: 100vh; display: flex;
      align-items: center; justify-content: center; padding: 2rem;
    }
    .card {
      background: white; border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 2.5rem; width: 100%; max-width: 550px;
    }
    h1 { color: #004e64; margin-bottom: 0.3rem; }
    .back {
      color: #888; font-size: 0.88rem;
      text-decoration: none; display: inline-block; margin-bottom: 1.5rem;
    }
    .form-group { margin-bottom: 1rem; }
    label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 0.3rem; }
    input, select {
      width: 100%; padding: 0.75rem 1rem;
      border: 1.5px solid #ddd; border-radius: 8px;
      font-size: 0.95rem; outline: none; transition: border-color 0.2s;
    }
    input:focus, select:focus { border-color: #004e64; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .btn {
      width: 100%; padding: 0.85rem;
      background: #004e64; color: white; border: none;
      border-radius: 8px; font-size: 1rem; font-weight: bold;
      cursor: pointer; transition: background 0.2s;
    }
    .btn:hover { background: #003347; }
    .error {
      background: #fdf0f0; color: #e74c3c;
      border: 1px solid #f5b7b1; border-radius: 8px;
      padding: 0.75rem; text-align: center; margin-bottom: 1rem;
    }
  </style>
</head>
<body>
<div class="card">
  <h1>✏️ Modifier un voyage</h1>
  <a href="liste_voyages.php" class="back">← Retour à la liste</a>

  <?php if ($message): ?>
    <div class="error">❌ <?= $message ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-row">
      <div class="form-group">
        <label>Ville de départ</label>
        <input type="text" name="ville_depart"
               value="<?= $voyage['ville_depart'] ?>" required />
      </div>
      <div class="form-group">
        <label>Ville d'arrivée</label>
        <input type="text" name="ville_arrivee"
               value="<?= $voyage['ville_arrivee'] ?>" required />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Date</label>
        <input type="date" name="date_voyage"
               value="<?= $voyage['date_voyage'] ?>" required />
      </div>
      <div class="form-group">
        <label>Heure</label>
        <input type="time" name="heure_depart"
               value="<?= $voyage['heure_depart'] ?>" required />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Places total</label>
        <input type="number" name="places_total"
               value="<?= $voyage['places_total'] ?>" required />
      </div>
      <div class="form-group">
        <label>Prix (TND)</label>
        <input type="number" name="prix" step="0.001"
               value="<?= $voyage['prix'] ?>" required />
      </div>
    </div>
    <div class="form-group">
      <label>Type de véhicule</label>
      <select name="type_vehicule">
        <option value="louage" <?= $voyage['type_vehicule']=='louage' ? 'selected' : '' ?>>
          🚗 Louage
        </option>
        <option value="bus" <?= $voyage['type_vehicule']=='bus' ? 'selected' : '' ?>>
          🚌 Bus
        </option>
      </select>
    </div>
    <button type="submit" class="btn">💾 Enregistrer les modifications</button>
  </form>
</div>
</body>
</html>