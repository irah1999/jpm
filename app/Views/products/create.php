<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3"><a href="<?= route_to('products.index') ?>"><i class="fa-solid fa-arrow-left"></i>
    </a> Create Product</h4>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= route_to('products.store') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <option value="">-- Select Category --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" name="price" class="form-control" step="0.01" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" required maxlength="500"></textarea>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-blue-950">Save Product</button>
    </form>
  </div>
</div>


<?= $this->endSection() ?>
