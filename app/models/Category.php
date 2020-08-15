<?php
  /*
  * Category Model Class
  * Communicates with categories database
  */
  class Category {
    
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    // get all categories
    public function getCats() {
      $this->db->query("SELECT * FROM categories");
      return $this->db->resultSet();
    }

    // search categories for single exact match
    public function searchCats($dbRow, $searchParam) {
      $this->db->query("SELECT * FROM categories WHERE $dbRow = (?)");
      $this->db->bind(1, $searchParam);
      return $this->db->single();
    }

    // search categories for similar match
    public function searchCatsSimilar($dbRow, $searchParam) {
      $this->db->query("SELECT * FROM categories WHERE $dbRow LIKE (?)");
      $this->db->bind(1, "%$searchParam%");
      return $this->db->resultSet();
    }

    // add category
    public function addCat(array $data) {

      $this->db->query("INSERT INTO categories (cat_title) VALUES(:cat_title)");

      // bind value
      $this->db->bind(':cat_title', $data['cat_title']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // delete category
    public function deleteCat(array $data) {

      $this->db->query("DELETE FROM categories WHERE cat_id = :cat_id");

      // bind value
      $this->db->bind(':cat_id', $data['cat_id']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // update category
    public function updateCat(array $data) {

      $this->db->query("UPDATE categories SET cat_title = :cat_title WHERE cat_id = :cat_id");

      // bind value
      $this->db->bind(':cat_title', $data['cat_title_edit']);
      $this->db->bind(':cat_id', $data['cat_id']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
  }

?>