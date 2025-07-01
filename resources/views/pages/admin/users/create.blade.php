<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="addUserForm" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required
                   pattern="^(08|\+628)[0-9]{8,13}$" title="Nomor HP harus dimulai dengan 08 atau +628 dan diikuti 8-13 digit angka.">
          </div>
          <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
              <input id="password" type="password"
                      class="form-control @error('password') is-invalid @enderror" name="password" required>
                  <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                      <i class="bi bi-eye"></i>
                  </button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>