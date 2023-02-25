<?php
session_start();
require_once 'src/Todo.php';
if(isset($_POST['input_todo'])){
    $content = $_POST['input_todo'];
    $id_user = $_SESSION['id'];
    $insert_todo = new Todo();
    $insert_todo->todoInsert($content, $id_user);
    die();
}

if(isset($_GET['getTodo'])){
    $todo = new Todo();
    $todo->displayTodo($_GET['getTodo']);
    die();
}

if(isset($_GET['delete'])) {
    $delete = new Todo();
    $delete->deleteTask((int) $_GET['delete']);
    die();
}

if(isset($_GET['update'])){
    $update = new Todo();
    $update->todoUpdate((int) $_GET['update'], date('Y-m-d H:i:s'));
    die();
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/style.css" rel="stylesheet" type="text/css">
    <script src="js/app.js" defer></script>
    <title>Ma Todo List</title>
</head>
<body>
<?php
require_once "includes/header.php";

?>

<div>
    <!-- Div qui vont accueillir les formulaires d'inscription et de connexion -->
    <div id="forms"></div>
    <!-- Span qui accueille les messages d'échecs et de réussites JS -->
    <span id="registerSuccess"></span>

</div>
<div id="title-div">
    <h1>Liste de "<?= $_SESSION['login']?>"</h1>
</div>

<div id="container-todo">
    <section id="container-form">
        <form method="post" id="todo-form">
            <label id="label_todo" for="input_todo">Tâches à réaliser :</label>
            <input id="input_todo" name="input_todo" type="text" required>
            <button id="submit" type="submit">Ajouter</button>
        </form>
    </section>
    <section class="todo-div-container">
        <h2>A faire :</h2>
        <ul id="list-todo">

        </ul>

    </section>
    <section class="done-div-container">
        <h2>Tâches terminées :</h2>
        <ul id="done">
        </ul>
    </section>
</div>
</body>
</html>