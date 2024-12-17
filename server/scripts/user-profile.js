// Edit input fields

function toggleEdit(fieldId) {
    var field = document.getElementById(fieldId);
    field.readOnly = !field.readOnly;
      if (!field.readOnly) {
      field.focus();
      }
  }

//Event Popup Window

document.getElementById('attended-events-btn').addEventListener('click', function() {
  document.getElementById('popup-attended').style.display = 'block';
});

document.getElementById('waitListed-events-btn').addEventListener('click', function() {
  document.getElementById('popup-waitlisted').style.display = 'block';
});

document.getElementById('created-events-btn').addEventListener('click', function() {
  document.getElementById('popup-created').style.display = 'block';
});

document.querySelectorAll('.close-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
      btn.closest('.popup').style.display = 'none';
  });
});

window.addEventListener('click', function(event) {
  if (event.target.classList.contains('popup')) {
      event.target.style.display = 'none';
  }
});