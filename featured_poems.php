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
    .description {
      max-height: 11em;
      overflow-y: hidden;
    }
  </style>

</head>
<body class="mainbody">

  <!-- Header -->
  <?php include("header.php"); ?>

  <div class="ui main container">
    <h1 class="ui header">Some Featured Poems</h1>
    <div class="ui three stackable grid cards">
      <?php 
      $getmaxlike = mysqli_query( getconn(), "
        SELECT p.poem_id, p.title, g.genre, p.content, u.name, p.likes 
        FROM poems AS p, genre AS g, users AS u 
        WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id 
        ORDER BY p.likes DESC 
        LIMIT 9
      ");
      while( $row = mysqli_fetch_array( $getmaxlike ) ) {
      ?>
      <a href="poem.php?pid=<?php echo $row['poem_id']; ?>" class="ui card">
        <div class="content">
          <div class="header"><?php echo $row['title']; ?></div>
          <div class="meta">
            <span class="category"><?php echo $row['genre']; ?></span>
          </div>
          <div class="description">
            <p><?php echo $row['content']; ?></p>
          </div>
          <div class="description">
            <p><i>(Click card to read full poem)</i></p>
          </div>
        </div>
        <div class="extra content">
          <div class="right floated author">
            By - <?php echo $row['name']; ?>
          </div>
        </div>
      </a>
      <?php } ?>
    </div>
  </div>
  <!-- Footer -->
  <?php include("footer.php"); ?>
</body>

</html>
