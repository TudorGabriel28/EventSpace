document.addEventListener('DOMContentLoaded', function() {
  const numLocationsInput = document.getElementById('num-locations');
  const locationContainer = document.getElementById('location-container');

  numLocationsInput.addEventListener('change', function() {
      const numLocations = parseInt(numLocationsInput.value);
      locationContainer.innerHTML = ''; // Clear existing location inputs

      for (let i = 0; i < numLocations; i++) {
          const locationDiv = document.createElement('div');
          locationDiv.classList.add('location');

          locationDiv.innerHTML = `
              <label for="location-name-${i + 1}">Location Name:</label>
              <input type="text" id="location-name-${i + 1}" name="location_name[]" placeholder="Enter the location name" required>

              <label for="location-address-${i + 1}">Location Address:</label>
              <input type="text" id="location-address-${i + 1}" name="location_address[]" placeholder="Enter the location address" required>

              <label for="start-date-${i + 1}">Start Date:</label>
              <input type="datetime-local" id="start-date-${i + 1}" name="start_date[]" required>

              <label for="end-date-${i + 1}">End Date:</label>
              <input type="datetime-local" id="end-date-${i + 1}" name="end_date[]" required>

              <label for="capacity-${i + 1}">Capacity:</label>
              <input type="number" id="capacity-${i + 1}" name="capacity[]" placeholder="Enter the capacity" required>

              <label for="price-${i + 1}">Price:</label>
              <input type="number" id="price-${i + 1}" name="price[]" placeholder="Enter the price" step="0.01" required>

              <label for="postal-code-${i + 1}">Postal Code:</label>
              <input type="text" id="postal-code-${i + 1}" name="postal_code[]" placeholder="Enter the postal code" required>
          `;

          locationContainer.appendChild(locationDiv);
      }
  });
});