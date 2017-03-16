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

  <?php 
  if( isset( $_GET['msg'] ) ) {
    if ( $_GET['msg'] == 'logout' ) {
      echo "<script> alert('Successfully Logged Out'); </script>";
    } elseif ( $_GET['msg'] == 'login' ) {
      echo "<script> alert('Logged in.'); </script>";
    }
  }
  ?>

  <div class="ui main container">
    <h1 class="ui header">Poera - A Social Network for Poets</h1>
    <hr />
    <p>
      Poera is a poetic journey which let's you explore through genres of poetry.
    </p>
    <p>
      It lets you bring out the poet in you. Upload your poems, read through genres, sort your favorites, like and dislike, get recommendations and if you can't be the poet, then be a poem.
    </p>
    <p>
      A poet is a person who conceals profound anguish in his heart but whose lips are so formed that as sighs and cries pass over them, they sound like beautiful music. Poetry is not only a dream and vision, it is the skeleton architecture of our lives.
      It lays foundations for a future of change, a bridge across our fears of what has never been before, so come be a part of this poetic journey because there's a poem for all.
    </p>
    <p>
      Poera - for the poet in you.
    </p>
    <hr />
    <h1 class="ui header">Some Featured Poems</h1>
    <div class="ui three stackable grid cards">
      <?php 
      $getmaxlike = mysqli_query( getconn(), "
        SELECT p.poem_id, p.title, g.genre, p.content, u.name, p.likes 
        FROM poems AS p, genre AS g, users AS u 
        WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id 
        ORDER BY p.likes DESC 
        LIMIT 3
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

    <h1 class="ui header">Hall of Fame</h1>
    <div class="ui five stackable grid cards">
    <?php 
    $getusers = mysqli_query( getconn(), "
      SELECT p.user_id, u.email, u.name, u.phone, count(poem_id) AS no_of_poems, sum(likes) AS total_likes 
      FROM poems AS p, users AS u 
      WHERE p.user_id = u.user_id 
      GROUP BY user_id 
      ORDER BY sum(likes) DESC 
      LIMIT 5
    ");
    while( $row = mysqli_fetch_array( $getusers ) ) { ?>
    <a href="search.php?s=<?php echo $row['name']; ?>" class="ui card">
      <div class="content">
        <div class="header"><?php echo $row['name']; ?></div>
        <div class="meta">
          <span class="group"><?php echo $row['email']; ?></span><br />
          <span class="group"><?php echo $row['phone']; ?></span>
        </div>
      </div>
      <div class="extra content">
        <span class="right floated created"><?php echo $row['no_of_poems']; ?> poems</span>
        <span class="friends"><?php echo $row['total_likes']; ?> likes</span>
      </div>
    </a>
    <?php } ?>
    </div>
  </div>
  <!-- Footer -->
  <?php include("footer.php"); ?>
</body>

</html>
