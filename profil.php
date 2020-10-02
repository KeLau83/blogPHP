<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-8">
                <h2><?= $_SESSION['pseudoUser']?></h2>
                <form method="POST">
                    <div class="form-group">
                        <label for=""> Déconnexion</label>
                        <input type="submit" value="Déconnexion">
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>

</html>