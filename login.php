<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Login - Poera</title>
  <link rel="stylesheet" type="text/css" href="./dist/semantic.css">

  <script src="assets/library/jquery.min.js"></script>
  <script src="./dist/semantic.js"></script>

  <style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
  <script>
  $(document)
    .ready(function() {
      $('.ui.form')
        .form({
          fields: {
            email: {
              identifier  : 'email',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your e-mail'
                },
                {
                  type   : 'email',
                  prompt : 'Please enter a valid e-mail'
                }
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
                {
                  type   : 'length[6]',
                  prompt : 'Your password must be at least 6 characters'
                }
              ]
            }
          }
        })
      ;
    })
  ;
  </script>
</head>
<body>

<!-- Header -->
<?php include("header.php"); ?>

<?php 
if( isset( $_POST['email'] ) && isset( $_POST['password'] ) ) {
  extract( $_POST );
  if( login( $email, $password ) ) {
    header("Location: index.php?msg=login");
  } else {
    echo "<script> alert('Invalid email / password combination.'); </script>";
  }
}
?>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="assets/images/logo.png" class="image">
      <div class="content">
        <?php 
        if( isset( $_GET['rdr'] ) ) {
          echo 'You need to log-in to continue.';
        } else {
          echo 'Log-in to your account.';
        }
        ?>
      </div>
    </h2>
    <form class="ui large form" method="post" action="login.php">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="E-mail address">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <input type="submit" name="login" value="Login" class="ui fluid large teal submit button" />
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      New to us? <a href="signup.php">Sign Up</a>
    </div>
  </div>
</div>


</body>

</html>
