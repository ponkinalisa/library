<?php 
session_start();
if (isset($_SESSION['id'])){
    header('Location: main_page.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST)){
        include('../php/config.php');

        $email = trim($_POST['email']);
        $password1 = trim($_POST['password']);
        $password2 = trim($_POST['confirm-password']);

        $sql = 'SELECT * FROM users WHERE email = :email';

        try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0){
            $error = 'Пользователь с такой почтой уже зарегестрирован';
        }else{
            if ($password1 == $password2){
                $password_regex = '/^(?=.*?[A-Z])(?=.*?[0-9]).{3,}$/'; 
                if (preg_match($password_regex, $password1) == 0){
                    $error = 'пароль должен содержать минимум 3 символа, 1 цифру и 1 заглавную букву[A-Z]';
                }else{
                    $pass = password_hash($password1, PASSWORD_DEFAULT);
                    $sql = 'INSERT INTO users(email, password) VALUES(:email, :password)';

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['email' => $email, 'password' => $pass]);
                    $stmt->fetch();

                    $sql = 'SELECT * FROM users WHERE email = :email';

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['email' => $email]);
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['id'] = $res['id'];
                    $_SESSION['book'] = 0;
                    header('Location: main_page.php');
                }
            }
            else{
                $error = 'Пароли не совпадают';
            }
        }
    } catch (PDOException $e) {
        $error = 'Ошибка подключения: ' . $e->getCode() . ' - ' . $e->getMessage();
    }

    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Подключение стилей -->
</head>
<body>
    <div class="auth-container">
        <div id="register-form">
            <h2>Регистрация</h2>
            <form action="registr.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Введите ваш email">

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required minlength="3" placeholder="Введите ваш пароль">

                <label for="confirm-password">Подтвердите пароль:</label>
                <input type="password" id="confirm-password" name="confirm-password" required placeholder="Подтвердите пароль">

                <button type="submit">Зарегистрироваться</button>

                <p>Уже есть аккаунт? <a href="index.php">Войдите</a></p>
            </form>
            <!-- Ошибка регистрации -->
            <div id="register-error" style="color: red;">
                <?php 
                if (isset($error)){
                    echo $error;
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        // Простая валидация формы на клиенте
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;

            // Проверка, чтобы пароли совпадали
            if (password !== confirmPassword) {
                alert('Пароли не совпадают!');
                event.preventDefault();
            }

            // Проверка на заполненность полей
            if (!email || password.length < 3) {
                alert('Пожалуйста, заполните все поля правильно!');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
