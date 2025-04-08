<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Jewellery App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<style>
  .navbar .nav-link.active {
    border-bottom: 2px solid #1e3a8a;
    /* Tailwind's blue-950 */
    color: #1e3a8a !important;
    font-weight: 600;
  }
</style>

<body>
  <?php $user = session()->get('user');
  $profileImg = base_url('assets/images/avatar.svg');
  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-blue-950" href="<?= route_to('products.index') ?>">Jwellary Product Management System</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?= url_is('products*') ? 'active' : '' ?>" href="<?= route_to('products.index') ?>">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= url_is('categories*') ? 'active' : '' ?>" href="<?= route_to('categories.index') ?>">Categories</a>
          </li>
        </ul>

        <div class="d-flex align-items-center ms-auto">
          <?php if (isset($user) && $user): ?>
            <span class="me-3 text-muted">Welcome, <strong><?= esc($user['name']) ?></strong></span>
            <img src="<?= $profileImg; ?>" alt="Profile" class="rounded-circle" width="40" height="40">
            <a href="<?= route_to('logout') ?>" class="btn btn-outline-secondary ms-3">Logout</a>
          <?php else: ?>
            <a href="<?= site_url('login') ?>" class="btn btn-primary">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <?= $this->renderSection('content') ?>
</body>

</html>