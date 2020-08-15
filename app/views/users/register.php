<!-- Header
------------------------------------->
<?php require APPROOT . '/views/includes/header.php'; ?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero bg-image pt-5 pb-5">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-7 mx-auto">
        <div class="card card-body text-light bg-dark-trans">
          <h2><?php echo $data['lead']; ?></h2>
          <p><?php echo $data['description']; ?></p>
          
          <!-- Registration Form -->
          <form action="<?php echo URLROOT; ?>/users/register" method="post">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control form-control-lg 
              <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['name']; ?>">
              <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control form-control-lg 
              <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['username']; ?>">
              <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="username">Email</label>
              <input type="text" name="email" class="form-control form-control-lg 
              <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['email']; ?>">
              <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control form-control-lg 
              <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['password']; ?>">
              <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="password_confirm">Confirm Password</label>
              <input type="password" name="password_confirm" class="form-control form-control-lg 
              <?php echo (!empty($data['password_confirm_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['password_confirm']; ?>">
              <span class="invalid-feedback"><?php echo $data['password_confirm_err']; ?></span>
            </div>
            <div class="row mt-5">
              <div class="col">
                <input type="submit" value="Register" class="btn text-light btn-success btn-block">
              </div>
              <div class="col">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-block text-white btn-orange">Login</a>
              </div>
            </div>
          </form>
          
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer
------------------------------------->
<?php require APPROOT . '/views/includes/footer_without_hero.php'; ?>