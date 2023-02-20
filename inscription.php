<?php
require_once 'src/User.php';
if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])){
    $new_user = new User();
    $new_user->register($_POST['login'],  $_POST['password']);
    die(); // permet que le code s'arrête avant d'afficher le formulaire pour éviter de poser problème avec le json
}
?>

<h1>Inscription</h1>
<form id="form-register" method="post">
    <label for="login">Login</label>
    <input id="login" name="login" type="text">
    <label for="password">Mot de passe</label>
    <input id="password" name="password" type="password">
    <button type="submit" id="envoie" name="envoie">S'inscrire</button>
</form>




