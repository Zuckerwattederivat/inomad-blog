<!-- Header
------------------------------------->
<?php require APPROOT . '/views/includes/header.php'; ?>

<!-- Hero Section
------------------------------------->
<?php require APPROOT . '/views/includes/hero.php'; ?>

<!-- Main Section
------------------------------------->
<section class="container sec-main">

  <!-- Featured Articles -->
  <?php require APPROOT . '/views/includes/feat_articles.php'?>

  <!-- Articles -->
  <div id="article-list" class="article-list">
    <div class="container">
      <div class="intro">
        <h2 class="text-center"><?php echo $data['h2']; ?></h2>
      </div>
      <div class="row articles-2">

        <!-- Blog Entries Column -->
        <div id="blog-entries-col" class="col-md-8">
          <?php foreach ($data['posts_paginated'] as $post) : ?>
            <!-- Blog Post -->
            <div class="card mb-4 blog-posts">
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

    <!-- Pager -->
    <ul class="pager d-flex">
      <li class="previous mr-1">
        <?php if ($data['current_page'] !== 1) : ?>
          <a class="btn btn-orange text-white btn-block" href="<?php echo ($data['current_page']-1 !== 1) ? URLROOT."/pages/page/".($data['current_page'] - 1) : URLROOT; ?>">&larr; Newer</a>
        <?php endif; ?>
      </li>
      <?php for ($i = 1; $i <= ceil($data['post_count']/10); $i++) : ?>
      <li class="page mr-1">
        <a class="btn text-white btn-block <?php echo ($data['current_page'] == $i) ? "btn-secondary" : "btn-orange"; ?>" href="<?php echo ($i === 1) ? URLROOT : URLROOT."/pages/page/".$i; ?>"><?php echo $i; ?></a>
      </li>
      <?php endfor; ?>
      <?php if ($data['current_page'] != ceil($data['post_count']/10)) : ?>
      <li class="next">
        <a class="btn btn-orange text-white btn-block" href="<?php echo URLROOT."/pages/page/".($data['current_page'] + 1); ?>">Older &rarr;</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>

</section>

<!-- Footer
------------------------------------->
<?php require APPROOT . '/views/includes/footer.php'; ?>