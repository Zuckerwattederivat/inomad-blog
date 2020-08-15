<?php 
  /*
  * App AJAX Controller Class
  * Loads recieves ajax commands 
  * Passes data from and to models
  * Loads views accordingly
  */
  class AJAX extends Controller {

    public function __construct() {
      $this->postModel = $this->model('Post');
    }
    
    // load posts users profile
    public function loadPostsUser() {

      if (isset($_POST['getData'])) {

        // get POST values
        $lower_limit = trim($_POST['lower_limit']);
        $upper_limit = trim($_POST['upper_limit']);
        $user_id = trim($_POST['user_id']);
        
        // get posts
        $posts = $this->postModel->getPostsbyUserLimit($user_id, $lower_limit, $upper_limit); 
        
        // create data array
        $data = [
          'posts' => $posts
        ];
        
        // check if posts are empty if not load view
        if ($posts != false) {
          $this->view('includes/users_post_cards', $data);
        } else {
          $posts;
        }
  
      } else {
        header('Location: ' . URLROOT);
      }
    }
  }

?>