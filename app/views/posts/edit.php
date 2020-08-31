<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero">

  <div class="container mt-5 mb-5">

    <!-- row 1 -->
    <div class="row">
      <div class="col-md-8 mb-4">
        <div class="card card-body text-dark h-100">
          <?php flash('post_alert'); ?>
          <h2><?php echo $data['h2_1']; ?></h2>
          <p><?php echo $data['description']; ?></p>
          
          <!-- Add Post Form -->
          <form action="<?php echo URLROOT."/posts/edit/".$data['edit_post']->post_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="post_title">Post Title</label>
              <input type="text" name="post_title" class="form-control form-control-lg 
              <?php echo (!empty($data['post_title_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['post_title']; ?>">
              <span class="invalid-feedback"><?php echo $data['post_title_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="">Post Category</label>
              <select name="post_category_id" class="form-control form-control-lg">
                <?php foreach ($data['categories'] as $category) : ?>
                  <option <?php echo ($category->cat_id === $data['post_category_id']) ? "selected='selected'" : '' ?> value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_title; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="post_tags">Post Tags</label>
              <input type="text" name="post_tags" class="form-control form-control-lg 
              <?php echo (!empty($data['post_tags_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['post_tags']; ?>">
              <span class="invalid-feedback"><?php echo $data['post_tags_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="post_image">Post Image</label>
              <br>
              <img id="img-upload-preview" class="img-responsive" src="<?php echo URLROOT.'/img/posts/thumb_'.$data['edit_post']->post_image; ?>" alt="<?php echo $data['post_image']; ?>">
              <br><br>
              <div class="input-group">
                <div class="custom-file">
                  <input id="post_image" class="custom-file-input" type="file" name="post_image" class="form-control form-control-lg" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="post_image">Choose file</label>
                </div>
              </div>
              <span class="text-danger small"><?php echo $data['post_image_err']; ?></span>
            </div>
            <div class="form-group">
              <label for="post_content">Post Content</label>
              <textarea rows="11" name="post_content" class="col-md-12 block<?php echo (!empty($data['post_content_err'])) ? 'is-invalid' : ''; ?>" ><?php echo $data['post_content']; ?></textarea>
              <br>
              <span class="text-danger small pt-2"><?php echo $data['post_content_err']; ?></span>
            </div>
            <div class="row">
              <div class="col-md-3">
                <input type="submit" value="Submit" class="btn text-light btn-success btn-block">
              </div>
            </div>
          </form>
          
        </div>
      </div>

      <!-- Latest Posts Column -->
      <div class="col-md-4">
        <div class="card md-4">
          <div class="card-header"><?php echo $data['h2_2']; ?></div>
          <!--Card content-->
          <?php if (empty($data['posts'])) : ?>
            <p class="pl-4 pt-4">You have no posts yet.</p>
          <?php else : ?>
            <!--Card content-->
            <div class="card-body">
              <ul class="list-unstyled">
                <?php foreach ($data['posts_newest'] as $post) : ?>
                  <li class="message-preview">
                  <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->post_id; ?>" class="text-dark">
                    <div class="media post-card-side">
                      <span class="pull-left mr-3 post-card-side-img">
                        <img class="media-object" style="width: 80px" src="<?php echo URLROOT . "/img/posts/thumb_" .  $post->post_image; ?>" alt="<?php echo $post->post_image; ?>">
                      </span>
                      <div class="media-body post-card-side-body">
                        <h5 class="media-heading">
                          <strong><?php echo $post->post_title; ?></strong>
                        </h5>
                        <p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo $post->post_date; ?></p>
                        <p><?php echo substrwords($post->post_content, 100, $end='...'); ?></p>
                      </div>
                    </div>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="col-md-12 mt-2 pl-0 pr-0">
              <a href="<?php echo URLROOT."/users/posts/".$_SESSION['user_id'] ?>" class="btn btn-orange btn-block text-light">All Your Posts</a>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- Input Control JS-->
<script src="<?php echo URLROOT; ?>/js/upload_input.js"></script>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>