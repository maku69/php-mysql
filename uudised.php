<?php
// Include the database configuration file
include 'config2.php';

// Number of news items per page
$uudiseid_lehel = 100;

// Calculate the total number of pages
$uudiseid_kokku_paring = "SELECT COUNT(id) FROM uudised";
$lehtede_vastus = mysqli_query($yhendus, $uudiseid_kokku_paring);
if (!$lehtede_vastus) {
    die('Probleem päringuga: ' . mysqli_error($yhendus));
}
$uudiseid_kokku = mysqli_fetch_array($lehtede_vastus)[0];
$lehti_kokku = ceil($uudiseid_kokku / $uudiseid_lehel);

// Get the current page number from the URL, default is 1
$leht = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($leht < 1) {
    $leht = 1;
} elseif ($leht > $lehti_kokku) {
    $leht = $lehti_kokku;
}

// Calculate the offset for the SQL query
$start = ($leht - 1) * $uudiseid_lehel;

// Retrieve the news items for the current page
$paring = "SELECT * FROM uudised LIMIT $start, $uudiseid_lehel";
$vastus = mysqli_query($yhendus, $paring);
if (!$vastus) {
    die('Probleem päringuga: ' . mysqli_error($yhendus));
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Uudised</title>
</head>
<body>
    <h1>Uudised</h1>
    <?php
    while ($rida = mysqli_fetch_assoc($vastus)) {
        $pealkiri = isset($rida['pealkiri']) ? htmlspecialchars($rida['pealkiri']) : 'Pealkiri puudub';
        $uudis = isset($rida['uudis']) ? htmlspecialchars($rida['uudis']) : 'Uudis puudub';
        echo '<h3>' . $pealkiri . '</h3>';
        echo '<p>' . nl2br($uudis) . '</p>';
    }
    ?>

    <div class="pagination">
        <?php
        if ($leht > 1) {
            $eelmine = $leht - 1;
            echo "<a href=\"?page=$eelmine\">Eelmine</a> ";
        }

        for ($i = 1; $i <= $lehti_kokku; $i++) {
            if ($i == $leht) {
                echo "<strong>$i</strong> ";
            } else {
                echo "<a href=\"?page=$i\">$i</a> ";
            }
        }

        if ($leht < $lehti_kokku) {
            $jargmine = $leht + 1;
            echo "<a href=\"?page=$jargmine\">Järgmine</a> ";
        }
        ?>
    </div>
</body>
</html>
