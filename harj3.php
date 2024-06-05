<?php
// Include configuration for database connection
require 'config.php';

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Handle form submission for adding a new album
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_album'])) {
    $Album = sanitizeInput($_POST['Album']);
    $Artist = sanitizeInput($_POST['Artist']);
    $Aasta = sanitizeInput($_POST['Aasta']);
    $Hind = sanitizeInput($_POST['Hind']);

    if (!empty($Album) && !empty($Artist) && !empty($Aasta) && !empty($Hind)) {
        $stmt = $conn->prepare("INSERT INTO albumID (Album, Artist, Aasta, Hind) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $Album, $Artist, $Aasta, $Hind);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $ID = sanitizeInput($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM albumID WHERE ID = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $stmt->close();
}

// Handle edit request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_album'])) {
    $ID = sanitizeInput($_POST['ID']);
    $Album = sanitizeInput($_POST['Album']);
    $Artist = sanitizeInput($_POST['Artist']);
    $Aasta = sanitizeInput($_POST['Aasta']);
    $Hind = sanitizeInput($_POST['Hind']);

    if (!empty($Album) && !empty($Artist) && !empty($Aasta) && !empty($Hind)) {
        $stmt = $conn->prepare("UPDATE albumID SET Album = ?, Artist = ?, Aasta = ?, Hind = ? WHERE ID = ?");
        $stmt->bind_param("ssiii", $Album, $Artist, $Aasta, $Hind, $ID);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all albums
$result = $conn->query("SELECT * FROM albumID");

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>AlbumID</title>
</head>
<body>
    <h1>AlbumID</h1>

    <!-- Album addition form -->
    <form method="post" action="">
        <input type="text" name="Album" placeholder="Albumi nimi" required>
        <input type="text" name="Artist" placeholder="Artist" required>
        <input type="number" name="Aasta" placeholder="Aasta" required>
        <input type="number" name="Hind" placeholder="Hind" required>
        <button type="submit" name="add_album">Lisa album</button>
    </form>

    <h2>Albumite nimekiri</h2>
    <table border="1">
        <tr>
            <th>Album</th>
            <th>Artist</th>
            <th>Aasta</th>
            <th>Hind</th>
            <th>Tegevused</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Album']; ?></td>
                <td><?php echo $row['Artist']; ?></td>
                <td><?php echo $row['Aasta']; ?></td>
                <td><?php echo $row['Hind']; ?></td>
                <td>
                    <a href="?delete=<?php echo $row['ID']; ?>">Kustuta</a>
                    <a href="?edit=<?php echo $row['ID']; ?>">Muuda</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])): 
        $ID = sanitizeInput($_GET['edit']);
        $result = $conn->query("SELECT * FROM albumID WHERE ID = $ID");
        $album = $result->fetch_assoc();
    ?>
        <h2>Muuda albumit</h2>
        <form method="post" action="">
            <input type="hidden" name="ID" value="<?php echo $album['ID']; ?>">
            <input type="text" name="Album" value="<?php echo $album['Album']; ?>" required>
            <input type="text" name="Artist" value="<?php echo $album['Artist']; ?>" required>
            <input type="number" name="Aasta" value="<?php echo $album['Aasta']; ?>" required>
            <input type="number" name="Hind" value="<?php echo $album['Hind']; ?>" required>
            <button type="submit" name="edit_album">Muuda albumit</button>
        </form>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
