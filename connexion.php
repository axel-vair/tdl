<?php
require_once 'src/User.php';

/* Si le formulaire est envoyé, que les inputs ne sont pas vides alors on stocke les inputs dans des variables
    puis on instancie un objet de la classe user et l'on appelle la fonction connection */

if (isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login']) && !empty($_POST['password'])) {
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $new_connection = new User();
    echo $new_connection->connection($login, $password);

    // die pour éviter que le json ne soit corrompu par le html
    die();

}
?>

<h1>Connexion</h1>
<form id="form-connection" method="post">
    <label for="login">Login</label>
    <input id="login" name="login" type="text">
    <label for="password">Mot de passe</label>
    <input id="password" name="password" type="password">
    <button type="submit" id="connect_form_button" name="submit">Se connecter</button>
</form>

