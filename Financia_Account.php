<?php 
session_start(); 
include 'backend/db_connect.php';  // Make sure this path is correct

// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: Financia_Sign_In.php');
    exit();
}

$user_id = $_SESSION['user_id'] ?? 0;
$sql = "SELECT username_email, created_at, city FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href=""><!--Financia logo not yet available-->
    <link rel="stylesheet" href="Financia_Account.css">
    <title>Financia - Account</title>
    <style>
        @media screen and (max-width: 1920px) and (max-height: 1080px) {
            body {
                background-image: url(Financia_Home_Page_Images/Financia\ Home\ Page\ Background\ 1.png), url(Financia_Home_Page_Images/Financia\ Home\ Page\ Background\ 2.png), url(Financia_Home_Page_Images/Financia\ Home\ Page\ Background\ 3.mdp);
                background-color: rgb(199, 163, 245);
                background-repeat: no-repeat, no-repeat, no-repeat;
                background-position-y: top, center, bottom;
                background-size: 1800px 1600px, 1800px 1900px, 1800px 2340px;
                width: 95vw;
            }
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto1;
            src: url(Financia_Fonts/roboto/Roboto-Light.ttf);
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto2;
            src: url(Financia_Fonts/roboto/Roboto-Bold.ttf);
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto3;
            src: url(Financia_Fonts/roboto/Roboto-Black.ttf);
        }

        @font-face {
            font-family: Coolvetica1;
            src: url(Financia_Fonts/coolvetica/coolvetica\ condensed\ rg.otf);
        }

        @font-face {
            font-family: Coolvetica2;
            src: url(Financia_Fonts/coolvetica/coolvetica\ rg.otf);
        }
    </style>
</head>

<body>
    <table class="table1">
        <tr>
            <td class="Financia_box"><a class="Financia" href="Financia.html">Financia</a></td>
            <td style="width: 50vw;"></td>
            <td class="e-pay_box">
                <img class="e-pay_button" id="epayBtn" src="Financia_Home_Page_Images/plus.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuEpay">
                    <a href="Financia-E-Pay.html">E-Pay</a>
                </div>
            </td>

            <td class="notification_box"><img class="notification_button"
                    src="Financia_Home_Page_Images/Notification bell.png" alt=""></td>
            <td class="account_box">
                <img class="account" id="accountBtn" src="Financia_Home_Page_Images/Account profile.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuAccount">
                    <a href="Financia_Sign_Up.php">Sign Up</a>
                    <a href="Financia_Account.php" class="active">Account</a>
                    <a href="backend/logout.php">Logout</a>
                </div>
            </td>
            <td class="settings_box"><img class="settings_button" src="Financia_Home_Page_Images/Settings logo.png"
                    alt=""></td>
        </tr>
    </table>
    <table class="table2">
        <form action="">
            <tr>
                <td class="td_link">
                    <a class="nav_link" href="Financia_Dashboard_Overview.html">Overview</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="Financia_Dashboard_Summary.html">Summary</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="Financia_History.html">History</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="#">Transactions</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="#">Reports</a>
                </td>
            </tr>
        </form>
    </table>

    
        <div class="username-header">
            <span><?php echo htmlspecialchars($user['username_email'] ?? 'Username'); ?></span>
            <img src="Financia_Home_Page_Images/edit-icon.png" alt="edit" class="edit-icon">
        </div>
    <div class="account-info">
        <div class="info-row info-grouped">
            <div class="info-group">
                <div class="info-label">Email</div>
                <div class="info-value" id="emailContainer">
                    <?php if (!empty($user['email'])): ?>
                        <span id="emailDisplay"><?php echo htmlspecialchars($user['email']); ?></span>
                    <?php else: ?>
                        <span id="emailDisplay">Add email</span>
                    <?php endif; ?>
                    <img src="Financia_Home_Page_Images/edit-icon.png" alt="edit" class="edit-icon" id="editEmailBtn">
                    <div id="emailEditContainer" style="display: none;">
                        <input type="email" id="emailInput" placeholder="Enter email">
                        <button id="saveEmailBtn">Save</button>
                        <button id="cancelEmailBtn">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="info-group">
                <div class="info-label">Account Created</div>
                <div class="info-value"><?php echo date('m/d/y', strtotime($user['created_at'] ?? '')); ?></div>
            </div>
            <div class="info-group">
                <div class="info-label">City</div>
                <div class="info-value"><?php echo htmlspecialchars($user['city'] ?? 'Not specified'); ?></div>
            </div>
        </div>

        <div class="info-row">
            <div class="connected-account">
                <div class="custom-select">
                    <div class="selected-image">
                        <img src="Financia_E-Pay_Image/bdo.png" alt="BDO" id="selectedBankImage">
                        <div class="dropdown-arrow"></div>
                    </div>
                    <div class="select-options">
                        <div class="option" data-value="gcash">
                            <img src="Financia_E-Pay_Image/gcash.png" alt="GCash">
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="account-input" placeholder="Account Number"   >
                    <input type="email" class="email-input" placeholder="Email Address">
                </div>
                <button class="connect-btn">Connect</button>
            </div>
            
            <div class="connected-status">
                <div class="status-label">Connected Account</div>
                <input type="text" class="status-input"  disabled>
                <input type="text" class="status-input"  disabled>
            </div>
        </div>
    </div>
    <div class="username-footer">
        <button class="footer-btn save-btn">Save Info</button>
        <button class="footer-btn delete-btn">Delete Account</button>
    </div>  
    <div>
        <hr style="margin: 12vw 0 0 -1vw; border: 0.1vw solid black; width: 38vw;">
        <hr style="width: 9vw; border: 0.1vw solid black; margin: -0.2vw 0 0 40vw;">
        <hr style="width: 3vw; border: 0.1vw solid black; margin: -0.2vw 0 0 52vw;">
        <hr style="width: 39.2vw; border: 0.1vw solid black; margin: -0.2vw 0 0 58vw;">
    </div>
    <div class="div6">
        <img class="social_media_logo" src="Financia_Home_Page_Images/facebook.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/twitter.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/tiktok.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/instagram.png" alt="">
    </div>
    <table class="table5">
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">About Us</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Terms & Conditions</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Market Insights</a></td>
        </tr>
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">User Support</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Privacy Policy</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Budget Planner</a></td>
        </tr>
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">Contact Us</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Security Information</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Savings Tracker</a></td>
        </tr>
    </table>
    <br>
    <hr style="border: 0.1vw solid black; width: 99.2vw; margin: 0 -1vw 0 -1vw;">
    <p class="copyright">&copy; 2024 Financia. All Rights Reserved.</p>

    <script>
        // E-Pay Dropdown
        const epayBtn = document.getElementById('epayBtn');
        const dropdownMenuEpay = document.getElementById('dropdownMenuEpay');

        // Account Dropdown
        const accountBtn = document.getElementById('accountBtn');
        const dropdownMenuAccount = document.getElementById('dropdownMenuAccount');

        // Toggle visibility of E-Pay dropdown
        epayBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling up
            dropdownMenuEpay.style.display =
                dropdownMenuEpay.style.display === 'block' ? 'none' : 'block';
            dropdownMenuAccount.style.display = 'none'; // Close other dropdown
        });

        // Toggle visibility of Account dropdown
        accountBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling up
            dropdownMenuAccount.style.display =
                dropdownMenuAccount.style.display === 'block' ? 'none' : 'block';
            dropdownMenuEpay.style.display = 'none'; // Close other dropdown
        });

        // Close dropdowns when clicking outside
        window.addEventListener('click', () => {
            dropdownMenuEpay.style.display = 'none';
            dropdownMenuAccount.style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const customSelect = document.querySelector('.custom-select');
            const selectedImage = document.querySelector('.selected-image');
            const selectedBankImage = document.getElementById('selectedBankImage');
            const option = document.querySelector('.option');

            selectedImage.addEventListener('click', function() {
                customSelect.classList.toggle('active');
            });

            option.addEventListener('click', function() {
                const newSrc = this.querySelector('img').src;
                const oldSrc = selectedBankImage.src;
                selectedBankImage.src = newSrc;
                this.querySelector('img').src = oldSrc;
                customSelect.classList.remove('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!customSelect.contains(e.target)) {
                    customSelect.classList.remove('active');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const emailContainer = document.getElementById('emailContainer');
            const emailDisplay = document.getElementById('emailDisplay');
            const editEmailBtn = document.getElementById('editEmailBtn');
            const emailEditContainer = document.getElementById('emailEditContainer');
            const emailInput = document.getElementById('emailInput');
            const saveEmailBtn = document.getElementById('saveEmailBtn');
            const cancelEmailBtn = document.getElementById('cancelEmailBtn');

            editEmailBtn.addEventListener('click', function() {
                emailDisplay.style.display = 'none';
                editEmailBtn.style.display = 'none';
                emailEditContainer.style.display = 'inline-block';
                emailInput.value = emailDisplay.textContent !== 'Add email' ? emailDisplay.textContent : '';
            });

            cancelEmailBtn.addEventListener('click', function() {
                emailDisplay.style.display = 'inline';
                editEmailBtn.style.display = 'inline';
                emailEditContainer.style.display = 'none';
            });

            saveEmailBtn.addEventListener('click', function() {
                const newEmail = emailInput.value.trim();
                if (!newEmail) {
                    alert('Please enter a valid email address');
                    return;
                }

                // Send to backend
                fetch('backend/update_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: newEmail
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        emailDisplay.textContent = newEmail;
                        emailDisplay.style.display = 'inline';
                        editEmailBtn.style.display = 'inline';
                        emailEditContainer.style.display = 'none';
                    } else {
                        alert('Failed to update email: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error updating email');
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>