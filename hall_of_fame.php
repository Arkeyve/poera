<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>Theming - Semantic</title>

  <link rel="stylesheet" type="text/css" href="./dist/semantic.css">

  <script src="assets/library/jquery.min.js"></script>
  <script src="./dist/semantic.js"></script>


  <!--- Example Javascript -->
  <script>
    $(document)
    .ready(function() {
      $('.special.card .image').dimmer({
        on: 'hover'
      });
      $('.star.rating')
      .rating()
      ;
      $('.card .dimmer')
      .dimmer({
        on: 'hover'
      })
      ;
    })
    ;
  </script>
</head>

<body class="mainbody">
  <!-- Header -->
  <?php include("header.php"); ?>
<div class="ui main container">
  <div class="ui five stackable grid cards">
    <?php 
    $getusers = mysqli_query( getconn(), "
      SELECT p.user_id, u.email, u.name, u.phone, count(poem_id) AS no_of_poems, sum(likes) AS total_likes 
      FROM poems AS p, users AS u 
      WHERE p.user_id = u.user_id 
      GROUP BY user_id 
      ORDER BY sum(likes) DESC 
      LIMIT 15
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
</body>
<?php include("footer.php"); ?>
</html>