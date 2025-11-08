<?php
require_once 'connection.php';
include_once 'connection.php';
$mysqli = getDBConnection();

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { 
  $_SESSION['flash_error'] = 'Please sign in.'; 
  header('Location: signIn.php'); 
  exit; 
}

include 'header.php';

// Handle search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$userId = $_SESSION['user']['id'];

if (!empty($searchQuery)) {
  $stmt = $mysqli->prepare("SELECT blog_id, title, created_at FROM blogPost WHERE user_user_id = ? AND title LIKE ? ORDER BY created_at DESC");
  $likeSearch = "%{$searchQuery}%";
  $stmt->bind_param('is', $userId, $likeSearch);
} else {
  $stmt = $mysqli->prepare("SELECT blog_id, title, created_at FROM blogPost WHERE user_user_id = ? ORDER BY created_at DESC");
  $stmt->bind_param('i', $userId);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MyBlog - Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Your Posts</h3>
    <a href="create_post.php" class="btn btn-gold">New Post</a>
  </div>
  

  <div class="list-group">
    <?php if ($res->num_rows === 0): ?>
      <?php if (!empty($searchQuery)): ?>
        <div class="alert alert-warning text-center">
          No matching blogs found in your posts.
        </div>
      <?php else: ?>
        <div class="alert alert-warning text-center">
          No any blogs yet. Create your own blog <a href="create_post.php" class="alert-link">here</a>!
        </div>
      <?php endif; ?>
    <?php else: ?>
      <?php while ($row = $res->fetch_assoc()): ?>
        <div class="dashboard-post p-3">
          <div class="post-title">
            <a href="view_post.php?id=<?= $row['blog_id'] ?>" class="text-decoration-none">
              <?= htmlspecialchars($row['title']) ?>
            </a>
            <small class="text-muted d-block">Posted on <?= $row['created_at'] ?></small>
          </div>
          <div>
            <a class="btn btn-sm btn-outline-secondary" href="edit_post.php?id=<?= $row['blog_id'] ?>">Edit</a>
            <button type="button" class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['blog_id'] ?>">Delete</button>
          </div>
        </div>
        <br><br>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>

<?php
$stmt->close();
closeDBConnection($mysqli);
?>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Use navbar search for all pages
function searchBlogs() {
  const query = document.getElementById('searchInput').value.trim();
  const currentPage = window.location.pathname.split('/').pop();

  if (currentPage === 'dashboard.php') {
    window.location.href = 'dashboard.php?search=' + encodeURIComponent(query);
  } else {
    window.location.href = 'index.php?search=' + encodeURIComponent(query);
  }
}

// SweetAlert delete confirmation
document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const postId = btn.getAttribute('data-id');

    Swal.fire({
      title: 'Delete post?',
      text: 'This action cannot be undone.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#778796ff',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `delete_post.php?id=${postId}`;
      }
    });
  });
});
</script>

</body>
</html>
