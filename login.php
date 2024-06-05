<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['kasutaja'];
    $password = $_POST['parool'];

    $stmt = $pdo->prepare('SELECT * FROM kasutajad WHERE kasutaja = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password == $user['parool']) { // Otse võrdlemine ilma password_verify
        $_SESSION['admin'] = $user['id'];
        header('Location: admin.php');
        exit();
    } else {
        $error = 'Vale kasutajanimi või parool';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="post" action="">
        <label>Kasutaja:</label>
        <input type="text" name="kasutaja" required>
        <br>
        <label>Parool:</label>
        <input type="password" name="parool" required>
        <br>
        <button type="submit">Login</button>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
