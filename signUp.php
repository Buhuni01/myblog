<?php include 'header.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MyBlog - Register</title>
   <img src="img/myblog-logo.svg" alt="Site Logo" class="img-fluid" style="height: 50px;">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5 d-flex justify-content-center">
  <div class="auth-card">
    <h3 class="text-center">Create Account</h3>
    <form id="signupForm">
      <div class="mb-3"><label class="form-label">Full Name</label><input name="name" id="name" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Email</label><input name="email" id="email" type="email" class="form-control" required></div>

      <div class="mb-3 position-relative">
        <label class="form-label">Password</label>
        <div class="input-group">
          <input name="password" id="password" type="password" class="form-control" required minlength="6">


          <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password"><i class="bi bi-eye-slash"></i></button>
        </div>
      </div>

      <div class="mb-3 position-relative">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
          <input name="confirmPassword" id="confirmPassword" type="password" class="form-control" required minlength="6">
          <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmPassword"><i class="bi bi-eye-slash"></i></button>
        </div>
      </div>

      <button class="btn btn-gold w-100" type="submit">Sign Up</button>
      <p class="text-center mt-3 mb-0 small">Already have an account? <a href="signIn.php" class="text-warning">Sign In</a></p>
    </form>
  </div> 
</main>
 <!-- Footer -->
  <footer class="pt-4 pb-4">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <p class="mb-0">Copyright &copy;<?= date('Y') ?> <strong>MyBlog</strong> || All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
