<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = $_POST["identifiant"];
  $password = $_POST["pswd"];

  $sql = "SELECT idAd FROM adminauthentification WHERE loginAd = :login AND passwordAD = :password";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':login', $login);
  $stmt->bindParam(':password', $password);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $_SESSION["loggedIn_admin"] = true;
    $_SESSION["id"] = $stmt->fetchColumn();
    header("Location: dashboard.php");
    exit();
  } else {
    $errorMessage = "Les informations d'identification sont invalides";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - ATS</title>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Jost', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .container {
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 40px;
      width: 350px;
      color: white;
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .logo {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
    }
    .logo img {
      width: 120px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 500;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      background: rgba(255,255,255,0.1);
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
    }
    input[type="submit"] {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      background-color: #6fcf97;
      border: none;
      border-radius: 8px;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #56cc9d;
    }
    .error {
      text-align: center;
      margin-top: 10px;
      color: #ff6b6b;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="ATS.png" alt="ATS Logo">
    </div>
    <h2>Connexion Admin</h2>
    <form method="POST">
      <input type="text" name="identifiant" placeholder="Identifiant" required>
      <input type="password" name="pswd" placeholder="Mot de passe" required>
      <input type="submit" value="Se connecter">
      <?php if (!empty($errorMessage)) echo "<div class='error'>$errorMessage</div>"; ?>
    </form>
  </div>
</body>
</html>
