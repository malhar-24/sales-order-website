document.getElementById('otpSubmitButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var otp = document.getElementById('otp').value;

    // Send an AJAX request to validate the OTP
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'validate_otp.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === 'success') {
                // Hide the OTP box
                document.getElementById('otpBox').style.display = 'none';

                // Show the div to set a new password
                document.getElementById('newPasswordBox').style.display = 'block';
            } else {
                // Handle invalid OTP
                alert('Invalid OTP. Please try again.');
            }
        }
    };
    xhr.send('otp=' + encodeURIComponent(otp));
});



document.getElementById('forgotPasswordButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var username = document.getElementById('forgotUsername').value;

    // Send an AJAX request to validate the username
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'validate_username.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === 'success') {
                // Hide the forgot password box
                document.getElementById('forgotPasswordBox').style.display = 'none';

                // Show the OTP box
                document.getElementById('otpBox').style.display = 'block';
            } else {
                // Handle invalid username
                alert('Invalid username. Please try again.');
            }
        }
    };
    xhr.send('forgotUsername=' + encodeURIComponent(username));
});



document.getElementById('closeOTPBox').addEventListener('click', function() {
    // Hide the OTP box
    document.getElementById('otpBox').style.display = 'none';
});





// your-script.js

document.getElementById('login').addEventListener('click', function() {
    document.getElementById('loginBox').style.display = 'block';
});

document.getElementById('register').addEventListener('click', function() {
    document.getElementById('registerBox').style.display = 'block';
});

document.getElementById('closeLoginBox').addEventListener('click', function() {
    document.getElementById('loginBox').style.display = 'none';
});

document.getElementById('closeRegisterBox').addEventListener('click', function() {
    document.getElementById('registerBox').style.display = 'none';
});

document.getElementById('registerLink').addEventListener('click', function() {
    document.getElementById('loginBox').style.display = 'none';
    document.getElementById('registerBox').style.display = 'block';
});

document.getElementById('forgotpasswordlink').addEventListener('click', function () {
    document.getElementById('loginBox').style.display = 'none'; // Hide the login box
    document.getElementById('forgotPasswordBox').style.display = 'block'; // Show the forgot password box
});
document.getElementById('closeForgotPasswordBox').addEventListener('click', function() {
    document.getElementById('forgotPasswordBox').style.display = 'none';
});


// your-script.js

// Function to show/hide name fields based on registration type
function updateNameFieldsVisibility(registerAs) {
    var companyNameFields = document.getElementById('companyNameFields');
    var companyNameLabel = document.getElementById('companyNameLabel');
    var companyNameInput = document.getElementById('companyName');
    var salespersonNameFields = document.getElementById('salespersonNameFields');
    var firstNameLabel = document.getElementById('firstNameLabel');
    var firstNameInput = document.getElementById('firstName');
    var lastNameLabel = document.getElementById('lastNameLabel');
    var lastNameInput = document.getElementById('lastName');

    if (registerAs === 'salesperson') {
        // Show First Name and Last Name fields for Salesperson, hide Company Name
        companyNameFields.style.display = 'none';
        firstNameLabel.style.display = 'block';
        firstNameInput.style.display = 'block';
        lastNameLabel.style.display = 'block';
        lastNameInput.style.display = 'block';
        salespersonNameFields.style.display = 'block';
    } else {
        // Show Company Name, hide First Name and Last Name fields for Company
        companyNameFields.style.display = 'block';
        firstNameLabel.style.display = 'none';
        firstNameInput.style.display = 'none';
        lastNameLabel.style.display = 'none';
        lastNameInput.style.display = 'none';
        salespersonNameFields.style.display = 'none';
    }
    
}

// Set default registration type to "salesperson"
document.getElementById('registerAs').value = 'salesperson';
updateNameFieldsVisibility('salesperson');

// Event listener for changes in registration type
document.getElementById('registerAs').addEventListener('change', function () {
    var registerAs = this.value;
    updateNameFieldsVisibility(registerAs);
});




document.addEventListener("DOMContentLoaded", function () {
    // Existing code...

    var registerButton = document.getElementById("registerButton");
    var loginBox = document.getElementById("loginBox");
    var registerBox = document.getElementById("registerBox");
    var registrationForm = document.getElementById("registrationForm");

    registerButton.addEventListener("click", function (event) {
        // Your existing form validation logic...

        // Assuming the form is valid, handle the registration via AJAX
        var formData = new FormData(registrationForm);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "register.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from login.php
                console.log(xhr.responseText);
            }
        };

        xhr.send(formData);

        // Prevent the default form submission
        event.preventDefault();
    });
});



document.addEventListener("DOMContentLoaded", function () {
    var loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get username and password values
        var username = document.getElementById('username1').value;
        var password = document.getElementById('password1').value;

        // Create FormData object
        var formData = new FormData();
        formData.append('username1', username);
        formData.append('password1', password);

        // AJAX request to login.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the response
                var userType = xhr.responseText;
                
                if (userType === "company") {
                    // Redirect to company folder index.html
                    window.location.href = "../company/index.html";
                } else if (userType === "salesperson") {
                    // Redirect to salesperson folder index.html
                    window.location.href = "../sperson/index.html";
                } else {
                    // Display the error message
                    alert("Invalid username or password");
                }
            }
        };

        // Send the request with FormData
        xhr.send(formData);
    });
});




