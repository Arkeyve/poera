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
  if( isset( $_POST['post'] ) ) {
    array_walk_recursive($_POST, "filter");
    extract( $_POST );
    $content = implode("<br />", explode(";", $content));
    if( insert_poem( $_SESSION['user_id'], $title, $content, $genre_id ) ) {
      echo "<script> alert('Successfully posted poem'); </script>";
    } else {
      echo "<script> alert('Some error occured. Please try again later or contact the administrator.'); </script>";
    }
  }
  ?>

  <div class="ui main text container">
    <div class="ui one cards">
      <div class="ui card">
        <div class="content">
          <form class="ui form" action="newpoem.php" method="post">
            <label class="header">Title</label>
            <input type="text" name="title" placeholder="Enter the title of your poem" />
            <br />
            <br />
            <label class="header">Genre</label>
            <select name="genre_id">
              <?php 
              $genre_list = mysqli_query( getconn(), "select * from genre" );
              while( $row = mysqli_fetch_array( $genre_list ) ) {
                echo '<option value="'.$row['genre_id'].'">'.$row['genre'].'</option>';
              }
              ?>
            </select>
            <br />
            <label class="header">Content <span style="color: #777;">(End all lines with ';')</span></label>
            <textarea name="content" placeholder="Write your poem here..."></textarea>
            <br />
            <br />
            <button type="submit" name="post" value="post" class="ui fluid large teal submit button">Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Footer -->
  <?php include("footer.php"); ?>
</body>

</html>
