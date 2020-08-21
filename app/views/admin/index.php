<!--------------------------------------
  Home CMS iNomad Travel Blog Admin
  Brian Boehm 2020 
-------------------------------------->

<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/admin_header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/admin_nav.php"?>

<!-- Main Section
------------------------------------->
<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          <b><?php echo $data['h1'] ?>
          <small><?php echo $data['description']; ?></small>
        </h1>
      </div>
    </div>
    <!-- /.row -->

    <!-- widgets -->
    <div class="row">

      <!-- posts -->
      <div class="slide col-lg-3 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-file-text fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['post_count']; ?></div>
                <div>Posts</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/posts">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- users -->
      <div class="slide col-lg-3 col-md-6">
        <div class="panel panel-pink">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-users fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['user_count']; ?></div>
                <div> Users</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/users">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- admins -->
      <div class="slide col-lg-3 col-md-6">
        <div class="panel panel-violet">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['admin_count']; ?></div>
                <div> Admins</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/users">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- categories -->
      <div class="slide col-lg-3 col-md-6">
        <div class="panel panel-dark-blue">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['cat_count']; ?></div>
                <div>Categories</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/categories">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

    </div>
    <!-- /.widgets -->

    <!-- charts -->
    <div class="row">
      <!-- chart container -->
      <div id="chartdiv" style="width: auto; height: 500px; padding: 20px;"></div>
    </div>
    <!-- /. charts -->

  </div>
  <!-- /.container-fluid -->
</div>

<script>
  
</script>

<!-- Dashboard JS -->
<?php include APPROOT . "/views/includes/admin_dashboard_script.php"?>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/admin_footer.php"?>