<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero">
  <div class="container">

    <!--Section: Post-->
    <section class="mt-4">

      <!--Grid row-->
      <div class="row">

        <!--Grid column-->
        <div class="col-md-8 mb-4">

          <!--Featured Image-->
          <div class="card mb-4">
            <img src="<?php echo URLROOT . "/img/posts/" . $data['post']->post_image; ?>" class="img-fluid" alt="<?php echo $data->post_image; ?>">
          </div>
          <!--/.Featured Image-->

          <!--Card-->
          <div class="card mb-4">

            <!--Card content-->
            <div class="card-body">
              <p class="h2 my-4"><?php echo $data['post']->post_title; ?></p>
              <p class="my-4">
                <span><i class="fa fa-calendar-times-o" aria-hidden="true"></i></span>
                <?php echo $data['post']->post_date; ?>
              </p>
              <?php foreach ($data['post_paragraphs'] as $paragraph) : ?>
                <p><?php echo $paragraph; ?></p>
              <?php endforeach; ?>
            </div>
          </div>
          <!--/.Card-->

          <!--Card-->
          <div class="card mb-4">
            <div class="card-header font-weight-bold">
              <span>About the author</span>
            </div>
            <!--Card content-->
            <div class="card-body">
              <div class="media d-block d-md-flex mt-3">
                <img class="d-flex mb-3 mx-auto z-depth-1" src="<?php echo URLROOT . "/img/users/" . $data['post']->user_image; ?>" alt="<?php echo URLROOT . "/img/users/" . $data['post']->user_image; ?>"
                  style="width: 100px;">
                <div class="media-body text-center text-md-left ml-md-3 ml-0">
                  <h5 class="mt-0 font-weight-bold"><a class="text-dark" href="<?php echo URLROOT."/users/posts/".$data['post']->post_user_id; ?>"><?php echo $data['post']->user_alias; ?></a></h5>
                  <?php echo $data['post']->user_bio; ?>
                </div>
              </div>
            </div>
          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!--Card-->
          <div class="card mb-4">
            <div class="card-header">Related articles</div>
            <!--Card content-->
            <div class="card-body">
              <ul class="list-unstyled">
                <?php foreach ($data['related_posts'] as $relatedPost) :  ?>
                  <li class="message-preview">
                  <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $relatedPost->post_id; ?>" class="text-dark">
                    <div class="media">
                      <span class="pull-left mr-3">
                        <img class="media-object" style="max-width: 80px" src="<?php echo URLROOT . "/img/posts/thumb_" .  $relatedPost->post_image; ?>" alt="<?php echo $post->post_image; ?>">
                      </span>
                      <div class="media-body overflow-hidden">
                        <h5 class="media-heading">
                          <strong><?php echo $relatedPost->post_title; ?></strong>
                        </h5>
                        <p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo $relatedPost->post_date; ?></p>
                        <p><?php echo substrwords($relatedPost->post_content, 100, $end='...'); ?></p>
                      </div>
                    </div>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
            
          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

    </section>
    <!--Section: Post-->

  </div>
</section>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>