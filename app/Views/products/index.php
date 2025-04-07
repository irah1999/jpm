<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card card-theme p-4 mb-4">
    <h4 class="text-blue-950 mb-3">Product List</h4>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <div class="d-flex justify-content-end">
      <a href="<?= site_url('products/create') ?>" class="btn btn-blue-950 mb-3 btn-sm">+ Add Product</a>
    </div>

    <table id="products-table" class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Description</th>
          <th style="min-width:70px;">Image</th>
          <th style="min-width:110px;">Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(function () {
    $('#products-table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: "<?= site_url('products/datatables') ?>",
      columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'category_name' },
        { data: 'price' },
        { data: 'description' },
        { 
          data: 'image',
          render: function(data) {
            return `<img src="/uploads/${data}" height="50">`;
          }
        },
        { 
          data: 'action',
          orderable: false,
          searchable: false,
          // render: function(id) {
          //   return `
          //     <a href="/products/edit/${id}" class="btn btn-sm btn-warning">Edit</a>
          //     <form action="/products/delete/${id}" method="post" class="d-inline">
          //       <?= csrf_field() ?>
          //       <input type="hidden" name="_method" value="DELETE">
          //       <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
          //     </form>
          //   `;
          // }
        }
      ]
    });
  });
</script>

<?= $this->endSection() ?>
