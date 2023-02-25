

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">

    <link href="assets/style.css" rel="stylesheet" type="text/css">
    <script src="js/app.js" defer></script>
    <title>MAKE A CAKE</title>
</head>
<body>
<?php
require_once "includes/header.php";
session_start();
$utilisateur = new User();
if($utilisateur->isConnected()){
    header('Location: todolist.php');
}
?>
<div id="container-logo">
    <img id="img-logo" src="assets/logo_todo.png" alt="logo">
</div>

<div id="title-div">
    <h1>MAKE A CAKE</h1>
</div>
<div id="presentation">
    <p>Inscrivez-vous ou connectez-vous afin d'accéder à vos listes de choses à faire.</p>
</div>

<div>
    <div class="div-form">
        <!-- Div qui vont accueillir les formulaires d'inscription et de connexion -->
        <div id="forms"></div>
        <!-- Span qui accueille les messages d'échecs et de réussites JS -->
        <span id="registerSuccess"></span>
    </div>
</div>

<footer class="foot">
    <p>Fait avec <span id="coeur">❤</span></p>
    <p>© 2023 - <a href="https://github.com/axel-vair" target="_blank" class="links">Axel Vair</a></p>
</footer>
</body>
</html>
