<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcomfyLead</title>
    <link rel="stylesheet" href="index.css">
</head>
<header>
    <img src="assets/EcomfyLogo.png" class="logo">
    <button class="boton openFormButton">Click to Sign Up</button>
</header>
<body>
    <div class="popupContainer" id="popupFormContainer" style="display: none;">
        <button id="closeButton" class="close">x</button>
        <form id="popupForm">
            <!-- Your form fields here -->
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name">

            <label for="email">Email:*</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:*</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country">

            <label for="platform">Which platform do you use? (TT, FB, SMS, Google...):</label>
            <input type="text" id="platform" name="platform">

            <label for="verticals">Which verticals do you run?:</label>
            <input type="text" id="verticals" name="verticals">

            <label for="revenue">How much revenue per month do you make?</label>
            <input type="text" id="revenue" name="revenue">

            <button id="continue" type="button" class="submit">Continue</button>
            <button id="submitting-form" hidden type="submit" class="submit"></button>
        </form>
    </div>
    <div class="popupContainer" id="popupNumberVerification" style="display: none;">
        <button id="closeButton-verification" class="close">x</button>
        <div id="popupVerification">
            <!-- Your form fields here -->
            <label for="verification" class="verify">Verification Code:</label>
            <input type="text" id="verification" name="verification" required>

            <button id="submit-everything" type="submit" class="submit">Submit</button>
        </div>
    </div>
    <div class="container">
        <div class="info">
            <h3>
                <span>EcomfyLead:</span>Unleash de Full Potential of your <span>Afilliate Traffic</span>
            </h3>
            <h4>Tired of Being "Held Back" by Your Network?</h4>
            <p>You're not alone. We've heard countless affiliate horror stories, tales of frustration, and setbacks from individuals just like you who have been let down by their networks. Experiences such as:</p>
            <ul>
                <li>Commissions being scrubbed without any justifiable reason.</li>
                <li>Absence of effective support when you need it the most.</li>
                <li>Payouts that take forever to reach your account.</li>
            </ul>
            <p>These obstacles can inhibit your growth, stifle your potential, and leave you feeling disillusioned with the whole affiliate marketing landscape. But it doesn't have to be this way.
            </p>
            <button class="boton openFormButton">Click to Sign Up</button>
        </div>
        <img src="assets/phrase.webp">
    </div>
    <div class="welcome">
        <div>
            <h2>Welcome to EcomfyLead: The New Era of Affiliate Marketing</h2>
            <p>At EcomfyLead, we're rewriting the rules of the affiliate game. We've listened to your concerns, understood your pain points, and designed our platform to address these issues head-on. We're all about empowering you to SCALE your operations and take your business to new heights.
            </p>
        </div>
        <img class="benefits" src="assets/chart.webp" alt="benefits">
    </div>
    <div class="incentive">
        <p>
            Come see how EcomfyLead has evolved to help Affiliates SCALE and elevate their success to unprecedented levels. Join us now, and unleash the full potential of your traffic. Your growth journey begins here.
        </p>
        <button class="boton2 openFormButton">Click to Sign Up</button>
    </div>
    <div class="container2">
        <div class="info2">
            <p>Customer acquisition at scale</p>
            <h2>No More Scrubbed Commissions</h2>
            <p>With EcomfyLead, you can bid goodbye to scrubbed commissions. We understand how vital every penny is in your affiliate journey. Our transparent and fair system ensures that you receive every cent you've worked so hard for.</p>
            <button class="boton openFormButton">Click to Sign Up</button>
        </div>
        <img src="assets/image.webp" alt="Image1">
    </div>
</body>
<footer>
    <img src="assets/logoWhite.png" alt="White logo">
</footer>

<script src="assets/js/jquery-3.7.0/jquery.min.js"></script>

<script>

    console.log('don pepito')


    // Function to open the pop-up window
    function openPopupForm() {
        var popup = document.getElementById("popupFormContainer");
        popup.style.display = "block";
    }

    // Function to close the pop-up window
    function closePopupForm() {
        var popup = document.getElementById("popupFormContainer");
        popup.style.display = "none";
    }

    // Add event listener to the button
    var openButton = document.querySelectorAll(".openFormButton");
    openButton.forEach(function(button){
        button.addEventListener("click", openPopupForm);
    })

    // Add event to button 'continue'
    $('#continue').click(function(){
        //Validate form
        if (!$("#email")[0].checkValidity()) {
            alert("Please enter a valid email address.");
            return;
        }
        if (!$("#phone")[0].checkValidity()) {
            alert("Please enter your phone.");
            return;
        }

        //First we send the verification code
        let recipientNumber = $('#phone').val().replace(' ', '').replace('-', '');
        $.ajax({
            type: 'POST',
            url: '/endpoints/send-verification.php', // Call the PHP script on your server
            data: {
                recipient: recipientNumber,
                locale: 'es'
            },
            success: function(response) {
                if (response.status === 'success') {
                    //Go to next step
                    $('#popupFormContainer').hide();
                    $('#popupNumberVerification').show();
                } else {
                    alert('Error sending verification code:' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error sending verification code:' + error);
            }
        });

    })

    // Add event listener to the button
    $('#submit-everything').click(function(){
        //Validate form
        if (!$("#verification")[0].checkValidity()) {
            alert("Please enter a valid verification code.");
            return;
        }

        // Get the info to validate it
        let code = $('#verification').val();
        let recipientNumber = $('#phone').val().replace(' ', '').replace('-', '');

        // Verify if the code is correct
        $.ajax({
            type: 'POST',
            url: '/endpoints/verify-code.php', // Call the PHP script on your server
            data: {
                recipient: recipientNumber,
                verificationCode: code
            },
            success: function(response) {
                if (response.status === 'success') {
                    //Submit the form
                    window.location.href = '/endpoints/submit.php';
                } else {
                    alert('Error validating code: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error validating code:' + error);
            }
        });
    })


    // Add event listener to close the pop-up when submitting the form
    var popupForm = document.getElementById("popupForm");
    popupForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission
        console.log('submitting form');
        console.log('hola');
    });

    function closePopupForm() {
        var popup = document.getElementById("popupFormContainer");
        popup.style.display = "none";
    }
    function closePopupFormVerification() {
        var popup = document.getElementById("popupNumberVerification");
        popup.style.display = "none";
    }

    // Add event listener to the close button
    var closeButton = document.getElementById("closeButton");
    closeButton.addEventListener("click", closePopupForm);

    // Add event listener to the close button
    var closeButton = document.getElementById("closeButton-verification");
    closeButton.addEventListener("click", closePopupFormVerification);
</script>
</html>