<?php
  /*
  * App Admin Controller Class
  * Loads admin pages
  * Passes data from and to models
  */
  class Admin extends Controller {
    
    public function __construct() {

      // if user is not admin redirect to login and display alert
      if (!isAdmin()) {
        flash('login_alert', 'Please login as admin to access this page.', 'alert alert-danger');
        Header('Location: ' . URLROOT . '/users/login');
      }

      // construct models
      $this->userModel = $this->model('User');
      $this->postModel = $this->model('Post');
      $this->catModel = $this->model('Category');
      $this->imgModel = $this->model('Imaging');

      // get all posts
      $this->posts = $this->postModel->getPosts();
      // get 3 random posts
      $this->postsThreeNew = $this->postModel->getThreeNewPosts();
    }

    // Load admin
    public function index() {

      // get users
      $users = $this->userModel->getUsers();
      // get admins
      $admins = [];
      foreach ($users as $user) {
        if ($user->user_role === 'admin') {
          $admins[] = $user;
        }
      }

      // data array
      $data = [
        'h1' => 'Dashboard Admin Panel',
        'description' => 'Please choose your actions wisely.',
        'posts' => $this->posts,
        'posts_three_new' => $this->postsThreeNew,
        'post_count' => count($this->posts),
        'user_count' => count($users) - count($admins),
        'admin_count' => count($admins),
        'max_count' => max([count($this->posts), count($users), count($admins)]),
        'cat_count' => count($this->catModel->getCats()),
        'chart_text' => ['Posts', 'Users', 'Admins', 'Categories'],
        'chart_content' => [count($this->posts), count($users)-count($admins), count($admins), count($this->catModel->getCats())],
      ];

      // load view and pass data array
      $this->view('admin/index', $data);

    }

    // load categories
    public function categories($action=null, $cat_id=null) {

      // get all categories
      $categories = $this->catModel->getCats();

      // load view normal
      if ($action !== 'edit') {

        // data array
        $data = [
          'h1' => 'Categories',
          'description' => 'Use this panel to edit the sites categories.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'categories' => $categories,
          'category' => '',
          'action' => $action,
          'cat_id' => '',
          'cat_title' => '',
          'cat_title_err' => ''
        ];

        // load view
        $this->view('admin/categories', $data);

        // load view edit
      } elseif ($action === 'edit' && $cat_id !== null) {

        // search selected category
        $category = $this->catModel->searchCats('cat_id', $cat_id);
        // redirect if category is not found
        if (empty($category)) {
          header('Location: ' . URLROOT . "/admin/categories");
        }

        // data array
        $data = [
          'h1' => 'Categories',
          'description' => 'Use this panel to edit the sites categories.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'categories' => $categories,
          'category' => $category,
          'action' => $action,
          'cat_id' => $category->cat_id,
          'cat_title' => '',
          'cat_title_err' => '',
          'cat_title_edit' => $category->cat_title,
          'cat_title_edit_err' => ''
        ];

        // load view
        $this->view('admin/categories', $data);

        // redirect 
      } else {
        header('Location: ' . URLROOT . "/admin/categories");
      }
    }

    // add category
    public function add_category() {

      // if user sent post
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // get all categories
        $categories = $this->catModel->getCats();

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'h1' => 'Categories',
          'description' => 'Use this panel to edit the sites categories.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'categories' =>$categories,
          'action' => '',
          'cat_id' => '',
          'cat_title' => trim($_POST['cat_title']),
          'cat_title_err' => ''
        ];

        // validate cat_title
        if (empty($data['cat_title'])) {
          $data['cat_title_err'] = "Please choose a category title.";
        }

        // if no err
        if (empty($data['cat_title_err'])) {

          // add category to db
          if ($this->catModel->addCat($data)) {

            // invoke session helper flash function
            flash('admin_alert', 'The category has been successfully added.');
            // redirect to admin cats
            header("Location: " . URLROOT . "/admin/categories");

            // display error message
          } else {
            // invoke session helper flash function
            flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
            // redirect to admin cats
            header("Location: " . URLROOT . "/admin/categories");
          }

          // init view
        } else {
          $this->view('admin/categories', $data);
        }

        // redirect
      } else {
        header("Location: " . URLROOT . "/admin/categories");
      }
    }

    // update category
    public function update_category($cat_id=null) {

      // if post request method
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // get all categories
        $categories = $this->catModel->getCats();
        // search selected category
        $category = $this->catModel->searchCats('cat_id', $cat_id);

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'h1' => 'Categories',
          'description' => 'Use this panel to edit the sites categories.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'categories' => $categories,
          'category' => $category,
          'action' => 'edit',
          'cat_title' => '',
          'cat_title_err' => '',
          'cat_id' => $cat_id,
          'cat_title_edit' => trim($_POST['cat_title_edit']),
          'cat_title_edit_err' => ''
        ];

        // validate cat_title
        if (empty($data['cat_title_edit'])) {
          $data['cat_title_edit_err'] = "Please choose a category title.";
        }
        
        // if no err
        if (empty($data['cat_title_edit_err'])) {

          // update category to db
          if ($this->catModel->updateCat($data)) {

            // invoke session helper flash function
            flash('admin_alert', 'The category has been successfully updated.');
            // redirect to admin cats
            header("Location: " . URLROOT . "/admin/categories");

            // display error message
          } else {
            // invoke session helper flash function
            flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
            // redirect to admin cats
            header("Location: " . URLROOT . "/admin/categories");
          }

         // reload view
        } else {
          $this->view('admin/categories', $data);
        }

        // redirect
      } else {
        header("Location: " . URLROOT . "/admin/categories");
      }
    }

    // delete category
    public function delete_category($cat_id=null) {

      // search selected category
      $category = $this->catModel->searchCats('cat_id', $cat_id);

      // if cat exists delete
      if ($cat_id !== null && !empty($category)) {

        // data array
        $data = [
          'h1' => 'Categories',
          'description' => 'Use this panel to edit the sites categories.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'categories' => $categories,
          'category' => $category,
          'action' => $action,
          'cat_id' => $cat_id,
          'cat_title' => $category->cat_title,
          'cat_title_err' => ''
        ];

        // delete category to db
        if ($this->catModel->deleteCat($data)) {
          
          // invoke session helper flash function
          flash('admin_alert', 'The category has been successfully deleted.');
          // redirect to admin cats
          header("Location: " . URLROOT . "/admin/categories");

          // display error message
        } else {
          // invoke session helper flash function
          flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
          // redirect to admin cats
          header("Location: " . URLROOT . "/admin/categories");
        }

      // redirect
      } else {
        header("Location: " . URLROOT . "/admin/categories");
      }
    }

    // load posts
    public function posts() {

      // data array
      $data = [
        'h1' => 'All Posts',
        'description' => 'Use this panel to edit and delete posts.',
        'posts' => $this->posts,
        'posts_three_new' => $this->postsThreeNew,
        'action' => 'show_all'
      ];

      $this->view('admin/posts', $data);
    }

    // edit posts
    public function edit_post($post_id=null) {

      // search post by id
      $editPost = $this->postModel->searchPostByPostId($post_id);

      // if post exists
      if ($editPost) {

        // get all categories
        $categories = $this->catModel->getCats();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

          // sanitize POST data
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          // data array
          $data = [
            'h1' => 'Edit Post',
            'description' => 'Use this panel to edit the selected post.',
            'posts' => $this->posts,
            'posts_three_new' => $this->postsThreeNew,
            'action' => 'edit',
            'edit_post' => $editPost,
            'categories' => $categories,
            'post_user_id' => $editPost->post_user_id,
            'post_category_id' => trim($_POST['post_category_id']),
            'post_title' => trim($_POST['post_title']),
            'post_image' => $_FILES['post_image'],
            'post_content' => trim($_POST['post_content']),
            'post_tags' => trim($_POST['post_tags']),
            'post_title_err' => '',
            'post_image_err' => '',
            'post_content_err' => '',
            'post_tags_err' => '',
          ];

          // validate post title
          if (empty($data['post_title'])) {
            $data['post_title_err'] = "Please choose a title for your post.";
          }

          // validate post tags
          if (empty($data['post_tags'])) {
            $data['post_tags_err'] = "Please choose at least one tag so users can find your post easier.";
          }

          // validate post content
          if (empty($data['post_content'])) {
            $data['post_content_err'] = "Please tell us your story.";
          } 

          // set errors true or false
          if (!empty($data['post_title_err']) || !empty($data['post_tags_err']) || !empty($data['post_content_err'])) {
            $errors = true;
          } else {
            $errors = false;
          }

          // if new post image was uploaded
          if (!empty($data['post_image']['name'])) {

            // change post image name
            $data['post_image']['name'] = "user-" . $data['post_user_id'] . "-post-" . date("Y-m-d-H-i-s") . ".jpg";
            // invoke img validator return path or error
            $image = validateImageUpload($data['post_image'], $errors, 8, 'img/posts/');
            
            // validation error message
            if (strpos($image, '/') === false) {

              $data['post_image_err'] = $image;

              // save post image as additional thumb
            } else { 
              $imaging = new Imaging();
              $imaging->set_img($image);
              $imaging->set_quality(80);
              $imaging->set_size(200);
              $imaging->save_img("img/posts/thumb_" . $data['post_image']['name']);
              $imaging->clear_cache();
            }

            // remove old images
            unlink('img/posts/' . $data['edit_post']->post_image);
            unlink('img/posts/thumb_' . $data['edit_post']->post_image);

            // else set post image to old
          } else {
            $data['post_image']['name'] = $editPost->post_image;
          }

          // save post data to db
          if (empty($data['post_title_err']) && empty($data['post_tags_err']) && empty($data['post_content_err']) && empty($data['post_img_err'])) {
            
            // update post in database
            if ($this->postModel->editPost($data)) {

              // invoke session helper flash function
              flash('admin_alert', 'The post has been successfully updated.');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/admin/posts/");

              // remove images and die if error occurs
            } else {
              unlink($image);
              unlink('img/posts/thumb_' . $data['post_image']['name']);
              // invoke session helper flash function
              flash('admin_alert', 'Something went wrong.', 'alert alert-danger');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/admin/posts/");
            }

            // reload view with errors
          } else {
            $this->view('admin/posts' , $data);
          }

          // init
        } else {

          // data array
          $data = [
            'h1' => 'Edit Post',
            'description' => 'Use this panel to edit the selected post.',
            'posts' => $this->posts,
            'posts_three_new' => $this->postsThreeNew,
            'action' => 'edit',
            'edit_post' => $editPost,
            'categories' => $categories,
            'post_user_id' => '',
            'post_category_id' => $editPost->post_category_id,
            'post_title' => $editPost->post_title,
            'post_image' => $editPost->post_image,
            'post_content' => $editPost->post_content,
            'post_tags' => $editPost->post_tags,
            'post_title_err' => '',
            'post_image_err' => '',
            'post_content_err' => '',
            'post_tags_err' => '',
          ];

          $this->view('admin/posts', $data);
        }

        // redirect to all posts
      } else {
        header("Location: " . URLROOT . "/admin/posts");
      }
    }

    // delete post
    public function delete_post($post_id) {

      // search post by id
      $deletePost = $this->postModel->searchPostByPostId($post_id);

      // if post exists
      if ($deletePost) {

        // save post image paths to variables
        $post_image = "img/posts/".$deletePost->post_image;
        $post_image_thumb = "img/posts/thumb_".$deletePost->post_image;

        // delete post from database
        if ($this->postModel->deletePost($post_id)) {

          // remove post image from server
          unlink($post_image);
          unlink($post_image_thumb);

          // invoke session helper flash function
          flash('admin_alert', 'The post has been successfully deleted.');
          // if successfull load posts/add
          header("Location: " . URLROOT . "/admin/posts/");

          // else redirect and display message
        } else {
          // invoke session helper flash function
          flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
          // if successfull load posts/add
          header("Location: " . URLROOT . "/admin/posts/");
        }

        // else redirect
      } else {
        header("Location: " . URLROOT . "/admin/posts");
      }
    }

    // users
    public function users() {

      // get all users
      $users = $this->userModel->getUsers();

      // data array
      $data = [
        'h1' => 'Users',
        'description' => 'Use this panel to edit and delete users.',
        'posts' => $this->posts,
        'posts_three_new' => $this->postsThreeNew,
        'users' => $users,
        'action' => 'show_all',
        'user_role' => '',
        'username' => '',
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirm' => '',
        'user_bio' => '',
        'user_image' => '',
        'user_role_err' => '',
        'username_err' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'password_confirm_err' => '',
        'user_image_err' => ''
      ];

      // load view
      $this->view('admin/users', $data);
    }

    // create session method
    public function createUserSession($user, $redirect=true) {

      // create session variables
      $_SESSION['user_id'] = $user->user_id;
      $_SESSION['user_role'] = $user->user_role;
      $_SESSION['user_name'] = $user->user_real_name;
      $_SESSION['user_alias'] = $user->user_alias;
      $_SESSION['user_email'] = $user->user_email;

      if ($redirect) {
        // redirect to home
        header("Location: " . URLROOT);
      }
    }

    // edit user
    public function edit_user($user_id=null) {

      // get all users
      $users = $this->userModel->getUsers();
      // get user
      $user = $this->userModel->searchUser('user_id', $user_id);

      if (!empty($user)) {

        // if post method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

          // sanitize POST data
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          // data array
          $data = [
            'h1' => 'Users',
            'description' => 'Use this panel to edit and delete users.',
            'posts' => $this->posts,
            'posts_three_new' => $this->postsThreeNew,
            'user' => $user,
            'users' => $users,
            'action' => 'edit',
            'user_role' => $_POST['user_role'],
            'username' => trim($_POST['username']),
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'password_confirm' => $_POST['password_confirm'],
            'user_bio' => trim($_POST['user_bio']),
            'user_image' => $_FILES['user_image'],
            'user_role_err' => '',
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'password_confirm_err' => '',
            'user_image_err' => ''
          ];

          // validate name
          if (empty($data['name'])) {
            $data['name_err'] = 'Please enter name.';
          } elseif (strlen($data['name']) > 60) {
            $data['name_err'] = 'Your name can not be longer than 60 letters.';
          }

          // validate username
          if (empty($data['username'])) {
            $data['username_err'] = 'Please enter username.';
          } elseif (strlen($data['username']) > 60) {
            $data['username_err'] = 'Your username can not be longer than 60 letters.';
          } elseif ($this->userModel->searchUser('user_alias', $data['username'], true) && $data['username'] !== $user->user_alias) {
            $data['username_err'] = 'Username is already taken.';
          }

          // validate email
          if (empty($data['email'])) {
            $data['email_err'] = 'Please enter an email adress.';
          } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email_err'] = 'Please enter valid email.';
          } elseif ($this->userModel->searchUser('user_email', $data['email'], true) && $data['email'] !== $user->user_email) {
            $data['email_err'] = 'Email is already taken.';
          }

          // validate password
          if (!empty($data['password']) &&  strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters.';
          } elseif (strlen($data['password']) > 30) {
            $data['password_err'] = 'Your password can not be longer than 30 letters.';
          }

          // validate password confirmation
          if (!empty($data['password']) && empty($data['password_confirm'])) {
            $data['password_confirm_err'] = 'Please confirm password.';
          } elseif ($data['password'] !== $data['password_confirm']) {
            $data['password_confirm_err'] = 'Passwords are not matching.';
          }

          // if user image was uploaded
          if (!empty($data['user_image']['name']) && empty($data['name_err']) && empty($data['username_err']) && empty($data['email_err']) &&  empty($data['password_err']) && empty($data['password_confirm_err'])) {
            
            // change image name
            $data['user_image']['name'] = "profile_pic_user_" . $user->user_id . ".jpg";
            // invoke img validator return path or error
            $image = validateImageUpload($data['user_image'], false, 8, 'img/users/');

            // image validation and convertion
            if (strpos($image, '/') === false) {
              $data['user_image_err'] = $image;
            } elseif (!empty($data['user_image']['name']) && strpos($image, '/') !== false) {
              // convert image to thumb
              $imaging = new Imaging();
              $imaging->set_img($image);
              $imaging->set_quality(80);
              $imaging->set_size(500);
              $imaging->save_img("img/users/" . $data['user_image']['name']);
              $imaging->clear_cache();
            }
          }

          // update db and image
          if (empty($data['user_image_err']) && empty($data['name_err']) && empty($data['username_err']) && empty($data['email_err']) &&  empty($data['password_err']) && empty($data['password_confirm_err'])) {

            // hash new password
            if (!empty($data['password'])) {
              $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            // update rights
            if (!$this->userModel->updateRights($data['user']->user_id, $data['user_role'])) {
              // invoke session helper flash function
              flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
              // if successfull redirect
              header("Location: " . URLROOT . "/admin/users");
            }

            // if password and image wasnt updated
            if (empty($data['password']) && empty($data['user_image']['name']) && $this->userModel->updateUserInfo($data)) {

              // if user edits himself create new session
              if ($data['user']->user_id === $_SESSION['user_id']) {
                // get new user info
                $user = $this->userModel->searchUser('user_id', $user_id);
                $this->createUserSession($user, false);
              }

              // invoke session helper flash function
              flash('admin_alert', 'The user information has been updated successfully.');
              // if successfull redirect
              header("Location: " . URLROOT . "/admin/users");
              
              // if image was updated
            } elseif (empty($data['password']) && $this->userModel->updateUserInfo($data, false, true)) {
              
              // if user edits himself create new session
              if ($data['user']->user_id === $_SESSION['user_id']) {
                // get new user info
                $user = $this->userModel->searchUser('user_id', $user_id);
                $this->createUserSession($user, false);
              }

              // invoke session helper flash function
              flash('admin_alert', 'The user information has been updated successfully.');
              // if successfull redirect
              header("Location: " . URLROOT . "/admin/users");

              // if password was updated
            } elseif (empty($data['user_image']['name']) && $this->userModel->updateUserInfo($data, true, false)) {

              // if user edits himself create new session
              if ($data['user']->user_id === $_SESSION['user_id']) {
                // get new user info
                $user = $this->userModel->searchUser('user_id', $user_id);
                $this->createUserSession($user, false);
              }

              // invoke session helper flash function
              flash('admin_alert', 'The user information has been updated successfully.');
              // if successfull redirect
              header("Location: " . URLROOT . "/admin/users");

              // if image and password were updated
            } elseif ($this->userModel->updateUserInfo($data, true, true)) {
              
              // if user edits himself create new session
              if ($data['user']->user_id === $_SESSION['user_id']) {
                // get new user info
                $user = $this->userModel->searchUser('user_id', $user_id);
                $this->createUserSession($user, false);
              }

              // invoke session helper flash function
              flash('admin_alert', 'The user information has been updated successfully.');
              // if successfull redirect
              header("Location: " . URLROOT . "/admin/users");
            }

            // redirect
          } else {

            // create errors array
            $errors = array($data['user_image_err'], $data['name_err'], $data['username_err'], $data['email_err'], $data['password_err'], $data['password_confirm_err']);

            // create error message
            foreach ($errors as $error) {
              if (!empty($error)) {
                flash('admin_alert', $error, 'alert alert-danger');
              }
            }

            // redirect
            header("Location: " . URLROOT . "/admin/users");
          }

          // init
        } else {

          // data array
          $data = [
            'h1' => 'Users',
            'description' => 'Use this panel to edit and delete users.',
            'posts' => $this->posts,
            'posts_three_new' => $this->postsThreeNew,
            'user' => $user,
            'users' => $users,
            'action' => 'edit',
            'user_role' => '',
            'username' => '',
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirm' => '',
            'user_bio' => '',
            'user_image' => '',
            'username_err' => '',
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'password_confirm_err' => '',
            'user_image_err' => ''
          ];

          // load view
          $this->view('admin/users', $data);
        }

        // else redirect
      } else {
        // invoke session helper flash function
        flash('admin_alert', 'User not found. Please try again.', 'alert alert-danger');
        header("Location: " . URLROOT . "/admin/users");
      }

    }

    // delete user
    public function delete_user($user_id=null) {

      // get all users
      $users = $this->userModel->getUsers();
      // get user
      $user = $this->userModel->searchUser('user_id', $user_id);

      if (!empty($user)) {

        // data array
        $data = [
          'h1' => 'Users',
          'description' => 'Use this panel to edit and delete users.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'user' => $user,
          'users' => $users,
          'action' => 'delete',
          'user_role' => '',
          'username' => '',
          'name' => '',
          'email' => '',
          'password' => '',
          'password_confirm' => '',
          'user_bio' => '',
          'user_image' => '',
          'username_err' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => '',
          'user_image_err' => ''
        ];

        // get user posts
        $userPosts = $this->postModel->getPostsbyUser($user_id);

        // delete from db
        if ($this->userModel->deleteUser($user_id)) {

          // delete user image
          if (!strpos($user->user_image, 'standard')) {
            $user_imaeg_path = "img/users/".$user->user_image;
            unlink($user_imaeg_path);
          }

          // delete user's posts and post images
          foreach ($userPosts as $userPost) {

            // save post image paths to variables
            $post_image_path = "img/posts/".$userPost->post_image;
            $post_image_thumb = "img/posts/thumb_".$userPost->post_image;
            // remove post image from server
            unlink($post_image_path);
            unlink($post_image_thumb);

            // delete post from db
            if (!$this->postModel->deletePost($userPost->post_id)) {
              // invoke session helper flash function
              flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
              header("Location: " . URLROOT . "/admin/users");
            }
          }

          // invoke session helper flash function
          flash('admin_alert', 'The user has been successfully deleted.');
          // if successfull redirect
          header("Location: " . URLROOT . "/admin/users");
        } else {
          // invoke session helper flash function
          flash('admin_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
          header("Location: " . URLROOT . "/admin/users");
        }
      
        // else redirect
      } else {
        // invoke session helper flash function
        flash('admin_alert', 'User not found. Please try again.', 'alert alert-danger');
        header("Location: " . URLROOT . "/admin/users");
      }
    }

    // add user
    public function add_user() {

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // data array
        $data = [
          'h1' => 'Add User',
          'description' => 'Use this panel to add a new user to the site.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'action' => 'add',
          'role' => $_POST['user_role'],
          'username' => trim($_POST['username']),
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => $_POST['password'],
          'password_confirm' => $_POST['password_confirm'],
          'user_role_err' => '',
          'username_err' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => '',
        ];

        // validate name
        if (empty($data['name'])) {
          $data['name_err'] = 'Please enter name.';
        } elseif (strlen($data['name']) > 60) {
          $data['name_err'] = 'Your name can not be longer than 60 letters.';
        }

        // validate username
        if (empty($data['username'])) {
          $data['username_err'] = 'Please enter username.';
        } elseif (strlen($data['username']) > 60) {
          $data['username_err'] = 'Your username can not be longer than 60 letters.';
        } elseif ($this->userModel->searchUser('user_alias', $data['username'], true)) {
          $data['username_err'] = 'Username is already taken.';
        }

        // validate email
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter valid email.';
        } elseif ($this->userModel->searchUser('user_email', $data['email'], true)) {
          $data['email_err'] = 'Email is already taken.';
        }

        // validate password
        if (empty($data['password'])) {
          $data['password_err'] = 'Please enter password.';
        } elseif (strlen($data['password']) < 6) {
          $data['password_err'] = 'Password must be at least 6 characters.';
        } elseif (strlen($data['password']) > 30) {
          $data['password_err'] = 'Your password can not be longer than 30 letters.';
        }

        // validate password confirmation
        if (empty($data['password_confirm'])) {
          $data['password_confirm_err'] = 'Please confirm password.';
        } elseif ($data['password'] !== $data['password_confirm']) {
          $data['password_confirm_err'] = 'Passwords are not matching.';
        }

        // check if errors are empty
        if (empty($data['name_err']) && empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['password_confirm_err'])) {

          // hash password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          // save user to database
          if ($this->userModel->createUser($data)) {

            // invoke session helper flash function
            flash('admin_alert', 'The user has been created successfully.');
            // if successfull load login page
            header("Location: " . URLROOT . "/admin/users");

            // die if error occurs
          } else {
            // invoke session helper flash function
            flash('admin_alert', 'Something went wrong. Please try again', 'alert alert-danger');
            // if successfull load login page
            header("Location: " . URLROOT . "/admin/users");
          }

          // reload view with errors
        } else {
          $this->view('admin/users', $data);
        }

        // init
      } else {

        // data array
        $data = [
          'h1' => 'Add User',
          'description' => 'Use this panel to add a new user to the site.',
          'posts' => $this->posts,
          'posts_three_new' => $this->postsThreeNew,
          'action' => 'add',
          'role' => '',
          'username' => '',
          'name' => '',
          'email' => '',
          'password' => '',
          'password_confirm' => '',
          'user_role_err' => '',
          'username_err' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => '',
        ];

        // load view
        $this->view('admin/users', $data);
      }
    }
    
  }
?>