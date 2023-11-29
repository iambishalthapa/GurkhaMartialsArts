

function showRegistrationModal() {
    // Display the registration modal forcefully
    document.getElementById("registration-modal").style.display = "block";
    
    // Assertively prevent default button behavior
    return false;
}

function closeRegistrationModal() {
  // Get the form element
  var registrationForm = document.getElementById("register-form");
  
  // Reset the form (clears all input fields)
  registrationForm.reset();

  // Hide the modal
  document.getElementById("registration-modal").style.display = "none";
}
document.getElementById("register-form").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the form from submitting normally

  // Get the form data
  const formData = new FormData(event.target);

  // Make a POST request to register.php
  fetch("register.php", {
    method: "POST",
    body: formData,
  })
    .then(response => response.text()) // Get the response text
    .then(message => {
      const errorMessages = document.getElementById("error-messages");
      
      // Check if the message contains "Duplicate entry"
      if (message.includes("Duplicate entry")) {
        errorMessages.textContent = "Registration successful. You can now login."; // Display custom message for duplicate entry
      } else {
        errorMessages.textContent = message; // Display the response message
      }

      // Clear the error messages after a certain time (optional)
      setTimeout(() => {
        errorMessages.textContent = "";
      }, 5000); // Clear after 5 seconds (adjust as needed)
    })
    .catch(error => {
      console.error("Error:", error);
    });
});




// Function to open the login modal
function openLoginModal() {
  const loginModal = document.getElementById('login-modal');
  loginModal.style.display = 'block';  // Set the modal to be visible
  
}

// Function to close the login modal
function closeLoginModal() {
  // Get the form element
  var loginForm = document.getElementById("login-form");
  
  // Reset the form (clears all input fields)
  loginForm.reset();

  // Hide the modal
  const loginModal = document.getElementById('login-modal');
  loginModal.style.display = 'none'; 
}

document.getElementById("login-form").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the form from submitting normally
  
  // Get the form data
  const formData = new FormData(event.target);

  // Make a POST request to login.php
  fetch("login.php", {
    method: "POST",
    body: formData,
  })
  .then(response => response.text()) // Get the response text
  .then(message => {
    // Redirect to index.php on successful login
    if (message.includes("Login successful.")) {
      window.location.href = "index.php";
    } else {
      // Display the response message in the login-error-messages div
      const loginErrorMessages = document.getElementById("login-error-messages");
      loginErrorMessages.textContent = message;
    }
  })
  .catch(error => {
    console.error("Error:", error);
  });
});

