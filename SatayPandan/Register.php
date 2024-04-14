<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM admin WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($existingId);
                if($stmt->fetch()) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have at least 8 characters.";
    } elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", trim($_POST["password"]))){
        $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting into database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Show pop-up notification
                echo "<script>alert('Registration successful. You can now login.');</script>";
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
    <title>Register</title>
    <link rel="stylesheet" href="Login_Page.css">
    <style>
        /* Add this CSS to change font color */
        p  {
            color: white;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Register</h2>
            <div class="input-field <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" value="<?php echo $username; ?>" required>
                <label>Enter your username</label>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="input-field <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input type="email" name="email" value="<?php echo $email; ?>" required>
                <label>Enter your email</label>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="input-field <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" value="<?php echo $password; ?>" required>
                <label>Enter your password</label>
            </div>
            <div class="input-field <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" required>
                <label>Confirm your password</label>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div><br>
            <button type="submit">Register</button><br>
            <p>Already have an account? <a href="login_page.php">Login here</a>.</p>
        </form>
    </div>
    <script>
        // Check password error messages
        var passwordErr = "<?php echo $password_err; ?>";
        if (passwordErr) {
            alert(passwordErr);
        }
    </script>
</body>
</html>
