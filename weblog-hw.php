<?php
$db = new PDO('sqlite:db/weblog.sqlite3');

// Use no more than two queries to get the existing posts and their comments
$posts = $db->query("SELECT * FROM posts ORDER BY id DESC")->fetchAll();
$comments = $db->query("SELECT * FROM comments ORDER BY post_id, id")->fetchAll();
?>

<html>

<head>
  <title>Exercise 3 - A Web Journal</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
  <div class="compose-button">
    <a href="create_post-hw.php" title="create post">
      <i class="material-icons">create</i>
    </a>
  </div>

  <h1>RC's Web Journal</h1>

  <div id="posts">
    <?php
    foreach ($posts as $post) {
      ?>
      <post class="post" id="<?php echo $post['id']; ?>">
        <h2 class=post-title id="<?php echo htmlspecialchars($post['id']); ?>">
          <?php echo htmlspecialchars($post['title']); ?>
          <a href="#<?php echo htmlspecialchars($post['id']); ?>">
            <i class="material-icons">link</i>
          </a>
        </h2>
        <div class="post-body">
          <?php echo htmlspecialchars($post['body']); ?>
        </div>

        <h3>
          <?php echo count(array_filter($comments, function ($comment) use ($post) {
            return $comment['post_id'] == $post['id'];
          })); ?> Comments
        </h3>
        <div class="comment-block">
          <?php
          foreach (array_filter($comments, function ($comment) use ($post) {
            return $comment['post_id'] == $post['id'];
          }) as $comment) {
            ?>
            <comment>
              <div class="comment-body">
                <?php echo htmlspecialchars($comment['body']); ?>
              </div>
              <div class="comment-author">
                <?php echo htmlspecialchars($comment['author']); ?>
              </div>
            </comment>
          <?php
          }
          ?>
          <a href="leave_comment-hw.php?post_id=<?php echo $post['id']; ?>">
            <i class="material-icons">create</i>
            Leave a comment
          </a>
        </div>
      </post>
    <?php
    }
    ?>
  </div> <!-- end of posts block -->
</body>

</html>