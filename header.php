<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!-- SweetAlert2 & Bootstrap Icons -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<?php if (!empty($_SESSION['flash_success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  Swal.fire({ icon:'success', title:'Success', text: <?php echo json_encode($_SESSION['flash_success']); ?>, confirmButtonColor:'#ffc107' });
});
</script>
<?php unset($_SESSION['flash_success']); endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  Swal.fire({ icon:'error', title:'Error', text: <?php echo json_encode($_SESSION['flash_error']); ?>, confirmButtonColor:'#ffc107' });
});
</script>
<?php unset($_SESSION['flash_error']); endif; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-warning" href="index.php"><i class="bi bi-journal-text me-2"></i>MyBlog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto"></ul>
      <form class="d-flex mx-auto my-2" id="searchForm" style="width:50%;min-width:220px" onsubmit="event.preventDefault(); searchBlogs();">
        <input id="searchInput" class="form-control me-2" type="search" placeholder="Search blogs...">
        <button class="btn btn-warning text-dark" type="submit"><i class="bi bi-search"></i></button>
      </form>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="create_post.php">New Post</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="acc" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end bg-dark">
              <li><a class="dropdown-item text-light" href="dashboard.php">Dashboard</a></li>
              <li><a class="dropdown-item text-light" href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="signIn.php">Sign In</a></li>
          <li class="nav-item"><a class="nav-link btn btn-outline-warning text-dark ms-2" href="signUp.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
