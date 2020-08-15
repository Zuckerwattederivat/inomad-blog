<?php
  /*
  * User Model Class
  * Communicates with user database
  */
  class User {

    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // search users for single exact match
    public function searchUser($dbRow, $searchParam, $checkRowCount=false) {

      $this->db->query("SELECT * FROM users WHERE $dbRow = (?)");
      $this->db->bind(1, $searchParam);
      
      // if only check row count true return bool
      if ($checkRowCount === true) {
        
        $row = $this->db->single();

        // return true if match was found
        if ($this->db->rowCount() > 0) {
          return true;

          // return false if no match was found
        } else {
          return false;
        }

        // else return found object
      } else {
        return $this->db->single();
      }
    }

    // create new user
    public function createUser(array $data) {

      $this->db->query("INSERT INTO users (user_role, user_real_name, user_alias, user_email, user_password) VALUES(:user_role, :user_real_name, :user_alias, :user_email, :user_password)");
      
      // bind all values
      $this->db->bind(':user_role', $data['role']);
      $this->db->bind(':user_real_name', $data['name']);
      $this->db->bind(':user_alias', $data['username']);
      $this->db->bind(':user_email', $data['email']);
      $this->db->bind(':user_password', $data['password']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // log in user
    public function loginUser($email, $password) {

      $this->db->query("SELECT * FROM users WHERE user_email = (?)");
      $this->db->bind(1, $email);

      $row = $this->db->single();
      $hashedPassword = $row->user_password;

      // verify password
      if (password_verify($password, $hashedPassword)) {
        return $row;
      } else {
        return false;
      }
    }

    // update user data
    public function updateUserInfo(array $data, bool $updatePassword=false, bool $updateImage=false) {
      
      // update data 
      if ($updatePassword === false && $updateImage === false) {

        $this->db->query(
          "UPDATE users
          SET user_real_name = :user_real_name, user_alias = :user_alias, user_email = :user_email, user_bio = :user_bio
          WHERE user_id = :user_id"
        );

        // bind values
        $this->db->bind(':user_id', $data['user']->user_id);
        $this->db->bind(':user_real_name', $data['name']);
        $this->db->bind(':user_alias', $data['username']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_bio', $data['user_bio']);

        // execute and return confirmation
        if ($this->db->execute()) {
          return true;
        } else {
          return false;
        }

      } elseif ($updatePassword === false) {

        $this->db->query(
          "UPDATE users
          SET user_real_name = :user_real_name, user_alias = :user_alias, user_email = :user_email, user_bio = :user_bio, user_image = :user_image
          WHERE user_id = :user_id"
        );

        // bind values
        $this->db->bind(':user_id', $data['user']->user_id);
        $this->db->bind(':user_real_name', $data['name']);
        $this->db->bind(':user_alias', $data['username']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_bio', $data['user_bio']);
        $this->db->bind(':user_image', $data['user_image']['name']);

        // execute and return confirmation
        if ($this->db->execute()) {
          return true;
        } else {
          return false;
        }

      } elseif ($updateImage === false) {

        $this->db->query(
          "UPDATE users
          SET user_real_name = :user_real_name, user_alias = :user_alias, user_email = :user_email, user_bio = :user_bio, user_password = :user_password
          WHERE user_id = :user_id"
        );

        // bind values
        $this->db->bind(':user_id', $data['user']->user_id);
        $this->db->bind(':user_real_name', $data['name']);
        $this->db->bind(':user_alias', $data['username']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_bio', $data['user_bio']);
        $this->db->bind(':user_password', $data['password']);

        // execute and return confirmation
        if ($this->db->execute()) {
          return true;
        } else {
          return false;
        }

      } else {

        $this->db->query(
          "UPDATE users
          SET user_real_name = :user_real_name, user_alias = :user_alias, user_email = :user_email, user_bio = :user_bio, user_password = :user_password, user_image = :user_image
          WHERE user_id = :user_id"
        );

        // bind values
        $this->db->bind(':user_id', $data['user']->user_id);
        $this->db->bind(':user_real_name', $data['name']);
        $this->db->bind(':user_alias', $data['username']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':user_bio', $data['user_bio']);
        $this->db->bind(':user_password', $data['password']);
        $this->db->bind(':user_image', $data['user_image']['name']);

        // execute and return confirmation
        if ($this->db->execute()) {
          return true;
        } else {
          return false;
        }
      }
    }

    // get all users
    public function getUsers() {

      $this->db->query("SELECT * FROM users");

      return $this->db->resultSet();
    }

    // update privileges
    public function updateRights($user_id, $user_role) {

      $this->db->query("UPDATE users SET user_role = :user_role WHERE user_id = :user_id");

      // bind values
      $this->db->bind(':user_role', $user_role);
      $this->db->bind(':user_id', $user_id);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // delete user
    public function deleteUser($user_id) {

      $this->db->query("DELETE FROM users WHERE user_id = :user_id");

      // bind value
      $this->db->bind(':user_id', $user_id);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
  }
?>