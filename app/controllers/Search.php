<?php 
  /*
  * App Search Controller Class
  * Loads search pages
  * Passes data from and to models
  */
  class Search extends Controller {

    public function __construct() {

      // construct models
      $this->postModel = $this->model('Post');
      $this->catModel = $this->model('Category');
    }

    // index
    public function index() {
      // load 404 page
      header("Location: " . URLROOT . "/errors/page_not_found");
    }

    // search by category
    public function category() {

      // get all categories
      $categories = $this->catModel->getCats();

      // check if category id isset
      if (isset($_GET['id'])) {

        // get category from GET Value
        $catFromGet = $this->catModel->searchCats('cat_id', $_GET['id']);
        // $catFromGet = $catFromGet[0];
        // get posts based on cat_id
        $posts = $this->postModel->searchPosts('post_category_id', $_GET['id']);
        
        // if categories not found load 404 page
        if (empty($catFromGet)) {
          header("Location: " . URLROOT . "/errors/page_not_found");
        }

        // data array
        $data = [
          'h2' => $catFromGet->cat_title,
          'posts' => $posts,
          'categories' => $categories,
          'post_id' => $catFromGet->cat_id,
          'no_posts_err' => ''
        ];

        // check if posts are available
        if (empty($posts)) {
          $data['no_posts_err'] = "Sorry there aren't any posts under this category yet.";
        }

        // load view and pass data array
        $this->view('search/category', $data);

        // if cat id is not set
      } else {

        // go to 404 page
        header("Location: " . URLROOT . "/errors/page_not_found");
      }
    }

    // search by search input
    public function search() {

      // get all categories
      $categories = $this->catModel->getCats();

      // check if POST search isset
      if (isset($_POST['search']) && strlen($_POST['search']) >= 3) {

        // get posts based on POST superglobal and post tags
        $posts = $this->postModel->searchPostsSimilar('post_tags', $_POST['search']);

        // data array
        $data = [
          'posts' => $posts,
          'categories' => $categories,
          'no_posts_err' => ''
        ];

        if (empty($posts)) {
          $data['no_posts_err'] = "Sorry we coudn't find any matching post.";
        }

        // load view and pass data array
        $this->view('search/search', $data);

        // if search input too short
      } elseif (strlen($_POST['search']) < 3 && strlen($_POST['search']) !== 0) {

        // data array
        $data = [
          'posts' => '',
          'categories' => $categories,
          'no_posts_err' => "Sorry your search input was too short. 3 Letters are needed."
        ];

        // load view and pass data array
        $this->view('search/search', $data);

        // if no search input was provided
      } else {

        // data array
        $data = [
          'posts' => '',
          'categories' => $categories,
          'no_posts_err' => "Sorry please tell us what you are looking for."
        ];

        // load view and pass data array
        $this->view('search/search', $data);
      }
    }
  }
?>