<?php
date_default_timezone_set('Europe/Paris');
$heureCourante = date('H:i:s');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heure courante</title>
</head>
<body>
    <h1>Heure actuelle</h1>
    <p>L'heure courante est : <strong><?php echo $heureCourante; ?></strong></p>
</body>
</html>
