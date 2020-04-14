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

<?php
include("header.html");
?>
</head>
<body>
  <!-- A grey horizontal navbar that becomes vertical on small screens -->
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
    <!-- Links -->
    <ul class="navbar-nav">
      <li>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#LogInModal">
        Log In
        </button>
        <a href="register.php">
        <button type="button" class="btn btn-primary">
        Register
        </button>
        </a>
      </li>
    </ul>
  </nav>
  <!-- Modal -->
  <div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="LogInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="LogInModalLabel">Log In</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);
            ?>" method="POST">
            <div class="form-group">
              <label for="Email">Email address</label>
              <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="<?php
                echo $email;
                ?>">
              <span class="help-block"><?php
                echo $email_err;
                ?></span>
            </div>
            <div class="form-group">
              <label for="Password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="<?php
                echo $password;
                ?>">
              <span class="help-block"><?php
                echo $password_err;
                ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
  </script>
    <?php
    include("footer.html");
    ?>