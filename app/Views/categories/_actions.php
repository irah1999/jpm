<a href="<?= route_to('categories.edit', $id) ?>" class="btn btn-sm btn-warning">Edit</a>
<form action="<?= route_to('categories.delete') ?>" method="post" class="d-inline">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= $id; ?>">
  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
</form>
