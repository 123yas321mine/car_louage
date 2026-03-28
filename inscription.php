<?php
include 'connexion.php';

$message = "";
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email  = trim($_POST['email']);
    $mdp    = $_POST['mot_de_passe'];
    $mdp2   = $_POST['confirmer_mdp'];

    if ($mdp !== $mdp2) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe) 
                VALUES ('$nom', '$prenom', '$email', '$mdp_hash')";

        if (mysqli_query($conn, $sql)) {
            $message = "Compte créé avec succès !";
        } else {
            $erreur = "Email déjà utilisé ou erreur serveur.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription — Car & Louage</title>
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
      max-width: 420px;
    }
    .logo {
      text-align: center;
      font-size: 1.8rem;
      font-weight: bold;
      color: #e74c3c;
      margin-bottom: 0.3rem;
    }
    h2 {
      text-align: center;
      color: #777;
      font-size: 1rem;
      font-weight: normal;
      margin-bottom: 1.8rem;
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
    input:focus { border-color: #e74c3c; }
    .btn {
      width: 100%;
      padding: 0.85rem;
      background: #e74c3c;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 0.5rem;
      transition: background 0.2s;
    }
    .btn:hover { background: #c0392b; }
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
      color: #e74c3c;
      border: 1px solid #f5b7b1;
      border-radius: 8px;
      padding: 0.75rem;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    .footer-link {
      text-align: center;
      margin-top: 1.2rem;
      font-size: 0.88rem;
      color: #888;
    }
    .footer-link a { color: #e74c3c; text-decoration: none; }
    .footer-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="card">
  <div class="logo">🚌 Car&Louage</div>
  <h2>Créer un nouveau compte</h2>

  <?php if ($message): ?>
    <div class="success">
      ✅ <?php echo $message; ?>
      <br><a href="login.php" style="color:#27ae60;">Se connecter maintenant →</a>
    </div>
  <?php endif; ?>

  <?php if ($erreur): ?>
    <div class="error">❌ <?php echo $erreur; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Nom</label>
      <input type="text" name="nom" placeholder="Votre nom" required />
    </div>
    <div class="form-group">
      <label>Prénom</label>
      <input type="text" name="prenom" placeholder="Votre prénom" required />
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" placeholder="exemple@email.com" required />
    </div>
    <div class="form-group">
      <label>Mot de passe</label>
      <input type="password" name="mot_de_passe" 
             placeholder="Minimum 6 caractères" required />
    </div>
    <div class="form-group">
      <label>Confirmer le mot de passe</label>
      <input type="password" name="confirmer_mdp" 
             placeholder="Répétez le mot de passe" required />
    </div>
    <button type="submit" class="btn">S'inscrire</button>
  </form>

  <div class="footer-link">
    Déjà un compte ? <a href="login.php">Se connecter</a>
  </div>
</div>
</body>
</html>
