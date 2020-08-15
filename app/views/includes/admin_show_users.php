<!-- users table -->
<div class="custom-table">
  <div class="th-group">
    <div class="th">ID</div>
    <div class="th">Privileges</div>
    <div class="th">Username</div>
    <div class="th">Name</div>
    <div class="th">Email</div>
    <div class="th">Password</div>
    <div class="th">Bio</div>
    <div class="th">Image</div>
    <div class="th">Date</div>
    <div class="th text-center text-info">Edit</div>
    <div class="th text-center text-danger">Delete</div>
  </div>
  <div class="tr-group">
    <?php foreach ($data['users'] as $user) : ?>
      <form class="tr" id="user-data-<?php echo $user->user_id; ?>" action="<?php echo URLROOT."/admin/edit_user/".$user->user_id; ?>"  method='post' enctype='multipart/form-data'>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <?php echo $user->user_id; ?>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <select type="text" name="user_role" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden">
                <option value="<?php echo $user->user_role; ?>"><?php echo $user->user_role; ?></option>
                <option value="<?php echo ($user->user_role === 'admin') ? 'user' : 'admin' ?>"><?php echo ($user->user_role === 'admin') ? 'user' : 'admin' ?></option>
              </select>
              <span class="invalid-feedback text-danger small"><?php echo $data['user_role_err']; ?></span>
              <div class="content-<?php echo $user->user_id; ?> user-col-cont">
                <?php echo $user->user_role; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <input type="text" name="username" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden"
              value="<?php echo $user->user_alias; ?>">
              <div class="content-<?php echo $user->user_id; ?> user-col-cont">
                <?php echo $user->user_alias; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <input type="text" name="name" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden" 
              value="<?php echo $user->user_real_name; ?>">
              <div class="content-<?php echo $user->user_id; ?> user-col-cont">
                <?php echo $user->user_real_name; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <input type="text" name="email" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden" 
              value="<?php echo $user->user_email; ?>">
              <div class="content-<?php echo $user->user_id; ?> user-col-cont">
                <?php echo $user->user_email; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <label for="password" class="label-<?php echo $user->user_id; ?> text-dark small hidden">New Password</label>
              <input type="password" name="password" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden" 
              value="<?php echo $data['password']; ?>">
              <br>
              <label for="password_confirm" class="label-<?php echo $user->user_id; ?> text-dark small hidden">Confirm Password</label>
              <input type="password" name="password_confirm" class="input-<?php echo $user->user_id; ?> form-control form-control-lg hidden" 
              value="<?php echo $data['password_confirm']; ?>">
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <textarea rows="4" name="user_bio" class="input-<?php echo $user->user_id; ?> hidden"><?php echo $user->user_bio; ?></textarea>
              <div class="content-<?php echo $user->user_id; ?> user-col-cont">
                <?php echo $user->user_bio; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <img src='<?php echo URLROOT . "/img/users/" . $user->user_image; ?>' class='img-thumb' style='width: 100px' alt="<?php echo $user->user_image; ?>">
              <br><br>
              <input class="input-<?php echo $user->user_id; ?> hidden" type="file" name="user_image" class="form-control form-control-lg">
              <span class="invalid-feedback text-danger small"><?php echo $data['user_image_err']; ?></span>
              <br>
            </div>
          </div>
        </div>
        <div class="td">
          <div class="row d-flex">
            <div class="col-md-12">
              <?php echo $user->user_created_at; ?>
            </div>
          </div>
        </div>
        <div class='td text-center btn-edit-cont'>
          <div class="row d-flex">
            <div class="col-md-12">
              <button type="reset" data-user_id="<?php echo $user->user_id; ?>" class="btn-edit-user btn-edit-<?php echo $user->user_id; ?> btn btn-info"><i class="fa fa-edit"></i></button>
            </div>
          </div>
        </div>
        <div class='td text-center btn-edit-cont'>
          <div class="row d-flex">
            <div class="col-md-12">
              <a href="#confirm-delete" class="btn btn-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="window.history.pushState({}, null, '<?php echo URLROOT.'/admin/delete_user/'.$user->user_id; ?>');"><i class="fa fa-trash"></i></a>
            </div>
          </div>
        </div>
      </form>
    <?php endforeach; ?>
  </div>
</div>

<script>
  // Show Edit Fields
  (function () {

    // button list
    let btnEditList = document.querySelectorAll('.btn-edit-user');
    
    // loop
    btnEditList.forEach(e => {
      // click event listener
      e.addEventListener('click', () => {

        // set user id
        let userID = e.dataset.user_id;
        
        // get user data row
        let userRow = document.querySelector(`#user-data-${userID}`);
        let userData = $(`#user-data-${userID}`).children();

        // remove edit button
        e.classList.toggle('hidden');

        // edit field
        let editField = userData[userData.length -2]
        
        // add submit button
        editField.insertAdjacentHTML('beforeend', `<button data-btn-edit-id='${userID}' class='btn btn-success btn-block btn-submit-edit' type='submit'><i class='fa fa-send'><i></button>`);
        // add abort button
        editField.insertAdjacentHTML('beforeend',  `<button type='reset' data-btn-close-id='${userID}' style='margin-top: 10px' class='btn btn-danger btn-block users-btn-close'><i class='fa fa-close'><i></button>`);
        
        // get buttons
        let btnList = [];
        btnList.push(e);
        editField.childNodes.forEach(e => {
          btnList.push(e);
        });

        // get input fields
        let inputFields = document.querySelectorAll(`.input-${userID}`);
        // get text divs
        let contentFields = document.querySelectorAll(`.content-${userID}`);
        // get labels
        let labels = document.querySelectorAll(`.label-${userID}`);
        
        // toggle content fields
        contentFields.forEach(e => {
          e.classList.toggle('hidden');
        });
        // toggle labels
        labels.forEach(e => {
          e.classList.toggle('hidden');
        });
        // toggle input fields
        inputFields.forEach(e => {
          e.classList.toggle('hidden');
        });
        
        // eventlistener close btn
        $(`*[data-btn-close-id=${userID}]`)[0].addEventListener('click', () => {
          // toggle content fields
          contentFields.forEach(e => {
            e.classList.toggle('hidden');
          });
          // toggle labels
          labels.forEach(e => {
            e.classList.toggle('hidden');
          });
          // toggle input fields
          inputFields.forEach(e => {
            e.classList.toggle('hidden');
          });
          // reset buttons
          btnList[0].classList.toggle('hidden');
          btnList[btnList.length-1].remove();
          btnList[btnList.length-2].remove();
        });
      });
    });
    
  }) ();

</script>