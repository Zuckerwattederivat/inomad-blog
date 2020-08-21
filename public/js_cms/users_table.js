(function () {

  // render users table with datatables plugin
  $(document).ready(function () {
    $('#users-table').DataTable();
  })

  // fetch edit Buttons and invoke openEditFields function
  let editButtons = document.querySelectorAll('.btn-edit-user');
  toggleEditFields(editButtons);
  // fetch close buttons
  let closeButtons = document.querySelectorAll('.btn-close-edit');
  toggleEditFields(closeButtons);
  // fetch submit buttons
  let submitButtons = document.querySelectorAll('.btn-submit-edit');
  // fetch all inputs
  let allInputs = document.querySelectorAll('.edit-input');
  // fetch all labels
  let allLabels = document.querySelectorAll('.edit-label');
  // fetch all content divs
  let allContentDivs = document.querySelectorAll('.content-field');

  // open edit
  function toggleEditFields(buttons) {
    buttons.forEach(element => {
      element.addEventListener('click', () => {

        // get user id
        let userId = element.getAttribute('data-user_id');
        // get input fields
        let inputFields = document.querySelectorAll(`.input-${userId}`);
        // remove user id inout from inputFields
        let inputFieldsNew = Array.from(inputFields);
        inputFieldsNew = inputFieldsNew.slice(1, inputFieldsNew.length);
        // get labels
        let labels = document.querySelectorAll(`.label-${userId}`);
        // get content fields
        let contentFields = document.querySelectorAll(`.content-${userId}`);
        // get submit button
        let submitButton = document.querySelector(`.btn-submit-edit-${userId}`);
        // get close button
        let closeButton = document.querySelector(`.btn-close-edit-${userId}`);
        // get edit button
        let editButton = document.querySelector(`.btn-edit-${userId}`);

        // if element is edit button
        if (element === editButton) {

          // -- deactivate active edit row -- //
          // remove name attributes and add hidden class to inputs
          allInputs.forEach(element => {
            element.setAttribute('name', '');
            element.classList.add('hidden');
          });
          // add hidden class to labels
          allLabels.forEach(element => {
            element.classList.add('hidden');
          });
          // remove hidden from content
          allContentDivs.forEach(element => {
            element.classList.remove('hidden');
          });
          // add hidden to close buttons
          closeButtons.forEach(element => {
            element.classList.add('hidden');
          });
          // add hidden to submit buttons 
          submitButtons.forEach(element => {
            element.classList.add('hidden');
          });
          // remove hidden from edit buttons
          editButtons.forEach(element => {
            element.classList.remove('hidden');
          });

          // -- activate new edit row -- //
          // hide edit button
          element.classList.add('hidden');
          // show submit, close buttons
          submitButton.classList.remove('hidden');
          closeButton.classList.remove('hidden');
          // hide content
          contentFields.forEach(element => {
            element.classList.add('hidden');
          });
          // show input fields, labels
          inputFieldsNew.forEach(element => {
            element.classList.remove('hidden');
          });
          labels.forEach(element => {
            element.classList.remove('hidden');
          });

          // reset name attributes
          inputFields[0].setAttribute('name', 'user_id');
          inputFields[1].setAttribute('name', 'user_role');
          inputFields[2].setAttribute('name', 'username');
          inputFields[3].setAttribute('name', 'name');
          inputFields[4].setAttribute('name', 'email');
          inputFields[5].setAttribute('name', 'password');
          inputFields[6].setAttribute('name', 'password_confirm');
          inputFields[7].setAttribute('name', 'user_bio');
          inputFields[8].setAttribute('name', 'user_image');

          // if element is close button
        } else {

          // remove close button
          element.classList.add('hidden');
          // remove submit 
          submitButton.classList.add('hidden');
          // show input fields, labels
          inputFieldsNew.forEach(element => {
            element.classList.add('hidden');
          });
          labels.forEach(element => {
            element.classList.add('hidden');
          });
          // show edit button
          editButton.classList.remove('hidden');
          // hide content
          contentFields.forEach(element => {
            element.classList.remove('hidden');
          });
        }
      });
    });
  }

})();