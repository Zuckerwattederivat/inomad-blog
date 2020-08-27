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
    <p class="col-md-12">You're lost</p>
    <p class="col-md-12">Click on the island to return</p>
  </div>
</div>

<script>
  var parallax = function(e) {
    var windowWidth = $(window).width();
    if (windowWidth < 768) return;
    var halfFieldWidth = $(".parallax").width() / 2,
      halfFieldHeight = $(".parallax").height() / 2,
      fieldPos = $(".parallax").offset(),
      x = e.pageX,
      y = e.pageY - fieldPos.top,
      newX = (x - halfFieldWidth) / 30,
      newY = (y - halfFieldHeight) / 30;
    $('.parallax [class*="wave"]').each(function(index) {
      $(this).css({
        transition: "",
        transform:
          "translate3d(" + index * newX + "px," + index * newY + "px,0px)"
      });
    });
  },
  stopParallax = function() {
    $('.parallax [class*="wave"]').css({
      transform: "translate(0px,0px)",
      transition: "all .7s"
    });
    
  };
$(document).ready(function() {
  $(".not-found").on("mousemove", parallax);
  $(".not-found").on("mouseleave", stopParallax);
});

</script>

</body>
</html>