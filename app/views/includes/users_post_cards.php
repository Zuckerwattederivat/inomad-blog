<?php foreach ($data['posts'] as $post) : ?>
  <div class="col-lg-3 item mb-4">
    <div class="card mb-1 h-100">
      <div class="btn-div d-flex justify-content-end">
        <a href="#confirm-delete" class="btn btn-delete text-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/users/posts/'.$post->user_id.'/'.$post->post_id; ?>');">
          <i class="fa fa-trash"></i>
        </a>
        <a href="<?php echo URLROOT."/posts/edit/".$post->post_id; ?>" class="btn btn-edit text-info"><i class="fa fa-edit"></i></a>
      </div>
      <img class="card-img-top" src="<?php echo URLROOT . "/img/posts/".$post->post_image; ?>" alt="Card image cap">
      <div class="card-body d-flex justify-content-start flex-column">
        <h4 class='name'><a class='text-dark' href='<?php echo URLROOT."/posts/show/".$post->post_id; ?>'><?php echo $post->post_title; ?></a></h4>
        <p class="lead">
          by <a class="text-dark" href="<?php echo URLROOT."/users/posts/".$post->post_user_id; ?>"><?php echo $post->user_alias; ?></a>
        </p>
        <p>
          <span><i class="fa fa-calendar-times-o" aria-hidden="true"></i></span>
          <?php echo $post->post_date; ?>
        </p>
      </div>
      <a class="btn text-light btn-orange" href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->post_id; ?>">Read More</a>
    </div>
  </div>
<?php endforeach; ?>





