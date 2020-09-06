<!-- Header
------------------------------------->
<?php require APPROOT . '/views/includes/header.php'; ?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero bg-image vh-100">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-7 mx-auto">
        <div class="card card-body text-light bg-dark-trans">
          <?php flash('login_alert'); ?>
          <h2><?php echo $data['lead']; ?></h2>
          <p><?php echo $data['description']; ?></p>
          
          <!-- Registration Form -->
          <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="form-group">
              <label for="email">Email</label>
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
            <div class="row mt-5">
              <div class="col">
                <input type="submit" value="Login" class="btn text-light btn-success btn-block">
              </div>
              <div class="col">
                <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-block text-white btn-orange">Register</a>
              </div>
            </div>
            <!-- <div class="container mt-3">
            <a href="<?php echo URLROOT; ?>/users/password_reset" class="btn btn-block text-white btn-block">Forgot your Password?</a>
            </div> -->
          </form>
          
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer
------------------------------------->
<?php require APPROOT . '/views/includes/footer_without_hero.php'; ?>