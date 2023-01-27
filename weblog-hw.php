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
        echo '<post class="post" id="' . $post['id'] . '">';
        echo '  <h2 class=post-title id="' . htmlspecialchars($post['id']) . '">';
        echo '    ' . htmlspecialchars($post['title']);
        echo '    <a href="#' . htmlspecialchars($post['id']) . '">';
        echo '      <i class="material-icons">link</i>';
        echo '    </a>';
        echo '  </h2>';
        echo '  <div class="post-body">';
        echo '    ' . htmlspecialchars($post['body']);
        echo '  </div>';

        echo '  <h3>' . count(array_filter($comments, function($comment) use($post) { return $comment['post_id'] == $post['id']; })) . ' Comments</h3>';
        echo '  <div class="comment-block">';

        foreach (array_filter($comments, function($comment) use($post) { return $comment['post_id'] == $post['id']; }) as $comment) {
          echo '    <comment>';
          echo '      <div class="comment-body">';
          echo '        ' . htmlspecialchars($comment['body']);
          echo '      </div>';
          echo '      <div class="comment-author">';
          echo '        ' . htmlspecialchars($comment['author']);
          echo '      </div>';
          echo '    </comment>';
        }

        echo '    <a href="leave_comment-hw.php?post_id=' . $post['id'] . '">';
        echo '      <i class="material-icons">create</i>';
        echo '      Leave a comment';
        echo '    </a>';
        echo '  </div>';
        echo '</post>';
}
?>

  </div> <!-- end of posts block -->
</body>