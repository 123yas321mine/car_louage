<?php
 session_start(); 
 if (!isset($_SESSION['id_user'])) 
 { header("Location: login.php"); exit(); } ?> 
 <!DOCTYPE html> <html><head> <meta charset="UTF-8"> <title>Accueil — Car & Louage</title> 
 <link rel="stylesheet" href="css/style.css"> </head>
 <body> <div class="card"> 
    <h1>🚌 Car&Louage</h1> <p>Bienvenue,
         <?= $_SESSION['nom'] ?> ! 👋</p> 
         <p>Rôle : <?= $_SESSION['role'] ?></p>
          <a href="logout.php">Se déconnecter</a>
         </div> </body></html>