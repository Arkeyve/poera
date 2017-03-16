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
    <h1 class="ui header">Poems</h1>
    <div class="ui three stackable grid cards">
      <?php 
      
      $getpoems_query = "
      SELECT p.poem_id, p.title, g.genre, p.content, u.name, u.email, p.likes 
      FROM poems AS p, genre AS g, users AS u 
      WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id
      AND (
        upper(p.title) like concat('%', upper('".$_GET['s']."'), '%') OR
        upper(g.genre) like concat('%', upper('".$_GET['s']."'), '%') OR
        upper(p.content) like concat('%', upper('".$_GET['s']."'), '%') OR
        upper(u.name) like concat('%', upper('".$_GET['s']."'), '%') OR
        upper(u.email) like concat('%', upper('".$_GET['s']."'), '%')
      )
      ";
      
      $getpoems = mysqli_query( getconn(), $getpoems_query);

      if( mysqli_num_rows( $getpoems ) == 0 ) {
        echo "<p>No poem matches \"".$_GET['s']."\"</p>";
      }
      while( $row = mysqli_fetch_array( $getpoems ) ) {
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

      <h1 class="ui header">Users</h1>
      <div class="ui five stackable grid cards">
        <?php 
        $getusers_query = "
        SELECT p.user_id, u.email, u.name, u.phone, count(poem_id) AS no_of_poems, sum(likes) AS total_likes 
        FROM poems AS p, users AS u 
        WHERE p.user_id = u.user_id AND (
          upper(u.name) like concat('%', upper('".$_GET['s']."'), '%') OR
          upper(u.email) like concat('%', upper('".$_GET['s']."'), '%')
        )
        GROUP BY user_id
        ";

        $getidleusers_query = "
        SELECT u.email, u.name, u.phone
        FROM users AS u 
        WHERE (
            upper(u.name) like concat('%', upper('".$_GET['s']."'), '%') OR
            upper(u.email) like concat('%', upper('".$_GET['s']."'), '%')
        )
        AND u.user_id NOT IN (
          SELECT p.user_id 
          FROM poems AS p, users AS u 
          WHERE p.user_id = u.user_id AND (
            upper(u.name) like concat('%', upper('".$_GET['s']."'), '%') OR
            upper(u.email) like concat('%', upper('".$_GET['s']."'), '%')
          )
          GROUP BY user_id
        )
        ";

        $getusers = mysqli_query( getconn(), $getusers_query);
        $getidleusers = mysqli_query( getconn(), $getidleusers_query);

        if( mysqli_num_rows( $getusers ) == 0 && mysqli_num_rows( $getidleusers ) == 0 )  {
          echo "<p>No user matches \"".$_GET['s']."\"</p>";
        }
        while( $row = mysqli_fetch_array( $getusers ) ) {
          ?>
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
          <?php }

          while( $row = mysqli_fetch_array( $getidleusers ) ) {
            ?>
            <a href="search.php?s=<?php echo $row['name']; ?>" class="ui card">
              <div class="content">
                <div class="header"><?php echo $row['name']; ?></div>
                <div class="meta">
                  <span class="group"><?php echo $row['email']; ?></span><br />
                  <span class="group"><?php echo $row['phone']; ?></span>
                </div>
              </div>
              <div class="extra content">
                <span class="right floated created">0 poems</span>
                <span class="friends">0 likes</span>
              </div>
            </a>
            <?php } ?>
          </div>
        </div>
        <!-- Footer -->
        <?php include("footer.php"); ?>
      </body>

      </html>
