<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3">Category List</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-end">
      <a href="<?= route_to('categories.create') ?>" class="btn btn-blue-950 mb-3 btn-sm">+ Add Category</a>
    </div>

    <div class="table-responsive">
        <table id="categories-table" class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Status</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>

<script>
  $(function () {
    $('#categories-table').DataTable({
      processing: true,
      serverSide: true,
      order: [[3, 'desc']], // Default order by 4th column (index starts from 0)
      ajax: "<?= site_url('categories/datatables') ?>",
      columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'status' },
        { data: 'updated_at' },
        { data: 'action', orderable: false, searchable: false }
      ]
    });
  });
</script>

<?= $this->endSection() ?>
