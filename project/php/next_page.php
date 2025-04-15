<?php 
session_start();
if (isset($_SESSION['book'])){
    $book = $_SESSION['book'];
    $_SESSION['book'] = $book + 5;
}else{
    $_SESSION['book'] = 0;
}
header('Location: ../pages/main_page.php');
?>