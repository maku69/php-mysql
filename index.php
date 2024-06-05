<?php
// index.php

include 'config.php';

function fetch_and_display($query, $conn) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Prindi tabeli päised
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>{$fieldinfo->name}</th>";
        }
        echo "</tr>";
        
        // Prindi andmed
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 tulemust<br>";
    }
}

// Väljasta kogu ‘albumid’ sisu ridade kaupa (10 rida)
echo "<h2>1. Väljasta kogu ‘albumid’ sisu (10 rida)</h2>";
$query = "SELECT * FROM albumid LIMIT 10";
fetch_and_display($query, $conn);

// Väljasta tabelist ainult artist ja album read, kusjuures sorteeri kasvavalt artisti järgi (10 rida)
echo "<h2>2. Väljasta ainult artist ja album, sorteeritud artisti järgi (10 rida)</h2>";
$query = "SELECT artist, album FROM albumid ORDER BY artist ASC LIMIT 10";
fetch_and_display($query, $conn);

// Väljasta tabelist ainult artist ja album read, mille aasta on 2010 ja uuemad
echo "<h2>3. Väljasta artist ja album, aasta >= 2010</h2>";
$query = "SELECT artist, album FROM albumid WHERE aasta >= 2010";
fetch_and_display($query, $conn);

// Väljasta kui palju erinevaid albumeid on andmebaasis, mis on nende keskmine hind ja koguväärtus (summa)
echo "<h2>4. Albumeid kokku, keskmine hind ja koguväärtus</h2>";
$query = "SELECT COUNT(*) AS total, AVG(hind) AS average_price, SUM(hind) AS total_value FROM albumid";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Albumeid kokku: " . $row['total'] . "<br>";
    echo "Keskmine hind: " . $row['average_price'] . "<br>";
    echo "Koguväärtus: " . $row['total_value'] . "<br><br>";
} else {
    echo "0 tulemust<br>";
}

// Väljasta kõige vanema albumi nimed
echo "<h2>5. Kõige vanema albumi nimed</h2>";
$query = "SELECT album FROM albumid ORDER BY aasta ASC LIMIT 1";
fetch_and_display($query, $conn);

// Väljasta albumid, mille hind on kogu keskmisest suurem
echo "<h2>6. Albumid, mille hind on kogu keskmisest suurem</h2>";
$query = "SELECT artist, album, hind FROM albumid WHERE hind > (SELECT AVG(hind) FROM albumid)";
fetch_and_display($query, $conn);

// Loo otsingukast, mis lubab valida, kas otsing toimub artistide või albumite veerust

?>

<h2>7. Otsingukast</h2>
<form method="POST" action="">
    <label for="search_by">Otsi:</label>
    <select id="search_by" name="search_by">
        <option value="artist">Artist</option>
        <option value="album">Album</option>
    </select>
    <input type="text" name="search_query">
    <input type="submit" value="Otsi">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_by = $_POST['search_by'];
    $search_query = $_POST['search_query'];
    $query = "SELECT * FROM albumid WHERE $search_by LIKE '%$search_query%'";
    fetch_and_display($query, $conn);
}
$conn->close();
?>
