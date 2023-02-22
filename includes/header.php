<?php

$getHeader = function($isConnected) {
    $header = "<header><nav class='nav'><a href='' class='nav-link'>Accueil</a><a href='todolist.php' class='nav-link'>Todo List</a>";

    if (!$isConnected) {
        $header .= "
        <a role='button' id='btn-register'>Inscription</a>
        <a role='button' id='btn-connection'>Connexion</a>";
    } else {
        $header .= "
        <a class='nav-link''>Profil</a>
        <a href='logout.php' id='btn-deconnection'>Deconnexion</a>
        ";
    }

    // finish it

    $header .= "</ul></nav></header>";

    return $header;
};

if (isset($_GET['textOnly'])) {
    echo $getHeader(true);
    exit();
}


require_once "src/User.php";

// var_dump($_SESSION);




// check if user is connected
$isConnected = isset($_SESSION['login']);

$headerHTML = $getHeader($isConnected);

echo $headerHTML;




