<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Poera</title>
  <link rel="stylesheet" type="text/css" href="./dist/semantic.css">

  <style type="text/css">
    body {
      background-color: #FFFFFF;
    }
    .main.container {
      margin-top: 7em;
    }
    .wireframe {
      margin-top: 2em;
    }
  </style>

</head>
<body class="mainbody">

  <!-- Header -->
  <?php include("header.php"); ?>
  <?php if( !is_valid() ) { header("Location: login.php?rdr=1"); } ?>

  <?php
  if( isset( $_POST['send'] ) ) {
    array_walk_recursive($_POST, "filter");
    extract( $_POST );
    if( send_pm( $_SESSION['user_id'], $email, $message ) ) {
      echo "<script> alert('Message Sent'); </script>";
    } else {
      echo "<script> alert('The email address does not exist.'); </script>";
    }
  }
  ?>

  <div class="ui main text container">
    <div class="ui one cards">
      <div class="ui card">
        <div class="content">
          <div class="ui header black left ribbon label">Send a New Message</div>
          <br />
          <form class="ui form" action="messages.php" method="post">
            <input type="text" name="email" placeholder="Enter the email address of the receiver..." />
            <br />
            <br />
            <div class="ui fluid action input">
            <input type="text" name="message" placeholder="Write your message here..." />
              <button type="submit" name="send" value="send" class="ui button">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="ui one cards">
      <?php
      if( isset( $_GET['sent'] ) ) {
        $getthreads = mysqli_query( getconn(), "
          SELECT m.to_user_id, m.message, u.name, u.email 
          FROM user_pm AS m, users AS u 
          WHERE u.user_id = m.to_user_id AND from_user_id = ".$_SESSION['user_id'] 
        );
      } else {
        $getthreads = mysqli_query( getconn(), "
          SELECT m.from_user_id, m.message, u.name, u.email 
          FROM user_pm AS m, users AS u 
          WHERE u.user_id = m.from_user_id AND to_user_id = ".$_SESSION['user_id'] 
        );
      }
      ?>
      <div class="ui card">
        <div class="content">
          <?php 
          if( isset( $_GET['sent'] ) ) {
            echo '<div class="ui header black right ribbon label">Sent Messages</div>';
          } else {
            echo '<div class="ui header black right ribbon label">Received Messages</div>';
          }
          ?>
        </div>
        <div class="extra content">
          <div class="ui relaxed divided list">
            <?php while( $thread = mysqli_fetch_array( $getthreads ) ) { ?>
            <div class="item">
              <a class="header"><?php echo $thread['name'].' ('.$thread['email'].')'; ?></a>
              <div class="content"><?php echo $thread['message']; ?></div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Footer -->
  <?php include("footer.php"); ?>
</body>

</html>
