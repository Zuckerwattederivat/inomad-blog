  <div class="article-list">
    <div class="container">
      <div class="intro">
        <h2 class="text-center">Featured Articles</h2>
      </div>
      <div class="row articles">
        <?php foreach ($data['posts_three_rand'] as $post) : ?>
          <!-- Featured Post -->
          <div class="col-md-4 item">
            <div class="card mb-4 h-100">
              <img class="card-img-top" src="<?php echo URLROOT . "/img/posts/" . $post->post_image; ?>" alt="Card image cap">
              <div class="card-body">
                <h3 class='name'><a class='text-dark' href='<?php echo URLROOT."/posts/show/".$post->post_id; ?>'><?php echo $post->post_title; ?></a></h3>
                <p class="lead">
                  by <a class="text-dark" href="<?php echo URLROOT."/users/posts/".$post->post_user_id; ?>"><?php echo $post->user_alias; ?></a>
                </p>
                <p>
                  <span><i class="fa fa-calendar-times-o" aria-hidden="true"></i></span>
                  <?php echo $post->post_date; ?>
                </p>
                <p class="description"><?php echo substrwords($post->post_content, 200, $end='...'); ?></p>
              </div>
              <a class="btn text-light btn-orange" href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->post_id; ?>">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <hr>