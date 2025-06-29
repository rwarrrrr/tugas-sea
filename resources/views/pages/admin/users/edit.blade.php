<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="editUserForm" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>