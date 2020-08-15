<?php
  /*
  * Start Session
  */
  session_start();

  // flash message function
  // EXAMPLE - flash('register_success', 'You are not registered', 'alert alert-danger);
  // DISPLAY IN VIEW echo flash('register_success');
  function flash($name='', $message='', $class='alert alert-success') {

    if (!empty($name)) {
      
      // if message exists but is not set in the session
      if(!empty($message) && empty($_SESSION[$name])) {

        // unset session name if it exists
        if (!empty($_SESSION[$name])) {
          unset($_SESSION[$name]);
        }
        // unset session class if it exists
        if (!empty($_SESSION[$name . '_class'])) {
          unset($_SESSION[$name . '_class']);
        }
        // reset session name and class
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;

        // if message doesn't exist but session isn"t set
      } elseif (empty($message) && !empty($_SESSION[$name])) {
        
        // set class conditional
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        
        // echo message
        echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';

        // unset session
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  // is logged in method
  function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }

  // is admin
  function isAdmin() {
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin') {
      return true;
    } else {
      return false;
    }
  }

?>