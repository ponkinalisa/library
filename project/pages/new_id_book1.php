<?php 
session_start();
if (!empty($_GET)){
    $_SESSION['book_current_id'] = $_GET['id'];
    $_SESSION['edit'] = 1;
    $_SESSION['see'] = 0;
    header('Location: main_page.php');
}
?>