<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a href="<?php echo URLROOT; ?>" class="navbar-brand"><b><?php echo SITENAME; ?></b> <?php echo SITETITLE; ?></a>  		
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- collection of nav links -->
  <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">

    <!-- menu links -->
    <div class="navbar-nav">
      <a href="<?php echo URLROOT; ?>" class="nav-item nav-link">Home</a>
      <div class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle">Categories</a>
        <div class="dropdown-menu categories-dropdown">			
          <?php foreach ($data['categories'] as $category) : ?>
            <a href='<?php echo URLROOT.'/posts/category/'.$category->cat_id; ?>' class='dropdown-item'><?php echo $category->cat_title; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <a href="javascript: void(0);" onclick="javascript:scrollDown('footer');" class="nav-item nav-link mr-4">Contact</a>
    </div>
    <br>
    <!-- search bar -->
    <form class="navbar-form form-inline" action="<?php echo URLROOT; ?>/posts/search" method="post">
      <div class="input-group search-box">
        <input type="text" name="search" id="search" class="form-control" placeholder="Search here...">
        <div class="input-group-append">
          <span class="input-group-text">
            <button class="btn-trans-justified" name="submit" type="submit"><i class="material-icons">&#xE8B6;</i></button>
          </span>
        </div>
      </div>
    </form>
    <br>
    <br>
    <?php if (isset($_SESSION['user_id'])) : ?>
      <!-- user links -->
      <div class="navbar-nav ml-auto">
        <!-- profile links-->
        <div class="nav-item">
          <a href="#" data-toggle="dropdown" class="nav-item dropdown-toggle btn btn-primary text-light-grey"><i class="fa fa-user"></i> <?php echo $_SESSION['user_alias']; ?></a>
          <div class="dropdown-menu dropdown-menu-right user-dropdown mr-3">
            <a href="<?php echo URLROOT; ?>/posts/add" class="dropdown-item"><i class="fa fa-pencil"></i> Add Post</a>
            <a href="<?php echo URLROOT."/users/posts/".$_SESSION['user_id']; ?>" class="dropdown-item"><i class="fa fa-file"></i> All Your Posts</a>
            <a href="<?php echo URLROOT; ?>/users/profile" class="dropdown-item"><i class="fa fa-user"></i> Profile</a>
            <hr class="mt-1 mb-2">
            <?php if ($_SESSION['user_role'] === "admin") : ?>
              <a href="<?php echo URLROOT; ?>/admin" class="dropdown-item"><i class="fa fa-cog"></i> Admin Panel</a>
            <?php endif; ?>
            <a href="<?php echo URLROOT; ?>/users/logout" class="dropdown-item text-danger"><i class="fa fa-power-off"></i> Logout</a>
          </div>
        </div>
      </div>
    <?php else : ?>
      <!-- user links-->
      <div class="navbar-nav ml-auto">
        <div class="nav-item">
          <!-- login -->
          <a href="<?php echo URLROOT; ?>/users/login" class="nav-link mr-4">Login</a>
        </div>
        <div class="nav-item">
          <!-- sign up -->
          <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-primary text-light-grey sign-up-btn">Register</a>
        </div>
      </div>
    <?php endif; ?>
    <br>
  </div>
</nav>