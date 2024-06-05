<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['kasutaja']);
    $password = trim($_POST['parool']);

    // Kontrolli parooli pikkust
    if (strlen($password) < 8) {
        die('Parool peab olema vähemalt 8 tähemärki pikk.');
    }

    // Kontrolli, kas kasutajanimi on juba olemas
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM kasutajad WHERE kasutaja = ?');
    $stmt->execute([$username]);
    if ($stmt->fetchColumn() > 0) {
        die('Kasutajanimi juba eksisteerib.');
    }

    // Leia praegune suurim ID ja määra uus ID suurimale ID-le + 1
    $stmt = $pdo->query('SELECT MAX(id) as max_id FROM kasutajad');
    $result = $stmt->fetch();
    $new_id = $result['max_id'] + 1;

    // Lisa uus kasutaja andmebaasi ilma parooli krüpteerimata
    $stmt = $pdo->prepare('INSERT INTO kasutajad (id, kasutaja, parool) VALUES (?, ?, ?)');
    if ($stmt->execute([$new_id, $username, $password])) {
        $message = 'Kasutaja registreerimine õnnestus!';
    } else {
        $message = 'Kasutaja registreerimisel tekkis viga.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registreeri Uus Kasutaja</title>
</head>
<body>
    <h2>Registreeri Uus Kasutaja</h2>
    <?php if (isset($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Kasutaja:</label>
        <input type="text" name="kasutaja" required>
        <br>
        <label>Parool:</label>
        <input type="password" name="parool" required>
        <br>
        <button type="submit">Registreeri</button>
    </form>
    <br>
    <a href="admin.php">Tagasi Admin Paneelile</a>
</body>
</html>
