<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: main.php");
    exit;
} 

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email     = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Checks if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } 
    else {
        $email = trim($_POST["email"]);
    }

    // Checks if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } 
    else {
        $password = trim($_POST["password"]);
    }
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM user WHERE email = ?";

        if ($stmt = $mysqli->prepare($sql)) {

            // Set parameters
            $param_email = $email;

            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $email, $hashed_password);

                    if ($stmt->fetch()) {

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"]       = $id;
                            $_SESSION["email"]    = $email;

                            // Redirect user to welcome page
                            header("location: main.php");
                        } //password_verify( $password, $hashed_password )
                        else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    } 
                } 
                else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                    echo $email_err;
                }
            } 
            else {
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
  <div class="wrapper">
    <h2>Sing In</h2>
    <p>Please fill this form to sing in.</p>
    <form action="<?php
      echo htmlspecialchars($_SERVER["PHP_SELF"]);
      ?>" method="POST">
      <div class="form-group">
        <label for="Email">Email Address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" 
          placeholder="Enter email" name="email" value="<?php echo $email; ?>">
        <span class="help-block"><?php
          echo $email_err;
          ?></span>
      </div>
      <div class="form-group">
        <label for="Password">Password</label>
        <input type="password" class="form-control" id="password" 
          placeholder="Password" name="password" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit">
          <input type="reset" class="btn btn-default" value="Reset">
      </div>
      <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
  </div>
<?php include("footer.html"); ?>