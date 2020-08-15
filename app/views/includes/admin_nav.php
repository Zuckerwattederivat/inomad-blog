    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand active" href="<?php echo URLROOT; ?>"><b><?php echo SITENAME. "</b> " . TITLEBACK ?></a>
      </div>

      <!-- Top Menu Items -->
      <ul class="nav navbar-right top-nav">
        <li><a href="<?php echo URLROOT; ?>">Home</a></li>

        <!-- New Posts -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i> New Posts <b class="caret"></b></a>
          <ul class="dropdown-menu message-dropdown">
            <?php foreach ($data['posts_three_new'] as $post) : ?>
              <li class="message-preview">
                <a href="<?php echo URLROOT."/admin/edit_post/".$post->post_id; ?>">
                  <div class="media">
                    <span class="pull-left">
                      <img class="media-object" style="width: 100px" src="<?php echo URLROOT . "/img/posts/thumb_" .  $post->post_image; ?>" alt="<?php echo $post->post_image; ?>">
                    </span>
                    <div class="media-body">
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
            <!-- New Posts Footer -->
            <li class="message-footer">
              <a href="<?php echo URLROOT; ?>/admin/posts">View All Posts</a>
            </li>
          </ul>
        </li>

        <!-- Profile -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['user_alias']; ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo URLROOT; ?>/posts/add" class="dropdown-item"><i class="fa fa-fw fa-pencil"></i> Add Post</a>
            </li>
            <li>
              <a href="<?php echo URLROOT."/users/posts/".$_SESSION['user_id']; ?>" class="dropdown-item"><i class="fa fa-fw fa-file"></i> All Your Posts</a>
            </li>
            <li>
              <a href="<?php echo URLROOT."/users/profile"; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <hr class="hr-custom">
            <li>
              <a class="text-danger-custom" href="<?php echo URLROOT; ?>/users/logout"><i class="fa fa-fw fa-power-off"></i> Logout</a>
            </li>
          </ul>
        </li>
      </ul>

      <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
          <li>
            <a href="<?php echo URLROOT; ?>/admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
          </li>
          </li>
          <li>
            <a href="<?php echo URLROOT; ?>/admin/categories"><i class="fa fa-fw fa-list"></i> Categories</a>
          </li>
          <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#posts-dropdown"><i class="fa fa-fw fa-file"></i>
              Posts <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="posts-dropdown" class="collapse">
              <li>
                <a href="<?php echo URLROOT; ?>/admin/posts">View All Posts</a>
              </li>
              <li>
                <a href="<?php echo URLROOT; ?>/posts/add">Add Posts</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-users"></i>
              Users <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo" class="collapse">
              <li>
                <a href="<?php echo URLROOT; ?>/admin/users">Show Users</a>
              </li>
              <li>
                <a href="<?php echo URLROOT; ?>/admin/add_user">Add User</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="<?php echo URLROOT."/users/profile"; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->

    </nav>