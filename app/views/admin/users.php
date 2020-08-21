<!--------------------------------------
  Users CMS iNomad Travel Blog Admin
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

  <div class="container-fluid table-responsive">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          <b><?php echo $data['h1'] ?>
          <small><?php echo $data['description']; ?></small>
        </h1>
      </div>
    </div>
    <!-- /.page heading -->

    <!--  flash message -->
    <div class="col-md-12 text-center">
      <?php flash('admin_alert'); ?>
    </div>

    <!-- show includes file -->
    <?php switch ($data['action']) {
      // show edit user
      case 'add':
        include_once APPROOT . "/views/includes/admin_add_user.php";
        break;
      // show all users
      default:
        include_once APPROOT . "/views/includes/admin_show_users.php"; 
        break;
    } ?>

  </div>
  <!-- /.container-fluid -->
  <br>
</div>
<!-- /.page wrapper -->

<!-- Delete Confirm Modal -->
<div id="confirm-delete" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box">
          <i class="material-icons">&#xE5CD;</i>
        </div>				
        <h4 class="modal-title">Are you sure?</h4>	
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/users'; ?>');">&times;</button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete this user and all his posts? This process can not be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/users'; ?>');">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="window.location.reload();">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- /.confirm modal -->

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/admin_footer.php"?>

