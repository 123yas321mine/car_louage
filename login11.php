<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'connexion.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $mdp   = $_POST['mot_de_passe'];

    $sql    = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user   = mysqli_fetch_assoc($result);

    if ($user && password_verify($mdp, $user['mot_de_passe'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nom']     = $user['nom'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: accueil.php");
        }
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion — Car & Louage</title>
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
  <h2>Se connecter</h2>

  <?php if ($erreur): ?>
    <div class="error">❌ <?php echo $erreur; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" placeholder="exemple@email.com" required />
    </div>
    <div class="form-group">
      <label>Mot de passe</label>
      <input type="password" name="mot_de_passe" placeholder="Votre mot de passe" required />
    </div>
    <button type="submit" class="btn">Se connecter</button>
  </form>

  <div class="footer-link">
    Pas de compte ? <a href="inscription.php">S'inscrire</a>
  </div>
</div>
</body>
</html>