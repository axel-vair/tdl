<?php

class Todo
{
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

    public function todoInsert($content, $id_user)
    {
        if (isset($_POST['input_todo'])) {
            $sql = "INSERT INTO todolist (creation, content, id_user, status) VALUES (now(), :content, :id_user, false)";
            $sql_insert = $this->db->prepare($sql);
            $sql_insert->execute([
                'content' => $content,
                'id_user' => $id_user,
            ]);

            if ($sql_insert) {
                echo json_encode([['response' => 'ok', 'reussite' => 'Todo insérée']]);
            } else {
                echo json_encode([['response' => 'not ok', 'echo' => 'Todo pas insérée']]);
            }
        }
    }

    public function displayTodo(){
        $id_user = $_SESSION['id'];
        $display = $this->db->prepare("SELECT * FROM todolist WHERE id_user = :id_user");
        $display->execute([
            'id_user' => $id_user,
        ]);
        $result = $display->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        die();

    }
}