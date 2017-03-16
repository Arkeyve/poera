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
    .ui.label {
      width: 6em;
    }
  </style>
  <script>
    $(document)
    .ready(function() {
      $('.ui.form')
      .form({
        fields: {
          name: {
            identifier : 'name',
            rules: [
            {
              type: 'empty',
              prompt: 'Please enter your name'
            }
            ]
          },
          phone: {
            identifier : 'phone',
            rules: [
            {
              type: 'empty',
              prompt: 'Please enter your phone number'
            },
            {
              type : 'length[10]',
              prompt : 'Please enter a valid phone number'
            }
            ]
          },
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
  if( isset( $_POST['name'] ) && isset( $_POST['phone'] ) && isset( $_POST['email'] ) && isset( $_POST['password'] ) ) {
    array_walk_recursive( $_POST, "filter" );
    extract( $_POST );
    if( signup( $name, $phone, $email, $password ) ) {
      echo "<script> alert('Successfully Registered. Please log-in to continue.'); </script>";
    } else {
      echo "<script> alert('Email ID already present.'); </script>";
    }
  }
  ?>

  <div class="ui middle aligned center aligned grid">
    <div class="column">
      <h2 class="ui teal image header">
        <img src="assets/images/logo.png" class="image">
        <div class="content">
          Sign Up
        </div>
      </h2>
      <form class="ui large form" method="post" action="signup.php">
        <div class="ui stacked segment">
          <div class="field">
            <div class="ui labeled corner input">
              <label class="ui label" for="name">Name</label>
              <input type="text" name="name" placeholder="Name">
              <label class="ui corner label"><i class="asterisk icon"></i></label>
            </div>
          </div>
          <div class="field">
            <div class="ui labeled corner input">
              <label class="ui label" for="username">Phone</label>
              <input type="text" name="phone" placeholder="Phone Number">
              <label class="ui corner label"><i class="asterisk icon"></i></label>
            </div>
          </div>
          <div class="field">
            <div class="ui labeled corner input">
              <label class="ui label" for="email">E-mail</label>
              <input type="text" name="email" placeholder="E-mail address">
              <label class="ui corner label"><i class="asterisk icon"></i></label>
            </div>
          </div>
          <div class="field">
            <div class="ui labeled corner input">
              <label class="ui label" for="password">Password</label>
              <input type="password" name="password" placeholder="Password">
              <label class="ui corner label"><i class="asterisk icon"></i></label>
            </div>
          </div>
          <input type="submit" name="submit" value="Sign Up" class="ui fluid large teal submit button" />
        </div>

        <div class="ui error message"></div>

      </form>

    </div>
  </div>


</body>

</html>
