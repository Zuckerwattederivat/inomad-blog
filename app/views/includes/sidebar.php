<div class="col-md-4 mb-4">
  <!-- Categories Widget -->
  <div class="card">
    <h5 class="card-header">Categories</h5>
    <div class="card-body min-height-400">
      <div class="row">
        <div class="col-lg-12">
          <ul class="list-unstyled mb-0">
            <?php foreach ($data['categories'] as $category) : ?>
                <li><a class='text-dark' href='<?php echo URLROOT.'/posts/category/'.$category->cat_id; ?>'><?php echo $category->cat_title ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>