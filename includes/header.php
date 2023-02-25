<?php

$getHeader = function($isConnected) {
    $header = "<header><div><nav class='nav'><div id='logo'>Make a Cake</div>";

    if (!$isConnected) {
        $header .= "
        <div>
            <a role='button' id='btn-register'>Inscription</a>
            <a role='button' id='btn-connection'>Connexion</a>
        </div>";

    } else {
        $header .= "
            <div><a href='logout.php' id='btn-deconnection'>Deconnexion</a></div>
        ";
    }

    // finish it

    $header .= "</div></nav></header>";

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




