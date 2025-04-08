<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3"><a href="<?= route_to('categories.index') ?>"><i class="fa-solid fa-arrow-left"></i>
    </a> <?= isset($category) ? 'Edit' : 'Create' ?> Category</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= isset($category) ? route_to('categories.update', $category['id']) : route_to('categories.store') ?>" method="post">
      <?= csrf_field() ?>
      <?php if (isset($category)): ?>
        <input type="hidden" name="_method" value="PUT">
      <?php endif; ?>

      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= old('name', $category['name'] ?? '') ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Status</label><br>
        <label><input type="radio" name="status" value="1" <?= old('status', $category['status'] ?? '1') == '1' ? 'checked' : '' ?>> Active</label>
        <label class="ms-3"><input type="radio" name="status" value="0" <?= old('status', $category['status'] ?? '') == '0' ? 'checked' : '' ?>> Inactive</label>
      </div>

      <button class="btn btn-blue-950">Save</button>
      <a href="<?= route_to('categories.index') ?>" class="btn btn-secondary">Back</a>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
