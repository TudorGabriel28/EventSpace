function toggleEdit(fieldId) {
  var field = document.getElementById(fieldId);
  field.disabled = !field.disabled;
}
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

//Event Popup Window

document.getElementById('attended-events-btn').addEventListener('click', function() {
  document.getElementById('popup-attended').style.display = 'block';
});

document.getElementById('subscribed-events-btn').addEventListener('click', function() {
  document.getElementById('popup-subscribed').style.display = 'block';
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