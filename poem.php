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

  <?php
  if( isset( $_GET['lk'] ) ) {
    if( is_valid() ) {
      like( $_SESSION['user_id'], $_GET['pid'] );
    } else {
      header("Location: login.php?rdr=1");
    }
  } else if( isset( $_GET['dlk'] ) ) {
    if( is_valid() ) {
      dislike( $_SESSION['user_id'], $_GET['pid'] );
    } else {
      header("Location: login.php?rdr=1");
    }
  }

  if( isset( $_POST['post'] ) ) {
    if( is_valid() ) {
      array_walk_recursive( $_POST, "filter" );
      extract( $_POST );
      add_comment( $_SESSION['user_id'], $_GET['pid'], $comment );
    } else {
      header("Location: login.php?rdr=1");
    }
  }

  $getpoem = mysqli_query( getconn(), "
    SELECT p.poem_id, p.title, p.genre_id, g.genre, p.content, u.name, p.likes, p.dislikes 
    FROM poems AS p, genre AS g, users AS u 
    WHERE p.genre_id = g.genre_id AND p.user_id = u.user_id AND p.poem_id = ".$_GET['pid'] 
  );

  $row = mysqli_fetch_array( $getpoem );
  update_user_genre_visit( $_SESSION['user_id'], $row['genre_id'] );

  ?>

  <div class="ui main text container">
    <div class="ui one cards">
      <div class="ui card">
        <div class="content">
        
          <div class="header"><?php echo $row['title']; ?></div>
          <div class="meta">
            <span class="category"><?php echo $row['genre']; ?></span>
          </div>
          <div class="description">
            <p><?php echo $row['content']; ?></p>
          </div>
        </div>
        <div class="extra content">
          <div class="right floated author">
            By - <?php echo $row['name']; ?>
          </div>
        </div>
        <div class="extra content">
          <a href="poem.php?lk=1&pid=<?php echo $row['poem_id']; ?>">
          <div class="ui left floated labeled button" tabindex="0">
            <div class="ui green button">
              <i class="heart icon"></i>Like
            </div>
            <span class="ui basic green left pointing label"><?php echo $row['likes']; ?></span>
          </div>
          </a>
          <a href="poem.php?dlk=1&pid=<?php echo $row['poem_id']; ?>">
          <div class="ui right floated labeled button" tabindex="0">
            <div class="ui red button">
              <i class="empty heart icon"></i>Disike
            </div>
            <span class="ui basic red left pointing label"><?php echo $row['dislikes']; ?></span>
          </div>
          </a>
        </div>
        <div class="extra content">
          <!-- Comment -->
          <div class="ui relaxed divided list">
            <div class="item">
              <div class="content">
                <form class="ui form" action="poem.php?pid=<?php echo $_GET['pid']; ?>" method="post">
                  <div class="ui fluid action input">
                    <?php if( is_valid() ) {
                      echo '
                      <input type="text" name="comment" placeholder="Comment..." />
                      <button type="submit" name="post" value="post" class="ui button">Post</button>
                      ';
                    } else {
                      echo '
                      <input type="text" name="comment" placeholder="Comment..." disabled=""/>
                      <button type="submit" name="post" value="post" class="ui button" disabled="">Post</button>
                      ';
                    } ?>
                  </div>
                </form>
              </div>
            </div>
            <?php 
            $getcomments = mysqli_query( getconn(), "
              SELECT c.comment, u.name 
              FROM comments AS c, users AS u 
              WHERE u.user_id = c.user_id AND c.poem_id = ".$_GET['pid']
            );
            while( $row = mysqli_fetch_array( $getcomments ) ) {
            ?>
            <div class="item">
              <a class="header" ><?php echo $row['name']; ?></a>
              <div class="content"><?php echo $row['comment']; ?></div>
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
