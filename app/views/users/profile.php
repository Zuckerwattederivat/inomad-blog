<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero">

  <div class="container mt-3 mb-5">
    <!--  flash message -->
      <div class="row">
        <div class="col-md-12 text-center">
          <?php flash('profile_alert'); ?>
        </div>
      </div>
    <!-- user info form -->
    <form action="<?php echo URLROOT; ?>/users/profile" method="post" enctype="multipart/form-data">
      <div class="row">
        
        <!--left column profile-->
        <div class="col-md-5 mt-3">
          <div class="card h-100">
            <div class="card-header">Update your profile</div>
            <!--Card content-->
            <div class="card-body">
              <h6 class="text-center pt-1 pb-3">Optional</h6>
              <div class="row">
                <div class="col-md-12 pl-5"><h4><?php echo $data['username']?></h4></div>
              </div>
              <!-- profile pic -->
              <div class="text-center form-group container-fluid">
                <img src="<?php echo URLROOT.'/img/users/'.$data['user']->user_image; ?>" class="mb-3 img-thumbnail" alt="avatar">
                <br>
                <div class="input-group">
                  <div class="custom-file">
                    <input id="user_image" class="custom-file-input" type="file" name="user_image" class="form-control form-control-lg" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="user_image">Choose file</label>
                  </div>
                </div>
                <span class="text-danger small"><?php echo $data['user_image_err']; ?></span>
              </div>
              <div class="form-group">
                <textarea rows="4" name="user_bio" class="col-md-12 block mt-2 mb-1"><?php echo $data['user_bio']; ?></textarea>
              </div>
              <!-- activity -->
              <ul class="list-group">
                <li class="list-group-item text-muted"><i class="fa fa-dashboard fa-1x"></i> Activity </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> <?php echo $data['post_count']; ?></li>
                <!-- <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li> -->
              </ul> 
            </div>
          </div>
        </div><!--/col-4-->

        <!-- right column user info-->
        <div class="col-md-7 mt-3">
          <div class="card text-dark h-100">
            <div class="card-header">Update your information</div>
            <div class="card-body">
              <h6 class="text-center pt-1 pb-3">Required</h6>
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
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control form-control-lg 
                <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
              </div>
              <hr>
              <div class="form-group">
                <h6 class="text-center pt-1 pb-3">Optional</h6>
                <label for="password">Change Password</label>
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
                <div class="col-md-4 mb-2">
                  <input type="submit" value="Update All" class="btn btn-block text-light btn-success">
                </div>
                <div class="col-md-4">
                <input type="reset" value="Reset" class="btn btn-block btn-danger">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Latest Posts Column -->
        <div class="col-md-12 mt-3">
          <div class="card h-100">
            <div class="card-header">Your latest posts</div>
            <?php if (empty($data['posts_newest'])) : ?>
              <p class="pl-4 pt-4">You have no posts yet.</p>
            <?php else : ?>
              <!--Card content-->
              <div class="card-body">
                <ul class="list-unstyled">
                  <?php foreach ($data['posts_newest'] as $post) : ?>
                    <li class="message-preview">
                    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->post_id; ?>" class="text-dark">
                      <div class="media overflow-hidden">
                        <span class="pull-left mr-3">
                          <img class="media-object" style="width: 100px" src="<?php echo URLROOT . "/img/posts/thumb_" .  $post->post_image; ?>" alt="<?php echo $post->post_image; ?>">
                        </span>
                        <div class="media-body">
                          <h5 class="media-heading">
                            <strong><?php echo $post->post_title; ?></strong>
                          </h5>
                          <p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo $post->post_date; ?></p>
                          <p><?php echo substrwords($post->post_content, 200, $end='...'); ?></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <?php endforeach; ?>
                </ul>
                <div class="col-md-2 mt-2 pl-0 pr-0">
                  <a href="<?php echo URLROOT."/users/posts/".$_SESSION['user_id']; ?>" class="btn btn-orange btn-block text-light">All Your Posts</a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        
      </div>
      <!--/row-->
    </form>
    <!-- /form -->
    
  </div>
</section>

<!-- Input Control Javascript -->
<script src="<?php echo URLROOT; ?>/js/upload_input.js"></script>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>