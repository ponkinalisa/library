<?php 
session_start();
include('config.php');
if (!empty($_GET) and isset($_GET['id'])){
    $sql = 'SELECT path_to_img FROM books WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=> $_GET['id']]);
    $img = $stmt->fetch(PDO::FETCH_ASSOC)['path_to_img'];
    unlink($img);

    $sql = 'DELETE FROM books WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=> $_GET['id']]);
    if ($_SESSION['book_current_id'] == $_GET['id']){
        $sql = 'SELECT * FROM books WHERE user_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id'=> $_SESSION['id']]);
        $main = $stmt->fetch();
        if ($main){
            $_SESSION['book_current_id'] = $main[0];
        }else{
            $_SESSION['book_current_id'] = -1;
        }
    }
    $_SESSION['edit'] = 0;
    $_SESSION['see'] = 0;
    header('Location: ../pages/main_page.php');
}
?>