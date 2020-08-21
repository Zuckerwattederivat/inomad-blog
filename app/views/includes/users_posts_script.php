<script>
  (function() {
    // data vars
    let lower_limit = 0;
    let upper_limit = 8;
    let reachedMax = false;
    let processing = false;
    let user_id = <?php echo $data['user']->user_id; ?>
    // buttons
    let editButton = document.querySelector('.btn-start-edit');
    let btnEdit = document.querySelectorAll('.btn-edit');
    let btnContainer = document.querySelectorAll('.btn-div');
    let btnDelete = document.querySelectorAll('.btn-delete');

    $(document).ready(function() {
      getData();
    })

    $(window).scroll(function() {

      // return if processing is true
      if (processing) {
        return false;
      } 
      
      // if breakpoint was reached fire new ajax request and set processing to true
      if ($(window).scrollTop() >= $(document).height() - $(window).height() - 400) {
        processing = true;
        getData();
      }

      //console.log(lower_limit);
      
      // update vars while scrolling
      editButton = document.querySelector('.btn-start-edit');
      btnEdit = document.querySelectorAll('.btn-edit');
      btnContainer = document.querySelectorAll('.btn-div');
      btnDelete = document.querySelectorAll('.btn-delete');

      // add open class to all element conatiners if edit is open
      btnContainer.forEach(element => {
      
        if (element.classList.contains('open-btn-cont')) {
          
          btnContainer.forEach(element => {
            element.classList.add('open-btn-cont');
          });

          btnEdit.forEach(element => {
            element.classList.add('show-btn');
          });

          btnDelete.forEach(element => {
            element.classList.add('show-btn');
          });
        }
      });
    });

    function getData() {
      if (reachedMax) {
        return;
      } else {
        $.ajax({
          url: '<?php echo URLROOT;?>/ajax/loadPostsUser',
          method: 'POST',
          datatype: 'text',
          data: {
            getData: 1,
            lower_limit: lower_limit,
            upper_limit: upper_limit,
            user_id: user_id
          },
          success: function(response) {
            lower_limit += upper_limit;

            if (response != false) {
              $('.posts-ajax').append(response);
              processing = false;
            } else {
              reachedMax = true;
            }
          }
        });
      }
    }

    // open edit menu
    editButton.addEventListener('click', () => {

      // update vars
      btnEdit = document.querySelectorAll('.btn-edit');
      btnContainer = document.querySelectorAll('.btn-div');
      btnDelete = document.querySelectorAll('.btn-delete');

      btnContainer.forEach(element => {
        element.classList.toggle('open-btn-cont');
      });

      btnEdit.forEach(element => {
        element.classList.toggle('show-btn');
      });

      btnDelete.forEach(element => {
        element.classList.toggle('show-btn');
      });
      
    });
    
  })();
</script>