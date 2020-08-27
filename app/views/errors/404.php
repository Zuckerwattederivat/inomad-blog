<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/nav.php"?>

<!-- Main Section
------------------------------------->
<div class="not-found parallax">
  <div class="sky-bg"></div>
  <div class="wave-7"></div>
  <div class="wave-6"></div>
  <a class="wave-island" href="<?php echo URLROOT; ?>">
    <img src="<?php echo URLROOT; ?>/img/site/island.svg" alt="Island">
  </a>
  <div class="wave-5"></div>
  <div class="wave-lost wrp">
    <span>4</span>
    <span>0</span>
    <span>4</span>
  </div>
  <div class="wave-4"></div>
  <div class="wave-boat">
    <img class="boat" src="<?php echo URLROOT; ?>/img/site/boat.svg" alt="Boat">
  </div>
  <div class="wave-3"></div>
  <div class="wave-2"></div>
  <div class="wave-1"></div>
  <div class="wave-message row">
    <p id="wave-message-1" class="col-md-12">You're lost!</p>
    <p id="wave-message-2" class="col-md-12">Click on the island to return</p>
  </div>
</div>

<!-- 404 Javascript -->
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/404_page.js"></script>

</body>
</html>