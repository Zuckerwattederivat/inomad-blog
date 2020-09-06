<!--------------------------------------
  Categories CMS iNomad Travel Blog Admin
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

    <!-- content -->
    <div class="row">

      <!-- Left Panel -->
      <div class="col-md-6">
        <!-- alert -->
        <?php flash('admin_alert'); ?>

        <!-- Add Category Form -->
        <form action="<?php echo URLROOT . "/admin/add_category"; ?>" method="post">
            <div class="form-group">
              <label for="cat_title">Add Category</label>
              <input type="text" name="cat_title" class="form-control form-control-lg 
              <?php echo (!empty($data['cat_title_err'])) ? 'is-invalid' : ''; ?>">
              <span class="invalid-feedback text-danger small"><?php echo $data['cat_title_err']; ?></span>
            </div>
            <div class="row">
              <div class="form-group col-md-3 p-0">
                <input class="btn btn-success btn-block" type="submit" name="submit" value="Add">
              </div>
            </div>
          </form>

        <!-- update category form -->
        <?php if ($data['action'] === 'edit') : ?>
          <form action="<?php echo URLROOT . "/admin/update_category/".$data['cat_id']; ?>" method="post">
            <div class="form-group">
              <label for="cat_title_edit">Update Category</label>
              <input type="text" name="cat_title_edit" class="form-control form-control-lg 
              <?php echo (!empty($data['cat_title_edit_err'])) ? 'is-invalid' : ''; ?>" 
              value="<?php echo $data['cat_title_edit']; ?>">
              <span class="invalid-feedback text-danger small"><?php echo $data['cat_title_edit_err']; ?></span>
            </div>
            <div class="row">
              <div class="form-group col-md-3 p-0">
                <input class="btn btn-success btn-block" type="submit" name="submit" value="Update">
              </div>
            </div>
          </form>
        <?php endif; ?>
      </div>
      <!-- left panel -->

      <!-- right panel -->
      <div class="col-md-6 table-responsive p-3">
        <!-- table -->
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Title</th>
              <th class="text-center text-info">Edit</th>
              <th class="text-center text-danger">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['categories'] as $category) : ?>
              <tr>
                <td><?php echo $category->cat_id; ?></td>
                <td><?php echo $category->cat_title; ?></td>
                <td class="text-center"><a class=" btn btn-info" href="<?php echo URLROOT . "/admin/categories/edit/".$category->cat_id; ?>"><i class="fa fa-edit"></i></a></td>
                <td class="text-center"><a href="#confirm-delete" class="btn btn-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/delete_category/'.$category->cat_id; ?>');"><i class="fa fa-trash"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- right panel -->

    </div>
    <!-- row -->

  </div>
  <!-- /.container-fluid -->
</div>

<!-- Delete Confirm Modal -->
<div id="confirm-delete" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box">
          <i class="material-icons">&#xE5CD;</i>
        </div>				
        <h4 class="modal-title">Are you sure?</h4>	
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/categories'; ?>');">&times;</button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete this category? All associated posts loose their reference. This process can not be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/categories'; ?>');">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="window.location.reload();">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/admin_footer.php"?>