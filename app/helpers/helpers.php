<?php

  // helper functions
  // ========================================

  // sanatize function
  function sanitize_input($input1, $input2 = null, $input3 = null, $input4 = null) {

    // make connection var global
    global $connection;

    // sanitize
    $input1 = mysqli_real_escape_string($connection, $input1);
    
    if ($input2 !== null) {
      $input2 = mysqli_real_escape_string($connection, $input2);
    }

    if ($input3 !== null) {
      $input3 = mysqli_real_escape_string($connection, $input2);
    }

    if ($input4 !== null) {
      $input2 = mysqli_real_escape_string($connection, $input2);
    }

  }

  // shorten input string
  function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
      $words = preg_split('/\s/', $text);      
      $output = '';
      $i      = 0;
      while (1) {
        $length = strlen($output)+strlen($words[$i]);
        if ($length > $maxchar) {
            break;
        } 
        else {
            $output .= " " . $words[$i];
            ++$i;
        }
      }
      $output .= $end;
    } 
    else {
      $output = $text;
    }
    return $output;
  }

  // image validation
  function validateImageUpload(array $file, bool $errors, int $maxSize, string $path) {

    if (isset($file) && !$errors) {

      // if no error
      if ($file['error'] === UPLOAD_ERR_OK) {

        // check image size max 
        if ($file['size'] < 1024 * 1024 * $maxSize ) {

          // check for picture format
          if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/png') {
            
            // // explode file name at type
            // $type = explode('/', $_FILES[$index]['type'])[1];

            // move uploaded file if valid picture
            $image = move_uploaded_file($file['tmp_name'], $path . $file['name']);

            return $imagePath = $path . $file['name'];

          } else {
            return "Your Image must be of type .jpg or .png";
          }

        } else {
          return "Your image is too big.";
        }

      } else {
        return "Upload error occured. Please try again.";
      }
    } else {
      return "Please upload an image with your post.";
    }
  }

  // save paragraphs into array
  function saveParagraphsToArray($text) {
    return $paragraphs = preg_split('/\r\n|\r|\n/', $text);
  }

  // pagination ceiling
  function paginationCeil($count, $maxItems) {

    if ($count != 0) {
      return ceil($count/$maxItems);
    } else {
      return 1;
    }
  }


?>