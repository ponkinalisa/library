<?php 
session_start();
if (!empty($_GET)){
    $_SESSION['book_current_id'] = $_GET['id'];
    $_SESSION['edit'] = 0;
    $_SESSION['see'] = 1;
    header('Location: main_page.php');
}
?>