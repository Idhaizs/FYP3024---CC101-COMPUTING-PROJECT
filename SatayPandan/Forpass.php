<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate new password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a new password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", trim($_POST["password"]))) {
        $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the password
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE admin SET password = ? WHERE email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_password, $param_email);

            // Set parameters
            $param_password = $password;
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Password updated successfully. Set success message
                $success_message = "Password has been successfully updated.";
            } else {
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="Login_Page.css">
    <style>
        /* Add this CSS to change font color */
        p {
            color: white;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="reset_password_form">
            <h2>Forgot Password</h2>
            <div class="input-field <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input type="email" name="email" value="<?php echo $email; ?>" required>
                <label>Enter your email</label>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="input-field <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" value="<?php echo $password; ?>" required>
                <label>Enter new password</label>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="input-field <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" required>
                <label>Confirm new password</label>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div><br>
            <button type="submit" id="reset_password_button">Reset Password</button><br>
            <button type="button" onclick="window.location.href='login_page.php';">Back To Login</button>
        </form>
    </div>
    <script>
        // JavaScript code to show password error message in popup
        <?php if (!empty($success_message)) : ?>
            alert("<?php echo $success_message; ?>");
        <?php endif; ?>
    </script>
</body>

</html>
