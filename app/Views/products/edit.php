<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3"><a href="<?= route_to('products.index') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
      </a> Edit Product</h4>

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

      <div class="mb-3">
        <label>Status</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="status_active" name="status" value="1" <?= old('status', $product['status']) == '1' ? 'checked' : '' ?>>
          <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="status_inactive" name="status" value="0" <?= old('status', $product['status']) == '0' ? 'checked' : '' ?>>
          <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
      </div>

      <button type="submit" class="btn btn-blue-950">Update Product</button>
    </form>
  </div>
</div>


<?= $this->endSection() ?>