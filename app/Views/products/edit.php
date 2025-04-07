<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3">Edit Product</h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('products/update') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= encryption($product['id']); ?>">

      <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" value="<?= esc($product['name']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
              <?= esc($cat['name']) ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" name="price" class="form-control" value="<?= esc($product['price']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" required maxlength="500"><?= esc($product['description']) ?></textarea>
      </div>

      <div class="mb-3">
        <label for="old_image" class="form-label">Current Image</label><br>
        <img src="<?= base_url('uploads/' . $product['image']) ?>" height="70">
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">New Image (optional)</label>
        <input type="file" name="image" class="form-control">
      </div>

      <button type="submit" class="btn btn-blue-950">Update Product</button>
    </form>
  </div>
</div>


<?= $this->endSection() ?>
