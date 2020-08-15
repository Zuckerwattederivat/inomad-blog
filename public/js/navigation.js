// ========================================
//   Navigation Scripts iNomad Travel Blog
// - Brian Boehm 2020 
// ========================================

// Prevent dropdown menu from closing when click inside the form
$(document).on("click", ".action-buttons .dropdown-menu", function (e) {
  e.stopPropagation();
});

// scroll down function
function scrollDown(destination) {
  $('html, body').animate({ scrollTop: $(destination).offset().top }, 200);
}