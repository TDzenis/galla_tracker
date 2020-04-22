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
    <form action="#" method="POST">
      <div class="form-group">
        <label for="Email">Email Address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" 
          placeholder="Enter email" name="email" value="">
        <span class="help-block">###</span>
      </div>
      <div class="form-group">
        <label for="Password">Password</label>
        <input type="password" class="form-control" id="password" 
          placeholder="Password" name="password" value="">
        <span class="help-block">###</span>
      </div>
      <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit">
          <input type="reset" class="btn btn-default" value="Reset">
      </div>
      <p>Don't have an account? <a href="/register">Register here</a>.</p>
    </form>
  </div>
</body>
</html>