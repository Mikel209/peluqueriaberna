<?php

if (isset($_POST['submit'])) {
        
    $checkBox = implode(',', $_POST['servicio']);
    echo $checkBox;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería BernaDíaz</title>
</head>
<body>
    <form method="post">
        <input type="checkbox" name="servicio[]" value="hola">hola
        <input type="checkbox" name="servicio[]" value="que">que
        <input type="checkbox" name="servicio[]" value="haces">haces
        <input type="submit" name="submit" value="submit">
    </form>
</body>

</html>