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
              <input type="text" id="location-address-${i + 1}" name="location_address[]" placeholder="Enter the location address" required>

              <label for="location-city-${i + 1}">City:</label>
              <input type="text" id="location-city-${i + 1}" name="location_city[]" placeholder="Enter the city name" required>

              <label for="postal-code-${i + 1}">Postal Code:</label>
              <input type="text" id="postal-code-${i + 1}" name="postal_code[]" placeholder="Enter the postal code" required>

              <label for="start-date-${i + 1}">Start Date:</label>
              <input type="datetime-local" id="start-date-${i + 1}" name="start_date[]" required>

              <label for="end-date-${i + 1}">End Date:</label>
              <input type="datetime-local" id="end-date-${i + 1}" name="end_date[]" required>

              <label for="capacity-${i + 1}">Capacity:</label>
              <input type="number" id="capacity-${i + 1}" name="capacity[]" placeholder="Enter the capacity" required>

              <label for="price-${i + 1}">Price:</label>
              <input type="number" id="price-${i + 1}" name="price[]" placeholder="Enter the price" step="0.01" required>

              
          `;
          locationContainer.appendChild(locationDiv);
        }
    
        setTabFunctionality();
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
      