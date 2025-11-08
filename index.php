<?php
include 'header.php';
include_once 'connection.php';   //  keep backend unchanged 
$mysqli = getDBConnection();

// Now you can safely use it
$stmt = $mysqli->prepare("SELECT * FROM blogPost ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>MyBlog - Home</title>

  <link rel="icon" type="image/svg" href="img/myblog-logo.svg">
  <img src="img/myblog-logo.svg" alt="Site Logo" class="img-fluid" style="height: 50px;">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>


  <main class="container my-5">
    <h1 class="text-center mb-4">Welcome to MyBlog</h1>
    <p class="text-center"><b>Your thoughts, your stories, your world.</b></p>
    <br>
    <br>

    <hr>
    <div class="row align-items-center mb-4">
      <div class="col-md-8">
        <h1 class="mb-0">Latest Posts</h1>
        <p style="font-style: italic; font-size: 18px;" class="text-muted small">
          Read the latest stories from the community
        </p>
      </div>
      <div class="col-md-4 text-md-end">
        <?php if (!empty($_SESSION['user'])): ?>
          <a href="create_post.php" class="btn btn-gold">Create Post</a>
        <?php else: ?>
          <a href="signIn.php" class="btn btn-outline-gold fw-bold">Sign In to Create</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="row" id="blogs">
      <?php
      // search support
      $search = trim($_GET['search'] ?? '');
      if ($search !== '') {
        $stmt = $mysqli->prepare("SELECT b.blog_id,b.title,b.content,b.created_at,u.username FROM blogPost b JOIN user u ON b.user_user_id = u.user_id WHERE b.title LIKE CONCAT('%',?,'%') OR b.content LIKE CONCAT('%',?,'%') ORDER BY b.created_at DESC");
        $stmt->bind_param('ss', $search, $search);
      } else {
        $stmt = $mysqli->prepare("SELECT b.blog_id,b.title,b.content,b.created_at,u.username FROM blogPost b JOIN user u ON b.user_user_id = u.user_id ORDER BY b.created_at DESC");
      }
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows === 0): ?>
        <div class="col-12">
          <div class="alert alert-secondary">No matching blogs found.</div>
        </div>
        <?php else:
        while ($row = $res->fetch_assoc()):
        ?>
          <div class="col-md-6 mb-4">
            <div class="blog-card blog-area">
              <h5><a href="view_post.php?id=<?= $row['blog_id'] ?>"><?= htmlspecialchars($row['title']) ?></a></h5>
              <p class="meta">By <?= htmlspecialchars($row['username']) ?> • <?= $row['created_at'] ?></p>
              <p><?= nl2br(htmlspecialchars(mb_strimwidth($row['content'], 0, 220, '...'))) ?></p>
              <div class="d-flex justify-content-between">
                <a class="btn btn-sm btn-outline-primary" href="view_post.php?id=<?= $row['blog_id'] ?>">Read</a>
                <a class="btn btn-sm btn-outline-secondary share-btn" data-id="<?= $row['blog_id']; ?>">Share</a>

              </div>
            </div>
          </div>
      <?php endwhile;
      endif;
      $stmt->close(); ?>
    </div>
  </main>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>

</html>