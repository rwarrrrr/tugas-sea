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
                <label>Meal Type</label>
                <div class="form-check">
                    <input class="form-check-input" name="meal_types[]" type="checkbox" value="breakfast" id="breakfast">
                    <label class="form-check-label" for="breakfast">Breakfast</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="meal_types[]" type="checkbox" value="lunch" id="lunch">
                    <label class="form-check-label" for="lunch">Lunch</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="meal_types[]" type="checkbox" value="dinner" id="dinner">
                    <label class="form-check-label" for="dinner">Dinner</label>
                </div>
            </div>
            <div class="mb-3">
                <label>Delivery Days</label>
                <div class="row">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" name="delivery_days[]" type="checkbox" value="{{ strtolower($day) }}" id="{{ strtolower($day) }}">
                                <label class="form-check-label" for="{{ strtolower($day) }}">{{ $day }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
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