<section class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <!-- Registration Form -->
      <form action="<?php echo URLROOT; ?>/admin/add_user" method="post">
        <div class="row form-group">
          <div class="col-md-4">
            <label for="name">Privileges</label>
            <select type="text" name="user_role" class="form-control form-control-lg">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control form-control-lg 
          <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['name']; ?>">
          <span class="invalid-feedback text-danger small"><?php echo $data['name_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" class="form-control form-control-lg 
          <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['username']; ?>">
          <span class="invalid-feedback text-danger small"><?php echo $data['username_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="username">Email</label>
          <input type="text" name="email" class="form-control form-control-lg 
          <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback text-danger small"><?php echo $data['email_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control form-control-lg 
          <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback text-danger small"><?php echo $data['password_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="password_confirm">Confirm Password</label>
          <input type="password" name="password_confirm" class="form-control form-control-lg 
          <?php echo (!empty($data['password_confirm_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['password_confirm']; ?>">
          <span class="invalid-feedback text-danger small"><?php echo $data['password_confirm_err']; ?></span>
        </div>
        <div class="row">
          <div class="col-md-4">
            <input type="submit" value="Add" class="btn text-light btn-success btn-block">
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<br>