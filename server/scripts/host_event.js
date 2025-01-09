document.addEventListener("DOMContentLoaded", () => {
    const numLocationsInput = document.getElementById("num-locations");
    const tabsContainer = document.getElementById("tabs-container");
    const locationContainer = document.getElementById("location-container");
  
    // Handle number of locations input
    numLocationsInput.addEventListener("input", function () {
      const numLocations = parseInt(this.value, 10);
  
      tabsContainer.innerHTML = "";
      locationContainer.innerHTML = "";
  
      if (isNaN(numLocations) || numLocations <= 0) {
        alert("Please enter a valid number of locations.");
        return;
      }
      for (let i = 1; i <= numLocations; i++) {
        const tab = document.createElement("div");
        tab.className = "tab";
        tab.textContent = `Location ${i}`;
        tab.dataset.location = `location${i}`;
        if (i === 1) tab.classList.add("active");
        tabsContainer.appendChild(tab);

        const locationDiv = document.createElement("div");
      locationDiv.id = `location${i}`;
      locationDiv.className = "location-details";
      if (i === 1) locationDiv.classList.add("active");

          locationDiv.innerHTML = `
              
              <label for="location-address-${i + 1}">Location Address:</label>
              <input class="host-event-input"  type="text" id="location-address-${i + 1}" name="location_address[]" placeholder="Enter the location address" required>

              <label for="location-city-${i + 1}">City:</label>
              <input class="host-event-input" type="text" id="location-city-${i + 1}" name="location_city[]" placeholder="Enter the city name" required>

              <label for="postal-code-${i + 1}">Postal Code:</label>
              <input class="host-event-input" type="text" id="postal-code-${i + 1}" name="postal_code[]" placeholder="Enter the postal code" required>

              <label for="start-date-${i + 1}">Start Date:</label>
              <input class="host-event-input" type="datetime-local" id="start-date-${i + 1}" name="start_date[]" min="2024-12-01T00:00:00" required>

              <label for="end-date-${i + 1}">End Date:</label>
              <input class="host-event-input" type="datetime-local" id="end-date-${i + 1}" name="end_date[]" min="2024-12-01T00:00:00" required>

              <label for="capacity-${i + 1}">Capacity:</label>
              <input class="host-event-input" type="number" id="capacity-${i + 1}" name="capacity[]" placeholder="Enter the capacity" min="1" required>

              <label for="price-${i + 1}">Price:</label>
              <input class="host-event-input" type="number" id="price-${i + 1}" name="price[]" placeholder="Enter the price" step="0.01" min="0" required>

              
          `;


          locationContainer.appendChild(locationDiv);

          // Add input validation for postal code
          const postalCodeInput = document.getElementById(`postal-code-${i + 1}`);
          postalCodeInput.addEventListener('input', function() {
              this.value = this.value.replace(/\D/g, '').slice(0, 5);
          });
        }
    
        setTabFunctionality();
      });

      form.addEventListener('submit', function(event) {
        const startDates = document.querySelectorAll('input[name="start_date[]"]');
        const endDates = document.querySelectorAll('input[name="end_date[]"]');
        const postalCodes = document.querySelectorAll('input[name="postal_code[]"]');

        for (let i = 0; i < startDates.length; i++) {
            const startDate = new Date(startDates[i].value);
            const endDate = new Date(endDates[i].value);
            

            if (endDate < startDate) {
                alert(`End date must be later than start date for location ${i + 1}`);
                event.preventDefault();
                return;
            }
            if (postalCodes[i].value.length !== 5) {
              alert(`Postal code must be exactly 5 digits for location ${i + 1}`);
              event.preventDefault();
              return;
          }
        }
    });
    
      function setTabFunctionality() {
        const tabs = document.querySelectorAll(".tab");
        const locations = document.querySelectorAll(".location-details");

        tabs.forEach((tab) => {
            tab.addEventListener("click", function () {
              tabs.forEach((t) => t.classList.remove("active"));
              locations.forEach((loc) => loc.classList.remove("active"));
      
              this.classList.add("active");
              const locationId = this.dataset.location;
              document.getElementById(locationId).classList.add("active");
            });
          });
        }
      });
      