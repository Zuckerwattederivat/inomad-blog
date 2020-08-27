<!--------------------------------------
  Home iNomad Travel Blog
  Brian Boehm 2020 
-------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tab Icon -->
  <link rel="shortcut icon" type="image/png" href="<?php echo URLROOT; ?>/img/site/favicon_logo.png">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css">
  <!-- Font Awesome CSS  -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/font-awesome/css/font-awesome.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/custom.css">
  <?php if (isset($data['type']) && $data['type'] === '404') : ?>
    <!-- 404 Page CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/404_page.css">
  <?php endif; ?>
  <!-- JQuery -->
  <script src="<?php echo URLROOT; ?>/js/jquery.min.js"></script>
  <!-- PopperJs -->
  <script src="<?php echo URLROOT; ?>/js/popper.min.js"></script>
  <!-- Bootstrap Core Javascript -->
  <script src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <!-- Navigation Javascript -->
  <script src="<?php echo URLROOT; ?>/js/navigation.js"></script>
  <title><?php echo SITENAME; ?></title>
</head>

<style>
  /* Dynamic Styles PHP */
  /* hero image */
  .hero-image {
    background-attachment: fixed;
    background-image: url(<?php echo URLROOT; ?>/img/site/mountains.jpeg);
  }
  /* background image */
  .bg-image {
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-image: url(<?php echo URLROOT; ?>/img/site/mountains.jpeg);
  }
</style>

<!--Body -->
<body>

<!-- Navigation
------------------------------------->
<?php require APPROOT . '/views/includes/nav.php'; ?>