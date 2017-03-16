<?php include("sqlconn.php"); ?>
<style>
  .ui.menu .item img.logo {
    margin-right: 1.5em;
  }

  body.mainbody {
    margin-top: 7em;
  }

  i.empty.heart.icon:hover {
    color: #000;
    cursor: pointer;
  }

  .ui.main.container {
    min-height: 90vh;
  }
</style>
<div class="ui fixed inverted menu">
  <div class="ui container">
    <a href="#" class="header item">
      <img class="logo" src="assets/images/logo.png">
      Poera
    </a>
    <a href="index.php" class="item">Home</a>
    <a href="hall_of_fame.php" class="item">Hall of Fame</a>
    <a href="featured_poems.php" class="item">Featured Poems</a>
    <div class="ui simple dropdown item">
      Genres <i class="dropdown icon"></i>
      <div class="menu">
      <?php
      $getgenres = mysqli_query( getconn(), "
        SELECT * 
        FROM genre
      ");
      while( $row = mysqli_fetch_array( $getgenres ) ) {
        echo '<a class="item" href="search.php?s='.$row['genre'].'">'.$row['genre'].'</a>';
      }
      ?>
      </div>
    </div>
    <span style="width: 70%;"></span>
    <form action="search.php" method="get" style="margin-top: 1.05em;">
      <div class="ui inverted transparent icon input">
        <input type="text" name="s" placeholder="Search..." required="">
        <input type="submit" value=""><i class="search icon"></i>
      </div>
    </form>
    <span style="width: 10%;"></span>
    <?php 
    if( is_valid() ) {
      $name = mysqli_fetch_array( mysqli_query( getconn(), "
        SELECT name 
        FROM users 
        WHERE user_id = ".$_SESSION['user_id'] 
      ) )[0];
      echo '
      <a href="#" class="item">'.$name.'</a>
      <div class="ui simple dropdown item">
        Dashboard <i class="dropdown icon"></i>
        <div class="menu">
          <div class="item">
          Poems <i class="dropdown icon"></i>
            <div class="menu">
              <a href="./newpoem.php" class="item">Write Poem</a>
              <a href="./mypoems.php" class="item">My Poems</a>
            </div>
          </div>
          <div class="item">
          Messages <i class="dropdown icon"></i>
            <div class="menu">
              <a href="./messages.php" class="item">Messages</a>
              <a href="./messages.php?sent=1" class="item">Sent Messages</a>
            </div>
          </div>
          <a href="./logout.php" class="item">Logout</a>
        </div>
      </div>
      ';
    } else {
      echo '<a href="./login.php" class="item">Login</a>';
    }
    ?>
  </div>
</div>