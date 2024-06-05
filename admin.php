<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Paneel</title>
</head>
<body>
    <h2>Tere tulemast Admin Paneelile</h2>
    <a href="logout.php">Logi välja</a>
    <form action="register.php" method="post">
        <h2>Registreeri uus kasutaja</h2>
        <label>Kasutaja:</label>
        <input type="text" name="kasutaja" required>
        <br>
        <label>Parool:</label>
        <input type="password" name="parool" required>
        <br>
        <button type="submit">Registreeri</button>
    </form>
</body>
</html>
