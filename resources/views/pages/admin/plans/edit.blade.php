<div class="modal fade" id="editPlanModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="editPlanForm" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" id="edit_price" class="form-control" min="10000" required>
          </div>
            <div class="mb-3">
                <label>Highlight</label>
                <input type="text" name="highlight" id="edit_highlight" class="form-control" maxlength="191" required>
            </div>
            <div class="mb-3">
                <label>Duration</label>
                <input type="text" name="duration" id="edit_duration" class="form-control" maxlength="50" required>
            </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea name="description" id="edit_description" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" id="edit_image" class="form-control">
            <img id="edit_preview" src="#" alt="Preview" class="mt-2 rounded" style="display:none; max-height: 150px;">
          </div>
            <div class="mb-3">
                <label>Active</label>
                <select name="is_active" class="form-select">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>