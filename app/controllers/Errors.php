<?php
  /*
  * App Errors Controller Class
  * Loads error pages
  */
  class Errors extends Controller {

    public function __construct() {
      $this->catModel = $this->model('Category');
    }

    // index method
    public function index() {
      // redirect to 404
      header("Location: " . URLROOT . "/errors/page_not_found");
    }
    
    // 404 method
    public function page_not_found() {

      // create data array
      $data = [
        'categories' => $this->catModel->getCats(),
        'h4_1' => "This Site doesn't exist..."
      ];

      // load view
      $this->view('errors/404', $data);
    }
  }
?>