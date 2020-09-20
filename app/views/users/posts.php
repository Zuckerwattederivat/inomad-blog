<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero pl-0 pr-0 all-posts-cont">

  <!-- user nav -->
  <div class="container-fluid bg-dark-custom-2 text-light p-3 pt-4">
    <div class="row">
      <div class="col-md-6 mb-2">
        <div class="row">
          <div class="col d-flex align-items-center justify-content-end">
            <img width="100px" src="<?php echo URLROOT.'/img/users/'.$data['user']->user_image; ?>" class="avatar img-thumbnail" alt="avatar">
            <div class="col">
              <h4 class="mb-2"><?php echo $data['user']->user_alias?></h4>
              <span class="<?php echo ($data['post_count'] > 0) ? "text-success" : "text-danger"; ?>"><strong><i class="fa fa-clipboard"></i> Posts: </strong><?php echo $data['post_count']; ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $data['user']->user_id) : ?>
        <div class="col-md-6 d-flex align-items-center justify-content-end">
          <button class="btn btn-start-edit btn-info text-light mr-3">Manage</button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- posts -->
  <div class="container">
    <div class="row mt-5">

      <!--  flash message -->
      <div class="col-md-12 text-center">
        <?php flash('posts_alert'); ?>
      </div>
      
      <!-- posts -->
      <div class="col-md-12 mx-auto row posts-ajax"></div>
      
    </div>
  </div>
  
  <!-- no posts -->
  <?php if ($data['post_count'] <= 0) : ?>
    <div id="no-posts-cont" class="container-fluid d-flex flex-column justify-content-center">
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <a href='https://www.freepik.com/vectors/data'>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
                <img width="300px" src="<?php echo URLROOT.'/img/site/no_posts.jpg'; ?>" alt="No posts">
              </div>
              <div class="col-md-12 d-flex justify-content-center">
                Data vector created by stories - www.freepik.com
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-center">
        <h4><?php echo $data['h4_1']; ?></h4>
        </div>
      </div>
    </div>
  <?php endif; ?>

</section>

<!-- Delete Confirm Modal -->
<div id="confirm-delete" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box">
          <i class="material-icons">&#xE5CD;</i>
        </div>				
        <h4 class="modal-title">Are you sure?</h4>	
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/users/posts/'.$data['user']->user_id; ?>');">&times;</button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete this post? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/users/posts/'.$data['user']->user_id; ?>');">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="window.location.reload();">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Lazy Loading & Manage Buttons JS -->
<?php include APPROOT . "/views/includes/users_posts_script.php"?>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>