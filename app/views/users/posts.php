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
          <img width="300px" src="<?php echo URLROOT.'/img/site/no_posts.jpg'; ?>" alt="No posts">
        </div>
      </div>
      <div class="row">
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

<!-- Lazy Loading & Manage Buttons -->
<script>
  (function() {
    // data vars
    let lower_limit = 0;
    let upper_limit = 8;
    let reachedMax = false;
    let processing = false;
    let user_id = <?php echo $data['user']->user_id; ?>
    // buttons
    let editButton = document.querySelector('.btn-start-edit');
    let btnEdit = document.querySelectorAll('.btn-edit');
    let btnContainer = document.querySelectorAll('.btn-div');
    let btnDelete = document.querySelectorAll('.btn-delete');

    $(document).ready(function() {
      getData();
    })

    $(window).scroll(function() {

      // return if processing is true
      if (processing) {
        return false;
      } 
      
      // if breakpoint was reached fire new ajax request and set processing to true
      if ($(window).scrollTop() >= $(document).height() - $(window).height() - 400) {
        processing = true;
        getData();
      }

      //console.log(lower_limit);
      
      // update vars while scrolling
      editButton = document.querySelector('.btn-start-edit');
      btnEdit = document.querySelectorAll('.btn-edit');
      btnContainer = document.querySelectorAll('.btn-div');
      btnDelete = document.querySelectorAll('.btn-delete');

      // add open class to all element conatiners if edit is open
      btnContainer.forEach(element => {
      
        if (element.classList.contains('open-btn-cont')) {
          
          btnContainer.forEach(element => {
            element.classList.add('open-btn-cont');
          });

          btnEdit.forEach(element => {
            element.classList.add('show-btn');
          });

          btnDelete.forEach(element => {
            element.classList.add('show-btn');
          });
        }
      });
    });

    function getData() {
      if (reachedMax) {
        return;
      } else {
        $.ajax({
          url: '<?php echo URLROOT;?>/ajax/loadPostsUser',
          method: 'POST',
          datatype: 'text',
          data: {
            getData: 1,
            lower_limit: lower_limit,
            upper_limit: upper_limit,
            user_id: user_id
          },
          success: function(response) {
            lower_limit += upper_limit;

            if (response != false) {
              $('.posts-ajax').append(response);
              processing = false;
            } else {
              reachedMax = true;
            }
          }
        });
      }
    }

    // open edit menu
    editButton.addEventListener('click', () => {

      // update vars
      btnEdit = document.querySelectorAll('.btn-edit');
      btnContainer = document.querySelectorAll('.btn-div');
      btnDelete = document.querySelectorAll('.btn-delete');

      btnContainer.forEach(element => {
        element.classList.toggle('open-btn-cont');
      });

      btnEdit.forEach(element => {
        element.classList.toggle('show-btn');
      });

      btnDelete.forEach(element => {
        element.classList.toggle('show-btn');
      });
      
    });
    
  })();
</script>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>