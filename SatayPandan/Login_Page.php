<?php
session_start();
// Check if admin is already logged in, if yes, redirect to menu page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Login_Page.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM admin WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($username_db, $hashed_password);
                    if($stmt->fetch()){
                        if($password == $hashed_password){
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;

                            // Debug: Check if password verification is successful
                            echo "Password verified successfully.";

                            // Debug: Check if redirection code is executed
                            echo "Redirecting to products page.";

                            // Redirect user to menu page
                            header("location: products.php");
                            exit;
                        } else{
                            // Password is not valid, display a generic error message
                            echo "<script>alert('Invalid username or password.');</script>";
                        }
                    }
                } else{
                    // Username not found, display a generic error message
                    echo "<script>alert('Invalid username or password.');</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login_Page.css">
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login</h2>
            <div class="input-field <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" value="<?php echo $username; ?>" required>
                <label>Enter your username</label>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="input-field <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" required>
                <label>Enter your password</label>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember">
                    <p>Remember me</p>
                </label>
                <a href="Forpass.php">Forgot password?</a>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="Register.php" id="SignUpLink">Register</a></p>
            </div>
            <div class="alert"><?php echo (!empty($login_err)) ? $login_err : ''; ?></div>
        </form>
    </div>
</body>
</html>
