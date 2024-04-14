<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satay Pandan</title>
    <link rel="stylesheet" href="Index.css">
</head>
<body>
    <div class="app-container">
        <div class="overlay">
            <h1>SATAY PANDAN</h1>
            <?php
            // Mulai session
            session_start();
            
            // Periksa apakah pengguna telah login, jika ya, alihkan ke halaman beranda
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                header("location: Login_Page.php");
                exit;
            }
            ?>
            <button type="submit"><a href="Login_Page.php" id="loginBtn">Log In</a></button>
        </div>
    </div>
    <script src="Index.js"></script>
</body>
</html>
