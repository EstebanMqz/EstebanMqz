"use strict"; // Duplicate/undeclared not allowed.

const forms = document.forms; // Get forms regardless of their tree.

// Loop through forms if any and their inputs regardless of IDs/classes through event listeners.
if (forms.length) {
  for (const form of forms) {
    const file = form.querySelector('input[type="file"]');
    file ? file.addEventListener('change', formAddFile) : null;
  }
}

// Update upload file button  
function formAddFile(e) {
  const formInputFile = e.target;
  const FormFiles = formInputFile.files;
  const fileName = FormFiles.length ? FormFiles[0].name : '';
  formInputFile.parentElement.nextElementSibling.innerHTML = fileName;
}

// Fetch API with FormData object HTTP method. 
async function formSunmitAction(e) {
  e.preventDefault();
  const form = e.target;
  const formAction = form.getAttribute('action') ? form.getAttribute('action').trim() : "#";
  const formMethod = form.getAttribute('method') ? form.getAttribute('method').trim() : "POST";
  const formData = new FormData(form);

  form.classList.add('form-sending'); // Display CSS form submission loading class.

  // Send the form data to the server using the fetch API.
  const response = await fetch(formAction, {
    method: formMethod,
    body: formData
  });

  // If form is sucessfully sent.
  if (response.ok) {
    alert('Form sent!');
    form.classList.remove('form-sending'); //Remove CSS loading class.

    const formInputFile = form.querySelector('input[type="file"]'); // File upload text button reset.
    formInputFile ? formInputFile.parentElement.nextElementSibling.innerHTML = '' : null;
    form.reset(); // Reset form.

  // If the form isn't sent.   
  } else {
    alert('Error sending data. Try again later');
    form.classList.remove('form-sending');
  }
}