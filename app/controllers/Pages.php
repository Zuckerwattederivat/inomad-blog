<?php
  /*
  * App Pages Controller Class
  * Loads pages
  * Passes data from and to models
  */
  class Pages extends Controller {

    public function __construct() {

      // construct models
      $this->postModel = $this->model('Post');
      $this->catModel = $this->model('Category');
    }

    // Load index
    public function index($page=1) {

      if (is_numeric($page)) {
        // get all posts
        $posts = $this->postModel->getPosts();
        // get 3 random posts
        $postsThreeRand = $this->postModel->getThreeRandPosts();
        // get all categories
        $categories = $this->catModel->getCats();
        // get paginated posts
        $posts_paginated = $this->postModel->getPostsLimit($page-1, 10);

        // data array
        $data = [
          'lead' => 'Discover Our Stories',
          'description' => 'This blog brings together travel enthusiasts and digital nomads and lets them share their stories. Register now and start telling us of your adventures.',
          'h2' => 'Newest Articles',
          'posts_paginated' => $posts_paginated,
          'post_count' => count($posts),
          'posts_three_rand' => $postsThreeRand,
          'categories' => $categories,
          'current_page' => $page,
          'no_posts_err' => ''
        ];

        // if no posts exist save error
        if (empty($posts)) {
          $data['no_posts_err'] = "There aren't any posts yet.";
        }

        // if page not found load page 1
        if ($data['current_page'] > paginationCeil($data['post_count'], 10)) {
          header('Location: ' . URLROOT);
        }

        // load view and pass data array
        $this->view('pages/index', $data);

        // redirect to 404
      } else {
        header("Location: " . URLROOT . "/errors/page_not_found");
      }

    }

    // Load index
    public function page($page=1) {

      if (is_numeric($page)) {

        // get all posts
        $posts = $this->postModel->getPosts();
        // get 3 random posts
        $postsThreeRand = $this->postModel->getThreeRandPosts();
        // get all categories
        $categories = $this->catModel->getCats();
        // get paginated posts
        $posts_paginated = $this->postModel->getPostsLimit(($page-1)*10, 10);

        // data array
        $data = [
          'lead' => 'Discover Our Stories',
          'description' => 'This blog brings together travel enthusiasts and digital nomads and lets them share their stories. Register now and start telling us of your adventures.',
          'h2' => 'Newest Articles Page '.$page,
          'posts_paginated' => $posts_paginated,
          'post_count' => count($posts),
          'posts_three_rand' => $postsThreeRand,
          'categories' => $categories,
          'current_page' => $page,
          'no_posts_err' => '',
        ];

        // if page not found load page 1
        if ($data['current_page'] > paginationCeil($data['post_count'], 10)) {
          header("Location: " . URLROOT);
        }

        // declare view and pass data array
        $this->view('pages/index', $data);

        // else redirect to 404
      } else {
        header("Location: " . URLROOT . "/errors/page_not_found");
      }

    }

  }

?>