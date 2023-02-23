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
            // Requête SQL qui va insérer todolist
            $sql = "INSERT INTO 
                    todolist (creation, content, id_user, status) 
                    VALUES (now(), :content, :id_user, false)";
            $sql_insert = $this->db->prepare($sql);
            $sql_insert->execute([
                'content' => $content,
                'id_user' => $id_user,
            ]);

            $display_exe = $this->db->prepare('SELECT LAST_INSERT_ID()');
            $display_exe->execute();
            $result_exe = (int)($display_exe->fetch())[0];
            $taskId = $this->db->prepare('SELECT * 
                                                FROM todolist 
                                                WHERE id = :id');
            $taskId->execute(['id' => $result_exe]);
            $taskDisplay = $taskId->fetch(PDO::FETCH_ASSOC);
            echo json_encode($taskDisplay);
        }
    }

    public function todoUpdate(int $id_task){
        $update = "UPDATE  
                   todolist 
                   SET todolist.status = :status
                   WHERE todolist.id = :id_task";

        $update_exe = $this->db->prepare($update);
        $update_exe->execute([
            'status' => 1,
            'id_task' => $id_task]);
        echo json_encode(['response' => 'update réussie']);
    }
    public function displayTodo(){
        $id_user = $_SESSION['id'];
        $display = $this->db->prepare("SELECT * 
                                             FROM todolist 
                                             WHERE id_user = :id_user");
        $display->execute([
            'id_user' => $id_user,
        ]);
        $result = $display->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);

    }

    public function deleteTask(int $id_task){

        $delete = "DELETE FROM todolist 
                   WHERE todolist.id = :id_task";
        $sql_exe = $this->db->prepare($delete);
        $sql_exe->execute([
        'id_task' => $id_task]);
        echo json_encode(['response' => 'suppression réussie']);
    }
}
