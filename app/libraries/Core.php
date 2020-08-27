<?php
  /*
  * App Core Class
  * Creates URL & laods core controller
  * URL Format - /controller/method/params
  */
  class Core {

    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {

      // print_r($this->getUrl());
      $url = $this->getUrl();

      // Look in controllers for first value
      if ($url !== null && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

        // if exists, set as controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);

        // set Error Controller if controller doesn't exist
      } elseif ($url !== null && !file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        $this->currentController = 'Errors';
        $this->currentMethod = "page_not_found";
      }

      // Require the controller
      require_once '../app/controllers/' . $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;

      // Check for second part of url
      if (isset($url[1])) {

        // Check if method exists in controller
        if (method_exists($this->currentController, $url[1])) {

          // if exist, set as method
          $this->currentMethod = $url[1];
          // Unset 0 Index
          unset($url[1]);
        }
      }

      // Get parameters
      $this->params = $url ? array_values($url) : [];

      // Call a callback with array of params
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {

      if (isset($_GET['url'])) {

        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        return $url;
      }
    }
    
  }