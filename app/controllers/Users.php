<?php
  /*
  * App Users Controller Class
  * Handels user registration & login
  * Passes data from and to models
  */
  class Users extends Controller {

    public function __construct() {

      // Construct models
      $this->catModel = $this->model('Category');
      $this->userModel = $this->model('User');
      $this->postModel = $this->model('Post');
      $this->imgModel = $this->model('Imaging');
    }

    // index
    public function index() {
      header('Location: ' . URLROOT);
    }

    // register method
    public function register() {

      // get all categories for data
      $categories = $this->catModel->getCats();

      // check for POST
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // panitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Pprocess form
        $data = [
          'categories' => $categories,
          'lead' => 'Create An Account',
          'description' => 'Please fill out this form to join the ranks of iNomad and start telling your stories.',
          'name' => trim($_POST['name']),
          'role' => 'user',
          'username' => trim($_POST['username']),
          'email' => trim($_POST['email']),
          'password' => $_POST['password'],
          'password_confirm' => $_POST['password_confirm'],
          'name_err' => '',
          'username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => ''
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
            flash('login_alert', 'Thank you for signing up with us!');
            // if successfull load login page
            header("Location: " . URLROOT . "/users/login");

            // die if error occurs
          } else {
            // invoke session helper flash function
            flash('login_alert', 'Something went wrong. Please try again', 'alert alert-danger');
            // if successfull load login page
            header("Location: " . URLROOT . "/users/register");
          }

        } else {
          
          // reload view with errors
          $this->view('users/register', $data);
        }

        // load form
      } else {

        // init data
        $data = [
          'categories' => $categories,
          'lead' => 'Create An Account',
          'description' => 'Please fill out this form to join our ranks and start telling your stories.',
          'name' => '',
          'role' => '',
          'username' => '',
          'email' => '',
          'password' => '',
          'password_confirm' => '',
          'name_err' => '',
          'username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => ''
        ];

        // load view
        $this->view('users/register', $data);
      } 
    }

    // login method
    public function login() {

      // get all categories for data
      $categories = $this->catModel->getCats();

      // check for POST
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // process form
        $data = [
          'categories' => $categories,
          'lead' => 'Log Into Your Account.',
          'description' => 'Please fill in your login credentials to start telling us your stories.',
          'email' => trim($_POST['email']),
          'password' => $_POST['password'],
          'username_err' => '',
          'password_err' => '',
        ];

        // validate username
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email.';
        } elseif ($this->userModel->searchUser('user_email', $data['email'], true)) {
          // user found
        } else {
          $data['email_err'] = "Email doesn't exist.";
        }

        // validate password
        if (empty($data['password'])) {
          $data['password_err'] = 'Please enter password.';
        }

        // check if errors are empty
        if (empty($data['email_err']) && empty($data['password_err'])) {

          // log in user after successfull check in db
          $loggedInUser = $this->userModel->loginUser($data['email'], $data['password']);
          
          // create session if user login successfull redirect to home
          if ($loggedInUser) {
            $this->createUserSession($loggedInUser);
            // else reload view with error message
          } else {
            $data['password_err'] = 'Password inccorect.';
            $this->view('users/login', $data);
          }

        } else {
          
          // reload view with errors
          $this->view('users/login', $data);
        }

        // load form
      } else {

        // init data
        $data = [
          'categories' => $categories,
          'lead' => 'Log Into Your Account.',
          'description' => 'Please fill in your login credentials to start telling us your stories.',
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Load view
        $this->view('users/login', $data);
      } 
    }

    // logout method
    public function logout($redirect=true) {

      // remove session 
      unset($_SESSION['user_id']);
      unset($_SESSION['user_role']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_alias']);
      unset($_SESSION['user_email']);
      session_destroy();

      if ($redirect) {
        // redirect to home
        header("Location: " . URLROOT);
      }
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

     // user profile
    public function profile() {

      // if user is not logged redirect to login and display alert
      if (!isLoggedIn()) {
        flash('login_alert', 'Please login to see your profile.', 'alert alert-danger');
        Header('Location: ' . URLROOT . '/users/login');
      }

      // get all categories for data
      $categories = $this->catModel->getCats();
      // search user
      $user = $this->userModel->searchUser('user_id', $_SESSION['user_id']);
      // get all posts by user
      $posts = $this->postModel->getPostsbyUser($_SESSION['user_id'], false);
      // get newest posts of user
      $postsNewest = $this->postModel->getPostsbyUser($_SESSION['user_id'], true);

      // check for POST
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // data array
        $data = [
          'h2_1' => 'Profile',
          'description' => 'Use this form to change your infos.',
          'user' => $user,
          'user_id' => $user->user_id,
          'posts' => $posts,
          'posts_newest' => $postsNewest,
          'post_count' => count($posts),
          'categories' => $categories,
          'user_image' => $_FILES['user_image'],
          'user_bio' => trim($_POST['user_bio']),
          'name' => trim($_POST['name']),
          'username' => trim($_POST['username']),
          'email' => trim($_POST['email']),
          'password' => $_POST['password'],
          'password_confirm' => $_POST['password_confirm'],
          'user_image_err' => '',
          'name_err' => '',
          'username_err' => '',
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
        } elseif ($this->userModel->searchUser('user_alias', $data['username'], true) && $data['username'] !== $_SESSION['user_alias']) {
          $data['username_err'] = 'Username is already taken.';
        }

        // validate email
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter valid email.';
        } elseif ($this->userModel->searchUser('user_email', $data['email'], true) && $data['email'] !== $_SESSION['user_email']) {
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

          // if password and image wasnt updated
          if (empty($data['password']) && empty($data['user_image']['name']) && $this->userModel->updateUserInfo($data)) {

            // get new user info
            $user = $this->userModel->searchUser('user_id', $data['user_id']);
            // create new session
            $this->createUserSession($user ,false);
            // invoke session helper flash function
            flash('profile_alert', 'Your profile information has been updated successfully.');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/users/profile");
            
            // if image was updated
          } elseif (empty($data['password']) && $this->userModel->updateUserInfo($data, false, true)) {
            
            // get new user info
            $user = $this->userModel->searchUser('user_id', $data['user_id']);
            // create new session
            $this->createUserSession($user ,false);
            // invoke session helper flash function
            flash('profile_alert', 'Your profile information has been updated successfully.');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/users/profile");

            // if password was updated
          } elseif (empty($data['user_image']['name']) && $this->userModel->updateUserInfo($data, true, false)) {

            // get new user info
            $user = $this->userModel->searchUser('user_id', $data['user_id']);
            // create new session
            $this->createUserSession($user ,false);
            // invoke session helper flash function
            flash('profile_alert', 'Your profile information has been updated successfully.');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/users/profile");

            // if image and password were updated
          } elseif ($this->userModel->updateUserInfo($data, true, true)) {
            
            // get new user info
            $user = $this->userModel->searchUser('user_id', $data['user_id']);
            // create new session
            $this->createUserSession($user ,false);
            // invoke session helper flash function
            flash('profile_alert', 'Your profile information has been updated successfully.');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/users/profile");

            // else unlink image and display error
          } else {
            unlink($image);
            // invoke session helper flash function
            flash('profile_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/users/profile");
          }

          // reload view
        } else {
          $this->view('users/profile', $data);
        }

        // init
      } else {

        // data array
        $data = [
          'h2_1' => 'User Profile',
          'description' => 'Use this form to change your infos.',
          'user' => $user,
          'posts' => $posts,
          'posts_newest' => $postsNewest,
          'post_count' => count($posts),
          'categories' => $categories,
          'name' => $user->user_real_name,
          'username' => $user->user_alias,
          'email' => $user->user_email,
          'password' => '',
          'password_confirm' => '',
          'user_image' => '',
          'user_bio' => $user->user_bio,
          'user_image_err' => '',
          'name_err' => '',
          'username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'password_confirm_err' => '',
        ];

        $this->view('users/profile', $data);
      }
    }

    public function posts($id=null, $del_post_id=null) {

      // if id is empty redirect
      if (empty($id)) {

        header("Location: " . URLROOT);
        
        // if id isn't empty load
      } else {

        // get all categories for data
        $categories = $this->catModel->getCats();
        // get all posts by user
        $posts = $this->postModel->getPostsbyUser($id, false);
        // search user
        $user = $this->userModel->searchUser('user_id', $id);

        // if user doesn't exist redirect
        if (empty($user)) {
          header("Location: " . URLROOT);
        }

        // data array
        $data = [
          'h4_1' => 'This user has no posts yet...',
          'user' => $user,
          'posts' => $posts,
          'post_count' => count($posts),
          'categories' => $categories
        ];

        // post delete
        if ($del_post_id !== null) {

          // get post
          $post = $this->postModel->searchPostByPostId($del_post_id);
          
          // if post exists and user is author
          if (!empty($post) && $_SESSION['user_id'] === $post->post_user_id) {

            // save post image paths to variables
            $post_image = "img/posts/".$post->post_image;
            $post_image_thumb = "img/posts/thumb_".$post->post_image;

            // if deletion was successful
            if ($this->postModel->deletePost($del_post_id)) {

              // remove post image from server
              unlink($post_image);
              unlink($post_image_thumb);
              // invoke session helper flash function
              flash('posts_alert', 'The post has been successfully deleted.');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/users/posts/" . $id);

              // redirect display error
            } else {
              // invoke session helper flash function
              flash('posts_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/users/posts/" . $id);
            }

            // load init view
          } else {
            $this->view('users/posts', $data);
          }

          // load init view
        } else {
          $this->view('users/posts', $data);
        }
      }

    }
  }
?>