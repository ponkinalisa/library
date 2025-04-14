<?php 
session_start();
include('config.php');

$sql = 'SELECT path_to_img FROM books WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id'=> $_SESSION['book_current_id']]);
$img = $stmt->fetch(PDO::FETCH_ASSOC)['path_to_img'];
unlink($img);


$sql = 'DELETE FROM books WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id'=> $_SESSION['book_current_id']]);
$_SESSION['book'] = $_SESSION['book'] - 1;
header('Location: ../pages/main_page.php');
?>