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

<body>
  <?php $user = session()->get('user'); ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-blue-950" href="<?= site_url('products') ?>">My Shop</a>

      <div class="ms-auto d-flex align-items-center">
        <?php if ($user): ?>
          <span class="me-3 text-muted">Welcome, <strong><?= esc($user['name']) ?></strong></span>
          <img src="<?= base_url('uploads/profile/' . ($user['image'] ?? 'avatar.svg' )) ?>" alt="Profile" class="rounded-circle" width="40" height="40">
          <a href="<?= site_url('logout') ?>" class="btn btn-outline-secondary ms-3">Logout</a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="btn btn-primary">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <?= $this->renderSection('content') ?>
</body>

</html>