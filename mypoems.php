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

  <?php if( !is_valid() ) { header("Location: login.php?rdr=1"); } ?>

  <div class="ui main container">
    <h1 class="ui header">Self Written</h1>
    <div class="ui three stackable grid cards">
      <?php 
      $getmypoems = mysqli_query( getconn(), "
        SELECT p.poem_id, p.title, g.genre, p.content, u.name, p.likes 
        FROM poems AS p, genre AS g, users AS u 
        WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id AND u.user_id = ".$_SESSION['user_id']
      );
      if( mysqli_num_rows( $getmypoems ) == 0 ) {
        echo "<p>Poems you write will be displayed here.</p>";
      }
      while( $row = mysqli_fetch_array( $getmypoems ) ) {
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
    
    <h1 class="ui header">Poems Liked</h1>
    <div class="ui three stackable grid cards">
      <?php 
      $getlikedpoems = mysqli_query( getconn(), "
        SELECT p.poem_id, p.title, g.genre, p.content, u.name, p.likes 
        FROM poems AS p, genre AS g, users AS u 
        WHERE p.genre_id = g.genre_id 
        AND p.user_id = u.user_id 
        AND p.poem_id IN (
          SELECT poem_id 
          FROM user_likes 
          WHERE user_id = ".$_SESSION['user_id']."
        )
      ");
      if( mysqli_num_rows( $getlikedpoems ) == 0 ) {
        echo "<p>Poems you like will be displayed here</p>";
      }
      while( $row = mysqli_fetch_array( $getlikedpoems ) ) {
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

    <h1 class="ui header">Suggestions</h1>
    <div class="ui three stackable grid cards">
      <?php 
      $getsuggestions = mysqli_query( getconn(), "
        SELECT p.poem_id, p.title, g.genre, p.content, u.name, p.likes 
        FROM poems AS p, genre AS g, users AS u 
        WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id AND p.genre_id IN (
          SELECT genre_id 
          FROM user_genre_visits 
          WHERE user_id = ".$_SESSION['user_id']." 
          ORDER BY count
        ) AND p.poem_id NOT IN (
          SELECT poem_id 
          FROM poems 
          WHERE user_id = ".$_SESSION['user_id']."
        ) AND p.poem_id NOT IN (
          SELECT poem_id 
          FROM user_likes 
          WHERE user_id = ".$_SESSION['user_id']."
        ) AND p.poem_id NOT IN (
          SELECT poem_id 
          FROM user_dislikes 
          WHERE user_id = ".$_SESSION['user_id']."
        ) 
        LIMIT 3
      ");
      if( mysqli_num_rows( $getsuggestions ) == 0 ) {
        echo "<p>Nothing to suggest.</p>";
      }
      while( $row = mysqli_fetch_array( $getsuggestions ) ) {
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
