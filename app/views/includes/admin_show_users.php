<!-- users table -->
<form action="<?php echo URLROOT; ?>/admin/edit_user"  method='post' enctype='multipart/form-data'>
  <table id="users-table" class="table table-bordered table-hover">
    <thead>
      <tr>
        <th class="th">ID</th>
        <th class="th">Privileges</th>
        <th class="th">Username</th>
        <th class="th">Name</th>
        <th class="th">Email</th>
        <th class="th">Password</th>
        <th class="th">Bio</th>
        <th class="th">Image</th>
        <th class="th">Created</th>
        <th class="th text-center">Edit</th>
        <th class="th text-center">Delete</th>
      </tr>  
    </thead>
    <tbody>
      <?php foreach ($data['users'] as $user) : ?>
        <tr>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <input type="text" name="user_id" class="edit-input input-<?php echo $user->user_id; ?> form-control hidden"
                value="<?php echo $user->user_id; ?>">
                <?php echo $user->user_id; ?>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <select type="text" name="user_role" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden">
                  <option value="<?php echo $user->user_role; ?>"><?php echo $user->user_role; ?></option>
                  <option value="<?php echo ($user->user_role === 'admin') ? 'user' : 'admin' ?>"><?php echo ($user->user_role === 'admin') ? 'user' : 'admin' ?></option>
                </select>
                <div class="content-field content-<?php echo $user->user_id; ?> user-col-cont">
                  <?php echo $user->user_role; ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <input type="text" name="username" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden"
                value="<?php echo $user->user_alias; ?>">
                <div class="content-field content-<?php echo $user->user_id; ?> user-col-cont">
                  <?php echo $user->user_alias; ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <input type="text" name="name" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden" 
                value="<?php echo $user->user_real_name; ?>">
                <div class="content-field content-<?php echo $user->user_id; ?> user-col-cont">
                  <?php echo $user->user_real_name; ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <input type="text" name="email" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden" 
                value="<?php echo $user->user_email; ?>">
                <div class="content-field content-<?php echo $user->user_id; ?> user-col-cont">
                  <?php echo $user->user_email; ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <label for="password" class="edit-label label-<?php echo $user->user_id; ?> text-dark small hidden">New Password</label>
                <input type="password" name="password" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden" 
                value="<?php echo $data['password']; ?>">
                <br>
                <label for="password_confirm" class="edit-label label-<?php echo $user->user_id; ?> text-dark small hidden">Confirm Password</label>
                <input type="password" name="password_confirm" class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden" 
                value="<?php echo $data['password_confirm']; ?>">
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <textarea rows="4" name="user_bio" class="edit-input input-<?php echo $user->user_id; ?> form-control hidden"><?php echo $user->user_bio; ?></textarea>
                <div class="content-field content-<?php echo $user->user_id; ?> user-col-cont">
                  <?php echo $user->user_bio; ?>
                </div>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <img src='<?php echo URLROOT . "/img/users/" . $user->user_image; ?>' class='img-thumb' style='width: 100px' alt="<?php echo $user->user_image; ?>">
                <br><br>
                <input class="edit-input input-<?php echo $user->user_id; ?> input-sm form-control hidden image-input" type="file" name="user_image">
                <br>
              </div>
            </div>
          </td>
          <td>
            <div class="row d-flex">
              <div class="col-md-12">
                <?php echo $user->user_created_at; ?>
              </div>
            </div>
          </td>
          <td class='text-center btn-edit-cont'>
            <div class="row d-flex">
              <div class="col-md-12">
                <button type="reset" data-user_id="<?php echo $user->user_id; ?>" class="btn-edit-user btn-edit-<?php echo $user->user_id; ?> btn btn-info"><i class="fa fa-edit"></i></button>
                <button class='btn-submit-edit btn btn-success btn-block btn-submit-edit-<?php echo $user->user_id; ?> hidden' type='submit'><i class='fa fa-send'></i></button>
                <button type='reset' data-user_id="<?php echo $user->user_id; ?>" style='margin-top: 10px' class='btn-close-edit btn btn-danger btn-block btn-close-edit-<?php echo $user->user_id; ?> hidden'><i class='fa fa-close'></i></button>
              </div>
            </div>
          </td>
          <td class='text-center btn-edit-cont'>
            <div class="row d-flex">
              <div class="col-md-12">
                <a href="#confirm-delete" class="btn btn-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/delete_user/'.$user->user_id; ?>');"><i class="fa fa-trash"></i></a>
              </div>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</table>

<!-- Users Table Script -->
<script src="<?php echo URLROOT; ?>/js_cms/users_table.js" type="text/javascript"></script>