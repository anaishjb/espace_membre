<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'root');
 
if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: acceuila/acceuil.html");
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulaire</title>
    <link rel="stylesheet" href="connexion.css">
</head>
   <body>
   <form method="POST" action="">
        <h4>Connexion</h4>
        <hr>  
      <label>Adresse mail:</label>
      <input type="email" name="mailconnect" placeholder="Mail" />
      <label>Mot de passe:</label>
      <input type="password" name="mdpconnect" placeholder="Mot de passe" />
      <input type="submit" name="formconnexion" value="Se connecter !" />
      <p>Vous avez deja un compte?<a href="inscription.php">S'inscrire</a></p>
   
      <?php
      if(isset($erreur)) {
      echo '<font color="red">'.$erreur."</font>";
      }
?>
</form>
   </body>
</html>