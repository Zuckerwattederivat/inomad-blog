<!-- Header
------------------------------------->
<?php require APPROOT . '/views/includes/header.php'; ?>

<!-- Main Section
------------------------------------->
<section class="container sec-main without-hero mt-5">

  <!-- Articles -->
  <div class="article-list">
    <div class="container">
      <div class="intro">
        <h2 class="text-center"><?php echo $data['h2']; ?></h2>
      </div>
      <div class="row articles-2">
        <p class="text-danger col-md-8"><?php echo $data['no_posts_err']; ?></p>
        <!-- Blog Entries Column -->
        <div class="col-md-8">
          <?php foreach ($data['posts_paginated'] as $post) : ?>
            <!-- Blog Post -->
            <div class="card mb-4">
              <img class="card-img-top" src="<?php echo URLROOT . "/img/posts/" . $post->post_image; ?>" alt="<?php echo $post->post_image; ?>">
              <div class="card-body">
                <h3 class="name"><a class="text-dark" href="<?php echo URLROOT."/posts/show/".$post->post_id; ?>"><?php echo $post->post_title; ?></a></h3>
                <p class="lead">
                  by <a class="text-dark" href="<?php echo URLROOT."/users/posts/".$post->post_user_id; ?>"><?php echo $post->user_alias; ?></a>
                </p>
                <p>
                  <span><i class="fa fa-calendar-times-o" aria-hidden="true"></i></span>
                  <?php echo $post->post_date; ?>
                </p>
                <p class="description"><?php echo substrwords($post->post_content, 500, $end='...'); ?></p>
                <a class="btn text-light btn-orange" href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->post_id; ?>">Read More</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      <!-- Sidebar Widgets -->
      <?php require APPROOT . "/views/includes/sidebar.php"?>

    </div>
  </div>

  <!-- Pager -->
  <?php if (empty($data['no_posts_err']) && paginationCeil($data['post_count'], 10) > 1) : ?>
    <ul class="pager d-flex ml-3">
      <li class="previous mr-1">
        <?php if ($data['current_page'] !== 1) : ?>
          <a class="btn btn-orange text-white btn-block" href="<?php echo ($data['current_page']-1 !== 1) ? URLROOT."/posts/category_page/".$data['cat_id']."/".($data['current_page'] - 1) : URLROOT."/posts/category/".$data['cat_id']; ?>">&larr; Newer</a>
        <?php endif; ?>
      </li>
      <?php for ($i = 1; $i <= paginationCeil($data['post_count'], 10); $i++) : ?>
      <li class="page mr-1">
        <a class="btn text-white btn-block <?php echo ($data['current_page'] == $i) ? "btn-secondary" : "btn-orange"; ?>" href="<?php echo ($i === 1) ? URLROOT."/posts/category/".$data['cat_id'] : URLROOT."/posts/category_page/".$data['cat_id']."/".$i; ?>"><?php echo $i; ?></a>
      </li>
      <?php endfor; ?>
      <?php if ($data['current_page'] != paginationCeil($data['post_count'], 10)) : ?>
      <li class="next">
        <a class="btn btn-orange text-white btn-block" href="<?php echo URLROOT."/posts/category_page/".$data['cat_id']."/".($data['current_page'] + 1); ?>">Older &rarr;</a>
      </li>
      <?php endif; ?>
    </ul>
  <?php endif; ?>
</section>

<!-- Footer
------------------------------------->
<?php require APPROOT . '/views/includes/footer_without_hero.php'; ?>