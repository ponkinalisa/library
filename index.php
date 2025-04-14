<?php 
session_start();
if (isset($_SESSION['id'])){
    header('Location: project/pages/main_page.php');
} else{
    header('Location: project/pages/registr.php');
}
?>