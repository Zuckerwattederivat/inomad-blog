/*
  * Upload Input Controls
  * Makes inout for uploads more user-friendly
*/

// display filename
document.querySelector('.custom-file-input').addEventListener('change', (e) => {

  let fileName = document.querySelector('.custom-file-input').files[0].name;
  //console.log(fileName);
  document.querySelector('.custom-file-input').nextElementSibling.innerHTML = fileName;
});

// 