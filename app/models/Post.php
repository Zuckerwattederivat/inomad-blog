<?php
  /*
  * Post Model Class
  * Communicates with posts database
  */
  class Post {
    
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    // get all posts ordered by date
    public function getPosts() {
      $this->db->query(
        "SELECT * FROM posts
        INNER JOIN users on post_user_id = user_id 
        INNER JOIN categories on cat_id = post_category_id
        ORDER BY post_date DESC"
      );
      return $this->db->resultSet();
    }

    // get three random posts
    public function getThreeRandPosts() {
      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        ORDER BY RAND() DESC LIMIT 3"
      );
      return $this->db->resultSet();
    }

    // get three newest posts
    public function getThreeNewPosts() {
      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        ORDER BY post_date DESC LIMIT 3"
      );
      return $this->db->resultSet();
    }

    // get posts limit dynamic
    public function getPostsLimit($lower_limit, $upper_limit) {

      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        ORDER BY post_date DESC LIMIT :lower_limit, :upper_limit"
      );
      $this->db->bind(':lower_limit', $lower_limit);
      $this->db->bind(':upper_limit', $upper_limit);
      return $this->db->resultSet();
    }

    // search posts by category
    public function searchPostsByCat($searchParam1, $searchParam2) {
      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        WHERE post_category_id = :search1
        OR post_tags LIKE :search2
        ORDER BY post_date DESC"
      );
      $this->db->bind(':search1', $searchParam1);
      $this->db->bind(':search2',  "%$searchParam2%");
      return $this->db->resultSet();
    }

    // search posts by category limit
    public function searchPostsByCatLimit($searchParam1, $searchParam2, $limit1, $limit2) {
      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        WHERE post_category_id = :search1
        OR post_tags LIKE :search2
        ORDER BY post_date DESC LIMIT :lower_limit, :upper_limit"
      );
      $this->db->bind(':search1', $searchParam1);
      $this->db->bind(':search2',  "%$searchParam2%");
      $this->db->bind(':lower_limit',  $limit1);
      $this->db->bind(':upper_limit',  $limit2);
      return $this->db->resultSet();
    }

    // search posts for similar match ordered by date
    public function searchPostsSimilar($dbRow, $searchParam) {
      $this->db->query(
        "SELECT * FROM posts
        INNER JOIN users
        ON post_user_id = user_id
        WHERE $dbRow LIKE :search
        ORDER BY post_date DESC"
      );
      $this->db->bind(':search', "%$searchParam%");
      return $this->db->resultSet();
    }

    // search posts for similar match ordered by date limit
    public function searchPostsSimilarLimit($dbRow, $searchParam, $limit) {
      $this->db->query(
        "SELECT * FROM posts
        INNER JOIN users
        ON post_user_id = user_id
        WHERE $dbRow LIKE :search
        ORDER BY post_date DESC LIMIT :lower_limit, 10"
      );
      $this->db->bind(':search', "%$searchParam%");
      $this->db->bind(':lower_limit', $limit);
      return $this->db->resultSet();
    }

    // search posts by post_id
    public function searchPostByPostId($searchParam1) {
      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users 
        ON post_user_id = user_id
        WHERE post_id = :search"
      );
      $this->db->bind(':search', $searchParam1);
      return $this->db->single();
    }

    // get latest posts by user id
    public function getPostsbyUser($searchParam, $limit=false) {
      
      if ($limit === false) {
        $this->db->query(
          "SELECT * FROM posts
          INNER JOIN users ON post_user_id = user_id 
          WHERE post_user_id = $searchParam
          ORDER BY post_date DESC"
        );
        return $this->db->resultSet();

      } else {
        $this->db->query(
          "SELECT * FROM posts
          INNER JOIN users ON post_user_id = user_id 
          WHERE post_user_id = $searchParam
          ORDER BY post_date DESC LIMIT 3"
        );
        return $this->db->resultSet();
      }
    }

    // get posts by user limit dynamic 
    public function getPostsbyUserLimit($searchParam, $lower_limit, $upper_limit) {

      $this->db->query(
        "SELECT * FROM posts 
        INNER JOIN users ON post_user_id = user_id
        WHERE post_user_id = $searchParam
        ORDER BY post_date DESC LIMIT $lower_limit, $upper_limit"
      );
      
      $result = $this->db->resultSet();

      if ($this->db->rowCount() > 0) {
        return $result;
      } else {
        return false;
      }
    }

    // create post
    public function createPost(array $data) {

      $this->db->query(
        "INSERT INTO posts (post_user_id, post_category_id, post_title, post_image, post_content, post_tags) 
        VALUES(:post_user_id, :post_category_id, :post_title, :post_image, :post_content, :post_tags)"
      );
      
      // bind all values
      $this->db->bind(':post_user_id', $data['post_user_id']);
      $this->db->bind(':post_category_id', $data['post_category_id']);
      $this->db->bind(':post_title', $data['post_title']);
      $this->db->bind(':post_image', $data['post_image']['name']);
      $this->db->bind(':post_content', $data['post_content']);
      $this->db->bind(':post_tags', $data['post_tags']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // delete post
    public function deletePost($post_id) {

      $this->db->query("DELETE FROM posts WHERE post_id = :post_id");

      // bind values
      $this->db->bind(':post_id', $post_id);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // edit post
    public function editPost(array $data) {

      $this->db->query(
        "UPDATE posts
        SET post_user_id = :post_user_id, post_category_id = :post_category_id, post_title = :post_title, 
        post_image = :post_image, post_content = :post_content, post_tags = :post_tags
        WHERE post_id = :post_id"
      );

      // bind all values
      $this->db->bind(':post_id', $data['edit_post']->post_id);
      $this->db->bind(':post_user_id', $data['post_user_id']);
      $this->db->bind(':post_category_id', $data['post_category_id']);
      $this->db->bind(':post_title', $data['post_title']);
      $this->db->bind(':post_image', $data['post_image']['name']);
      $this->db->bind(':post_content', $data['post_content']);
      $this->db->bind(':post_tags', $data['post_tags']);

      // execute and return confirmation
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

  }
?>