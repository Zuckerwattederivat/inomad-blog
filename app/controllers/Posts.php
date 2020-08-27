<?php 
  /*
  * App Posts Controller Class
  * Loads posts content
  * Lets users add posts
  * Passes data from and to models
  */
  class Posts extends Controller {

    public function __construct() {

      // construct models
      $this->postModel = $this->model('Post');
      $this->catModel = $this->model('Category');
      $this->imgModel = $this->model('Imaging');
      
    }

    // index
    public function index() {
      header("Location: " . URLROOT . "/errors/page_not_found");
    }

    // search by category
    public function category($id=null, $page=1) {

      // get all categories
      $categories = $this->catModel->getCats();

      // check if category id isset
      if ($id) {

        // get category from GET Value
        $catFromGet = $this->catModel->searchCats('cat_id', $id);
        // if categories not found load 404 page
        if (empty($catFromGet)) {
          header("Location: " . URLROOT . "/errors/page_not_found");
        }
        // get posts based on cat_id
        $posts = $this->postModel->searchPostsByCat($catFromGet->cat_id, $catFromGet->cat_title);
        // get posts paginated
        $posts_paginated = $this->postModel->searchPostsByCatLimit($catFromGet->cat_id, $catFromGet->cat_title, $page-1, 10);

        // data array
        $data = [
          'h2' => $catFromGet->cat_title,
          'post_count' => count($posts),
          'posts_paginated' => $posts_paginated,
          'current_page' => $page,
          'categories' => $categories,
          'cat_id' => $id,
          'no_posts_err' => ''
        ];

        // if page not found load page 1
        if ($data['current_page'] > paginationCeil($data['post_count'], 10)) {
          header('Location: ' . URLROOT . '/posts/category/' . $data['cat_id']);
        }

        // check if posts are available
        if (empty($posts_paginated)) {
          $data['no_posts_err'] = "Sorry there aren't any posts under this category yet.";
        }

        // load view and pass data array
        $this->view('posts/category', $data);

        // if cat id is not set
      } else {
        // load 404 page
        header("Location: " . URLROOT . "/errors/page_not_found");
      }
    }

    // category next page
    public function category_page($id=null, $page=null) {

      // get all categories
      $categories = $this->catModel->getCats();

      // check if category id and page isset
      if ($id && is_numeric($page) && $page > 0) {

        // get category from GET Value
        $catFromGet = $this->catModel->searchCats('cat_id', $id);

        // if categories not found load 404 page
        if (empty($catFromGet)) {
          header("Location: " . URLROOT . "/errors/page_not_found");
        }

        // get posts based on cat_id
        $posts = $this->postModel->searchPostsByCat($catFromGet->cat_id, $catFromGet->cat_title);
        // get posts paginated
        $posts_paginated = $this->postModel->searchPostsByCatLimit($catFromGet->cat_id, $catFromGet->cat_title, ($page-1)*10, 10);

        // data array
        $data = [
          'h2' => $catFromGet->cat_title.' Page '.$page,
          'post_count' => count($posts),
          'posts_paginated' => $posts_paginated,
          'current_page' => $page,
          'categories' => $categories,
          'cat_id' => $id,
          'no_posts_err' => ''
        ];

        // if page not found load page 1
        if ($data['current_page'] > paginationCeil($data['post_count'], 10)) {
          header('Location: ' . URLROOT . '/posts/category/' . $data['cat_id']);
        }

        // check if posts are available
        if (empty($posts_paginated)) {
          $data['no_posts_err'] = "Sorry there aren't any posts under this category yet.";
        }

        // load view and pass data array
        $this->view('posts/category', $data);

        // if cat id is not set
      } else {
        // load 404 page
        header("Location: " . URLROOT . "/errors/page_not_found");
      }
    }

    // search by search input
    public function search($page=1) {

      // get all categories
      $categories = $this->catModel->getCats();

      // check if POST
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // get posts based on POST superglobal and post tags
        $posts = $this->postModel->searchPostsSimilar('post_tags', $_POST['search']);
        // get posts paginated
        if ($page === 1) {
          $posts_paginated = $this->postModel->searchPostsSimilarLimit('post_tags', $_POST['search'], $page-1);
        } else {
          $posts_paginated = $this->postModel->searchPostsSimilarLimit('post_tags', $_POST['search'], ($page-1)*10);
        }

        // data array
        $data = [
          'h2' => 'Your Search Results',
          'search' => $_POST['search'],
          'posts' => $posts,
          'post_count' => count($posts),
          'posts_paginated' => $posts_paginated,
          'current_page' => $page,
          'categories' => $categories,
          'no_posts_err' => ''
        ];

        // change heading
        if ($page !== 1) {
          $data['h2'] = 'Your Search Results Page '.$page;
        }

        // return error if no posts were found
        if (empty($posts)) {
          $data['no_posts_err'] = "Sorry we coudn't find any matching post.";
        }

        // laod view
        $this->view('posts/search', $data);

        // init with error
      } else {

        // data array
        $data = [
          'h2' => 'Your Search Results',
          'posts' => '',
          'post_count' => 0,
          'current_page' => $page,
          'categories' => $categories,
          'no_posts_err' => "Sorry please tell us what you are looking for."
        ];

        // load view and pass data array
        $this->view('posts/search', $data);
      }
    }

    public function show($id=null) {

      if ($id) {

        // get all categories
        $categories = $this->catModel->getCats();
        // get post based on post id
        $post = $this->postModel->searchPostByPostId($id);
        // get category from GET Value
        $catFromGet = $this->catModel->searchCats('cat_id', $post->post_category_id);
        // get related posts
        $related_posts = $this->postModel->searchPostsByCatLimit($catFromGet->cat_id, $catFromGet->cat_title, 1, 4);
        
        // if post not found load homepage
        if (empty($post)) {
          header("Location: " . URLROOT . "/errors/page_not_found");
        }

        // save post paragraphs to array
        $post_paragraphs = saveParagraphsToArray($post->post_content);

        // data array
        $data = [
          'categories' => $categories,
          'post' => $post,
          'post_paragraphs' => $post_paragraphs,
          'related_posts' => $related_posts
        ];

        // load view
        $this->view('posts/show', $data);

      } else {
        header("Location: " . URLROOT . "/errors/page_not_found");
      }
    }

    public function add() {

      // if user is not logged redirect to login and display alert
      if (!isLoggedIn()) {
        flash('login_alert', 'Please login to edit your posts.', 'alert alert-danger');
        Header('Location: ' . URLROOT . '/users/login');
      }

      // get three newest posts by user
      $posts_newest = $this->postModel->getPostsbyUser($_SESSION['user_id'], true);
      // get all posts by user
      $posts = $this->postModel->getPostsbyUser($_SESSION['user_id'], false);

      // get all categories
      $categories = $this->catModel->getCats();
      
      // check for POST
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // data array
        $data = [
          'h2_1' => 'Add Post',
          'h2_2' => 'Your Latest Posts',
          'description' => 'Use this form to add a new post to iNomad.',
          'posts_newest' => $posts_newest,
          'posts' => $posts,
          'post_count_new' => count($posts) + 1,
          'categories' => $categories,
          'user_alias' => $_SESSION['user_alias'],
          'post_user_id' => $_SESSION['user_id'],
          'post_category_id' => $_POST['post_category_id'],
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
        if (!empty($data['post_title_err']) || !empty($data['post_tags_err']) || !empty($data['post_content_err']) || empty($data['post_image']['name'])) {
          $errors = true;
        } else {
          $errors = false;
        }

        // change post image name
        $data['post_image']['name'] = "user-" . $data['post_user_id'] . "-post-" . date("Y-m-d-H-i-s") . ".jpg";
        // invoke img validator return path or error
        $image = validateImageUpload($data['post_image'], $errors, 8, 'img/posts/');
        
        // validation error message
        if (strpos($image, '/') === false) {

          // safe error to data array
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

        // save post data to db
        if (empty($data['post_title_err']) && empty($data['post_tags_err']) && empty($data['post_content_err']) && empty($data['post_image_err'])) {
          
          // save post to database
          if ($this->postModel->createPost($data)) {

            // invoke session helper flash function
            flash('post_alert', 'Thank you for submitting your post!');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/posts/add");

            // remove images and die if error occurs
          } else {
            unlink($image);
            unlink('img/posts/thumb_' . $data['post_image']['name']);
            // invoke session helper flash function
            flash('post_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
            // if successfull load posts/add
            header("Location: " . URLROOT . "/posts/add");
          }

          // reload view with errors
        } else {
          $this->view('posts/add', $data);
        }

        // init
      } else {

        // data array
        $data = [
          'h2_1' => 'Add Post',
          'h2_2' => 'Your Latest Posts',
          'description' => 'Use this form to add a new post to iNomad.',
          'posts_newest' => $posts_newest,
          'posts' => $posts,
          'categories' => $categories,
          'user_alias' => $_SESSION['user_alias'],
          'post_user_id' => '',
          'post_category_id' => '',
          'post_title' => '',
          'post_image' => '',
          'post_content' => '',
          'post_tags' => '',
          'post_title_err' => '',
          'post_image_err' => '',
          'post_content_err' => '',
          'post_tags_err' => '',
        ];

        // load add posts view
        $this->view('posts/add', $data);
      }
    
    }

    public function edit($post_edit_id=null) {

      // if user is not logged redirect to login and display alert
      if (!isLoggedIn()) {
        flash('login_alert', 'Please login to edit your posts.', 'alert alert-danger');
        Header('Location: ' . URLROOT . '/users/login');

        // if post id is null redirect to 404
      } elseif ($post_edit_id === null) {
        header("Location: " . URLROOT . "/errors/page_not_found");
      }

      // get post
      $editPost = $this->postModel->searchPostByPostId($post_edit_id);

      if (!empty($editPost) && $editPost->post_user_id === $_SESSION['user_id']) {

        // get three newest posts by user
        $posts_newest = $this->postModel->getPostsbyUser($_SESSION['user_id'], true);
        // get all posts by user
        $posts = $this->postModel->getPostsbyUser($_SESSION['user_id'], false);

        // get all categories
        $categories = $this->catModel->getCats();
        
        // check for POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

          // sanitize POST data
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          // data array
          $data = [
            'h2_1' => 'Edit Post',
            'h2_2' => 'Your Latest Posts',
            'description' => 'Use this form to edit your post.',
            'posts_newest' => $posts_newest,
            'posts' => $posts,
            'edit_post' => $editPost,
            'post_count_new' => count($posts) + 1,
            'categories' => $categories,
            'user_alias' => $_SESSION['user_alias'],
            'post_user_id' => $_SESSION['user_id'],
            'post_category_id' => $_POST['post_category_id'],
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
              flash('posts_alert', 'Your post has been successfully updated.');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/users/posts/".$_SESSION['user_id']);

              // remove images and die if error occurs
            } else {
              unlink($image);
              unlink('img/posts/thumb_' . $data['post_image']['name']);
              // invoke session helper flash function
              flash('posts_alert', 'Something went wrong. Please try again.', 'alert alert-danger');
              // if successfull load posts/add
              header("Location: " . URLROOT . "/users/posts/".$_SESSION['user_id']);
            }

            // reload view with errors
          } else {
            $this->view('posts/edit' , $data);
          }

          // init
        } else {

          // data array
          $data = [
            'h2_1' => 'Edit Post',
            'h2_2' => 'Your Latest Posts',
            'description' => 'Use this form to edit your post.',
            'posts_newest' => $posts_newest,
            'posts' => $posts,
            'edit_post' => $editPost,
            'categories' => $categories,
            'user_alias' => $_SESSION['user_alias'],
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

          // load add posts view
          $this->view('posts/edit', $data);
        }

        // redirect to home
      } else {
        header("Location: " . URLROOT . "/errors/page_not_found");
      }
    
    }
  }
?>