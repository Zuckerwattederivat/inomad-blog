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
          <?php if (!empty($data['posts'])) : foreach ($data['posts_paginated'] as $post) : ?>
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
          <?php endforeach; endif; ?>
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
          <form action="<?php echo ($data['current_page']-1 !== 1) ? URLROOT."/posts/search/".($data['current_page'] - 1) : URLROOT."/posts/search/"?>" method="post">
            <input type="hidden" name="search" type="text" value="<?php echo $data['search']; ?>">
            <button type="submit" class="btn btn-orange text-white btn-block">&larr; Newer</button>
          </form>
        <?php endif; ?>
      </li>
      <?php for ($i = 1; $i <= paginationCeil($data['post_count'], 10); $i++) : ?>
      <li class="page mr-1">
        <form action="<?php echo ($i === 1) ? URLROOT."/posts/search/" : URLROOT."/posts/search/".$i; ?>" method="post">
          <input type="hidden" name="search" type="text" value="<?php echo $data['search']; ?>">
          <button type="submit" class="btn text-white btn-block <?php echo ($data['current_page'] == $i) ? "btn-secondary" : "btn-orange"; ?>"><?php echo $i; ?></button>
        </form>
      </li>
      <?php endfor; ?>
      <?php if ($data['current_page'] != paginationCeil($data['post_count'], 10)) : ?>
      <li class="next">
        <form action="<?php echo URLROOT."/posts/search/".($data['current_page'] + 1); ?>" method="post">
          <input type="hidden" name="search" type="text" value="<?php echo $data['search']; ?>">
          <button  type="submit" class="btn btn-orange text-white btn-block">Older &rarr;</button>
        </form>
      </li>
      <?php endif; ?>
    </ul>
  <?php endif; ?>
</section>

<!-- Footer
------------------------------------->
<?php require APPROOT . '/views/includes/footer_without_hero.php'; ?>