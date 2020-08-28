<html>
<head>
      <title>User login and registraion</title>
    <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="login-box">
    <div class="row">
    <div class="col-md-6 login-left">
      <h2 class="logintext">Login here</h2>
      <form action="validation.php" method="post">
        <div class="form-group">
          <label>username</label>
          <input type="text" name="user" class="form-control" required>
        </div>
        <div class="form-group">
          <label>password</label>
          <input type="pass" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
     <div class="col-md-6 login-right">
      <h2 class="logintext">register here</h2>
      <form action="registration.php" method="post">
        <div class="form-group">
          <label>username</label>
          <input type="text" name="user" class="form-control" required>
        </div>
        <div class="form-group">
          <label>password</label>
          <input type="pass" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
    </div>
    </div>
    </div>

</body>
</html>
