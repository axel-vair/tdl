<?php

#[AllowDynamicProperties] class User
{
    private ?int $id = null;
    private ?string $login = null;
    private PDO $db;

    function __construct()
    {
        $db_dsn = 'mysql:host=localhost; dbname=todolist';
        $username = 'root';
        $password_db = 'root';

        try {
            $options =
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // BE SURE TO WORK IN UTF8
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//ERROR TYPE
                    PDO::ATTR_EMULATE_PREPARES => false // FOR NO EMULATE PREPARE (SQL INJECTION)
                ];
            $this->db = new PDO($db_dsn, $username, $password_db, $options); // PDO CONNECT

        } catch (PDOException $e) { //CATCH ERROR IF NOT CONNECTED
            print "Erreur !: " . $e->getMessage() . "</br>";
            die();
        }

    }

    public function verifUser()
    {
        if ($_POST['login'] > 3) { // if input are not null
            $login = htmlspecialchars($_POST['login']);
            $pass1 = htmlspecialchars($_POST['password']);

            $sql = 'SELECT * 
                    FROM utilisateurs 
                    WHERE login = :login';
            $sql_exe = $this->db->prepare($sql);// so prepare request for search if login is taken
            $sql_exe->bindParam(':login', $login);
            $sql_exe->execute();
            $results = $sql_exe->fetch(PDO::FETCH_ASSOC);

            if ($results) {
                return true;
            } else {
                return false;
            }
        }else{
            echo json_encode(['response' => "not ok", 'echoue' => 'Veuillez entrer un !']);
        }

    }

    public function register($login, $password)
    {
        if (!$this->verifUser()) {
            $sql = "INSERT INTO utilisateurs (login, password) 
                    VALUES (:login, :password)";
            $sql_insert = $this->db->prepare($sql);
            $sql_insert->execute([
                'login' => htmlspecialchars($login),
                'password' => password_hash($password, PASSWORD_BCRYPT),
            ]);

            if ($sql_insert) {
                // json qui va permettre de vérifier que la réponse est OK, si c'est le cas, on affiche inscription réussie
                echo json_encode(['response' => "ok", 'reussite' => 'Inscription réussie !']);
            } else {
                echo json_encode(['response' => "not ok", 'echoue' => 'L\'inscription a échoué']);
            }
        } else {
            echo json_encode(['response' => "not ok", 'echoue' => 'L\'utilisateur existe déjà']);
        }
    }

    public function connection($login, $password)
    {
        // query qui vient selectionner les infos là où le login et le mdp correspondent avec l'objet courant
        $sql_verify = " SELECT * 
                        FROM utilisateurs 
                        WHERE login = :login";
        $sql_verify_exe = $this->db->prepare($sql_verify);
        $sql_verify_exe->execute([
            'login' => $login,
        ]);
        // fetch du résultat dans un tableau
        $results = $sql_verify_exe->fetch(PDO::FETCH_ASSOC);

        // si le resultat est true alors on stocke le password hashé dans un variable
        if ($results) {
            $hashedPassword = $results['password'];
            //si le passwordverify est true alors on initialise une session avec le login
            // puis on echo le json pour afficher un message avec js
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['login'] = $login;
                $_SESSION['id'] = $results['id'];
                return json_encode(['reponse' => "ok", 'reussite' => 'connexion réussie']);

            }
        } else {
            return json_encode(['reponse' => 'not ok', 'echoue' => 'la connexion a échoué']);
        }


    }

    public function deconnect()
    {
        unset($_SESSION['login']);
        session_destroy();
        echo "vous êtes déco";
        header('Location: index.php');
    }

}