<?php
  /*
  * App Errors Controller Class
  * Loads error pages
  */
  class Errors extends Controller {

    public function __construct() {
      $this->catModel = $this->model('Category');
    }

    // index loads 404 method
    public function index() {
      header('Location: ' . URLROOT . '/errors/page_not_found');
    }

    // 404 method
    public function page_not_found() {

      // create data array
      $data = [
        'type' => '404',
        'categories' => $this->catModel->getCats(),
        'h4_1' => "This Site doesn't exist..."
      ];

      // load view
      $this->view('errors/404', $data);
    }
  }
?>