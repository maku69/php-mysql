<?php
session_start();

$vnimi = "";
$vemail = "";
$vsonum = "";
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nimi']) && isset($_POST['email']) && isset($_POST['sonum']) && isset($_POST['kood'])) {
        $nimi = trim(addslashes($_POST['nimi']));
        $email = trim(addslashes($_POST['email']));
        $sonum = trim(addslashes($_POST['sonum']));
        $kood = trim($_POST['kood']);

        $vnimi = $nimi;
        $vemail = $email;
        $vsonum = $sonum;

        if (!empty($nimi) && !empty($email) && !empty($sonum) && !empty($kood)) {
            if (strlen($nimi) > 25 || !preg_match("/^[a-z0-9]((\.|_)?[a-z0-9]+)+@([a-z0-9]+(\.|-)?)+[a-z0-9]\.[a-z]{2,}$/", strtolower($email)) || strlen($sonum) > 500) {
                echo 'Tekstid on liiga pikad või email on valesti!';
            } else {
                if ($kood == $_SESSION['captchatekst']) {
                    $to = 'metshein@gmail.com';
                    $subject = 'Tagasiside kodulehelt';
                    $message = $sonum;
                    $from = 'From: ' . $nimi . '<' . $email . '>';
                    
                    if (mail($to, $subject, $message, $from)) {
                        echo "Email saadetud!<br>Täname tagasiside eest!";
                        echo "<meta http-equiv=\"refresh\" content=\"2;URL='10_email.php'\">";
                        exit();
                    } else {
                        echo "Teie emaili ei saadetud ära!";
                    }
                } else {
                    echo "Turvakood on vale!";
                }
            }
        } else {
            $error = 'Palun täida kõik väljad!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tagasiside</title>
</head>
<body>
    <h2>Tagasiside</h2>
    <form action="" method="post">
        Teie nimi:<br>
        <input name="nimi" type="text" value="<?php echo htmlspecialchars($vnimi); ?>"><br>
        Teie email:<br>
        <input name="email" type="text" value="<?php echo htmlspecialchars($vemail); ?>"><br>
        Sõnum:<br>
        <textarea cols="30" rows="10" name="sonum"><?php echo htmlspecialchars($vsonum); ?></textarea><br>
        <img src="chapta.php"><br>
        Sisesta kood pildilt:<br>
        <input name="kood" type="text"><br>
        <input value="saada sõnum" type="submit"><br>
    </form>
    <?php if (!empty($error)) echo $error; ?>
</body>
</html>
