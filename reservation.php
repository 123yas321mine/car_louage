<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'connexion.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_voyage = (int)$_GET['id'] ?? 0;
$id_user   = $_SESSION['id_user'];

if ($id_voyage == 0) {
    header("Location: recherche.php");
    exit();
}

$sql    = "SELECT * FROM voyages WHERE id_voyage = '$id_voyage'";
$result = mysqli_query($conn, $sql);
$voyage = mysqli_fetch_assoc($result);

if (!$voyage) {
    header("Location: recherche.php");
    exit();
}

$message = "";
$erreur  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($voyage['places_dispo'] <= 0) {
        $erreur = "Désolé, ce voyage est complet !";
    } else {
        $check = mysqli_query($conn,
            "SELECT * FROM reservations 
             WHERE id_user = '$id_user' 
             AND id_voyage = '$id_voyage' 
             AND statut = 'confirmée'");

        if (mysqli_num_rows($check) > 0) {
            $erreur = "Vous avez déjà réservé ce voyage !";
        } else {
            $ins = mysqli_query($conn,
                "INSERT INTO reservations (id_user, id_voyage) 
                 VALUES ('$id_user', '$id_voyage')");
            

            if ($ins) {
               $upd = mysqli_query($conn,
                     "UPDATE voyages 
                     SET places_dispo = places_dispo - 1 
                      WHERE id_voyage = '$id_voyage'");

               if (!$upd) {
                     echo "UPDATE error: " . mysqli_error($conn);
        }

                $message = "Réservation confirmée avec succès !";
                
                

                $result = mysqli_query($conn,
                    "SELECT * FROM voyages WHERE id_voyage = '$id_voyage'");
                $voyage = mysqli_fetch_assoc($result);
            } else {
                $erreur = "Erreur lors de la réservation.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation — Car & Louage</title>
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
    }
    h1 { color: #004e64; margin-bottom: 0.3rem; }
    p { color: #555; margin-bottom: 0.5rem; }
    a { color: #004e64; text-decoration: none; font-weight: bold; }
    a:hover { text-decoration: underline; }
    .back { color: #888; font-size: 0.88rem; display: inline-block; margin-bottom: 1.5rem; font-weight: normal; }
    .voyage-details {
      background: #f0f8ff;
      border: 1.5px solid #b8d8e8;
      border-radius: 10px;
      padding: 1.2rem 1.5rem;
      margin-bottom: 1.5rem;
    }
    .voyage-route { font-size: 1.3rem; font-weight: bold; color: #004e64; margin-bottom: 0.8rem; }
    .voyage-info { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.88rem; color: #555; }
    .prix { font-size: 1.2rem; font-weight: bold; color: #004e64; margin-top: 0.8rem; padding-top: 0.8rem; border-top: 1px solid #b8d8e8; }
    .confirm-box { background: #f8f9fa; border-radius: 8px; padding: 1rem; margin-bottom: 1.2rem; font-size: 0.9rem; color: #555; text-align: center; }
    .confirm-box strong { color: #004e64; }
    .btn { width: 100%; padding: 0.85rem; background: #004e64; color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; }
    .btn:hover { background: #003347; }
    .success { background: #eafaf1; color: #27ae60; border: 1px solid #a9dfbf; border-radius: 8px; padding: 1rem; text-align: center; margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.8; }
    .error { background: #fdf0f0; color: #e74c3c; border: 1px solid #f5b7b1; border-radius: 8px; padding: 0.75rem; text-align: center; margin-bottom: 1rem; font-size: 0.9rem; }
    .badge-type { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
    .badge-louage { background: #e8f4f8; color: #004e64; }
    .badge-bus { background: #fff3e0; color: #e65100; }
  </style>
</head>
<body>
<div class="card">
  <h1>🎫 Réserver un voyage</h1>
  <a href="recherche.php" class="back">← Retour à la recherche</a>

  <div class="voyage-details">
    <div class="voyage-route">
      <?= $voyage['ville_depart'] ?> → <?= $voyage['ville_arrivee'] ?>
    </div>
    <div class="voyage-info">
      <div>📅 <?= $voyage['date_voyage'] ?></div>
      <div>🕐 <?= $voyage['heure_depart'] ?></div>
      <div>💺 <?= $voyage['places_dispo'] ?> places dispo</div>
      <div>
        <span class="badge-type badge-<?= $voyage['type_vehicule'] ?>">
          <?= $voyage['type_vehicule'] == 'louage' ? '🚗 Louage' : '🚌 Bus' ?>
        </span>
      </div>
    </div>
    <div class="prix">💰 <?= $voyage['prix'] ?> TND</div>
  </div>

  <?php if ($message): ?>
    <div class="success">
      ✅ <?php echo $message; ?><br>
      <a href="mes_reservations.php" style="color:#27ae60;">
        Voir mes réservations →
      </a>
    </div>
  <?php endif; ?>

  <?php if ($erreur): ?>
    <div class="error">❌ <?php echo $erreur; ?></div>
  <?php endif; ?>

  <?php if (!$message): ?>
  <div class="confirm-box">
    Confirmer la réservation pour
    <strong><?= $_SESSION['nom'] ?></strong> ?
  </div>
  <form method="POST">
    <button type="submit" class="btn">✅ Confirmer la réservation</button>
  </form>
  <?php endif; ?>
</div>
</body>
</html>
