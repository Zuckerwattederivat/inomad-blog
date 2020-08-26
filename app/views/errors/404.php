<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<section class="container-fluid sec-main without-hero">
  <div class="container">
    <div id="not-found-container" class="container-fluid d-flex flex-column justify-content-center">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-center">
            <img class="img-wide" src="<?php echo URLROOT.'/img/site/404_error.jpg'; ?>" alt="404 Error">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 d-flex justify-content-center">
            <h4><?php echo $data['h4_1']; ?></h4>
          </div>
        </div>
      </div>
  </div>
</section>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/footer_without_hero.php"?>