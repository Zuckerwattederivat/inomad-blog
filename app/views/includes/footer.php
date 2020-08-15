<footer class="section footer-classic context-dark bg-dark-custom">
  <div class="container">
    <div class="row row-30">
      <div class="col-md-4 col-xl-5">
        <div class="pr-xl-4">
          <a class="brand" href="<?php echo URLROOT; ?>"><img class="brand-logo-light" src="img/site/2020-02-02_logo_design_white.svg" alt="logo" width="140" srcset="<?php echo URLROOT; ?>/img/site/2020-02-02_logo_design_white.svg"></a>
          <p><br><?php echo SITEDESCRIPTION; ?></p>
          <!-- Rights-->
          <p class="rights"><span>©  </span><span class="copyright-year">2020</span><span> </span><span>iNomad</span><span>. </span><span>All Rights Reserved.</span></p>
          <p class="version">Version <?php echo APPVERSION; ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <h5>Contact</h5>
        <dl class="contact-list">
          <dt>Address:</dt>
          <dd class="text-light"><?php echo ADRESS['street']; ?></dd>
          <dd class="text-light"><?php echo ADRESS['zip_and_city']; ?></dd>
          <dd class="text-light"><?php echo ADRESS['country']; ?></dd>
        </dl>
        <dl class="contact-list">
          <dt>email:</dt>
          <dd><a href="mailto:#"><?php echo YOURMAIL; ?></a></dd>
        </dl>
      </div>
      <div class="col-md-4 col-xl-3">
        <h5>Links</h5>
        <ul class="nav-list">
          <li><a href="<?php echo URLROOT; ?>">Home</a></li>
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "admin") : ?>
            <li><a href="<?php echo URLROOT; ?>/admin">Admin Panel</a></li>
          <?php endif; ?>
          <li>Categories:</li>
          <?php foreach ($data['categories'] as $category) : ?>
            <li><a href='<?php echo URLROOT.'/posts/category/'.$category->cat_id; ?>'><?php echo $category->cat_title ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</footer>
</body>
</html>