<!-- post edit form -->
<div class="container fluid">
  <div class="row">
    <div class="col-md-8 mb-4">
      <?php flash('admin_alert'); ?>
      <!-- Add Post Form -->
      <form action="<?php echo URLROOT."/admin/edit_post/".$data['edit_post']->post_id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="post_title">Post Title</label>
          <input type="text" name="post_title" class="form-control form-control-lg 
          <?php echo (!empty($data['post_title_err'])) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $data['post_title']; ?>">
        <span class="invalid-feedback text-danger small"><?php echo $data['post_title_err']; ?></span>
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
          <span class="invalid-feedback text-danger small"><?php echo $data['post_tags_err']; ?></span>
          <br>
        </div>
        <div class="form-group">
          <label for="post_image">Post Image</label>
          <img class="img-responsive" src="<?php echo URLROOT.'/img/posts/thumb_'.$data['edit_post']->post_image; ?>" alt="<?php echo $data['post_image']; ?>">
          <br>
          <input id="post_image" class="bg-trans mb-1" type="file" name="post_image" class="form-control form-control-lg">
          <br>
          <span class="text-danger small"><?php echo $data['post_image_err']; ?></span>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="post_content">Post Content</label>
              <br>
              <textarea rows="11" name="post_content" class="btn-block form-control <?php echo (!empty($data['post_content_err'])) ? 'is-invalid' : ''; ?>" ><?php echo $data['post_content']; ?></textarea>
              <span class="text-danger small pt-2"><?php echo $data['post_content_err']; ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <input type="submit" value="Submit" class="btn btn-block text-light btn-success">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="reset" value="Reset" class="btn btn-block text-light btn-danger">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /. post edit form -->