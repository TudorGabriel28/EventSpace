// Store original data for canceling edits
let originalData = {};

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Show sections with animation
    showSections();
    // Set up navigation
    setupNavigation();
    // Set up image preview
    setupImagePreviews();
});

// Function to handle section visibility animations
function showSections() {
    const sections = document.querySelectorAll('.section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    sections.forEach(section => observer.observe(section));
}

// Function to set up navigation highlighting
function setupNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');

    // Highlight active section on scroll
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (window.pageYOffset >= sectionTop - 200) {
                current = '#' + section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === current) {
                link.classList.add('active');
            }
        });
    });

    // Smooth scroll to section
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            targetSection.scrollIntoView({ behavior: 'smooth' });
        });
    });
}

// Function to set up image previews
function setupImagePreviews() {
    const images = document.querySelectorAll('.event-image');
    images.forEach(img => {
        img.addEventListener('click', () => {
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '9999';

            const modalImg = document.createElement('img');
            modalImg.src = img.src;
            modalImg.style.maxWidth = '90%';
            modalImg.style.maxHeight = '90%';
            modalImg.style.objectFit = 'contain';
            modalImg.style.borderRadius = '8px';

            modal.appendChild(modalImg);
            document.body.appendChild(modal);

            modal.addEventListener('click', () => {
                modal.remove();
            });
        });
    });
}

// Function to show loading overlay
function showLoading() {
    document.querySelector('.loading-overlay').style.display = 'flex';
}

// Function to hide loading overlay
function hideLoading() {
    document.querySelector('.loading-overlay').style.display = 'none';
}

// Function to show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    let color = '#28a745'; // Default green for success/approve
    
    // Change color based on action type
    if (type === 'error' || type === 'reject' || type === 'delete') {
        color = '#dc3545'; // Red for error, reject, or delete
    }

    toast.style.backgroundColor = color;
    toast.style.display = 'block';
    
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

// Function to edit row
function editRow(btn) {
    const row = btn.parentElement.parentElement;
    originalData[row] = [...row.cells].map(cell => cell.innerText);

    [...row.cells].forEach((cell, index) => {
        if (index > 0 && index < row.cells.length - 1) {
            cell.contentEditable = "true";
            cell.style.border = "1px solid #007bff";
            cell.style.backgroundColor = "#e7f3ff";
        }
    });
    toggleButtons(btn, true);
}

// Function to approve event
function approveEvent(eventId) {
    if (confirm("Are you sure you want to approve this event?")) {
        showLoading();
        fetch("../controllers/api/approve_event.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: eventId, action: 'approve' }),
        })
        .then(response => response.json())
        .then(response => {
            if (response.status === "success") {
                showToast("Event approved successfully!");
                setTimeout(() => {
                    location.reload();
                }, 3000); // Reload page after 3 seconds
            } else {
                showToast("Error approving event", "error");
            }
        })
        .catch(error => {
            showToast("Error: " + error.message, "error");
        })
        .finally(() => {
            hideLoading();
        });
    }
}

// Function to reject event
function rejectEvent(eventId) {
    if (confirm("Are you sure you want to reject this event?")) {
        showLoading();
        fetch("../controllers/api/approve_event.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: eventId, action: 'reject' }),
        })
        .then(response => response.json())
        .then(response => {
            if (response.status === "success") {
                showToast("Event rejected successfully!", "reject");                
                setTimeout(() => {
                    location.reload();
                }, 3000); // Reload page after 3 seconds
            } else {
                showToast("Error rejecting event", "error");
            }
        })
        .catch(error => {
            showToast("Error: " + error.message, "error");
        })
        .finally(() => {
            hideLoading();
        });
    }
}

// Function to save row
function saveRow(btn, type) {
    const row = btn.parentElement.parentElement;
    const data = [...row.cells].slice(1, -1).map(cell => cell.innerText);
    const id = row.cells[0].innerText;

    const updateData = type === "user"
        ? { firstName: data[0], lastName: data[1], email: data[2] }
        : type === "event"
            ? { name: data[0], description: data[1] }
            : { title: data[0], question: data[1] };

    showLoading();
    fetch("../controllers/api/edit.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type, id, data: updateData }),
    })
    .then(response => response.json())
    .then(response => {
        if (response.status === "success") {
            showToast("Data updated successfully!");

            [...row.cells].forEach((cell, index) => {
                if (index > 0 && index < row.cells.length - 1) {
                    cell.contentEditable = "false";
                    cell.style.border = "none";
                    cell.style.backgroundColor = "transparent";
                }
            });

            toggleButtons(btn, false);
        } else {
            showToast("Error updating data", "error");
        }
    })
    .catch(error => {
        showToast("Error: " + error.message, "error");
    })
    .finally(() => {
        hideLoading();
    });
}

// Function to confirm and handle deletion
function confirmDelete(id, type) {
    if (confirm("Are you sure you want to delete this record?")) {
        showLoading();
        fetch("../controllers/api/delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ type, id }),
        })
        .then(response => response.json())
        .then(response => {
            if (response.status === "success") {
                showToast("Record deleted successfully!", "delete");                
                setTimeout(() => {
                    location.reload();
                }, 3000); // Reload page after 3 seconds
            } else {
                showToast("Error deleting record", "error");
            }
        })
        .catch(error => {
            showToast("Error: " + error.message, "error");
        })
        .finally(() => {
            hideLoading();
        });
    }
}

// Function to cancel edit
function cancelEdit(btn) {
    const row = btn.parentElement.parentElement;
    [...row.cells].forEach((cell, index) => {
        if (index > 0 && index < row.cells.length - 1) {
            cell.innerText = originalData[row][index];
            cell.contentEditable = "false";
            cell.style.border = "none";
            cell.style.backgroundColor = "transparent";
        }
    });
    toggleButtons(btn, false);
    showToast("Edit cancelled");
}

// Function to toggle button visibility
function toggleButtons(btn, isEditing) {
    const buttons = btn.parentElement.children;
    buttons[0].style.display = isEditing ? "none" : "inline";
    buttons[1].style.display = isEditing ? "inline" : "none";
    buttons[2].style.display = isEditing ? "inline" : "none";
}