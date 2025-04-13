<?php 
start_session();
if (isset($_session['id'])){
    header('Location: project/main_page.php');
}else{
    header('Location: project/registr.php');
}
?>