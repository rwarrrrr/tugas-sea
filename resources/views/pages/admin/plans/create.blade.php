<div class="modal fade" id="addPlanModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="addPlanForm" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Plan Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required min="10000">
            <div class="invalid-feedback">Harga minimal Rp10.000</div>
          </div>
            <div class="mb-3">
                <label>Highlight</label>
                <input type="text" name="highlight" class="form-control" maxlength="191" required>
            </div>
            <div class="mb-3">
                <label>Duration</label>
                <input type="text" name="duration" class="form-control" maxlength="50" required>
            </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
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
          <button class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>