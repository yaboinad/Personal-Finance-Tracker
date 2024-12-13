<?php
session_start();
include 'backend/db_connect.php';

// Get username and email from session
$username_email = $_SESSION['username_email'] ?? 'Username';
$email = $_SESSION['email'] ?? '';

// Determine what text to display in the username header
$display_text = $username_email;

// If you still need other user data from database:
if (isset($_SESSION['username_email'])) {
    $sql = "SELECT created_at, city, email FROM users WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username_email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

// Format email for display
if (!empty($row['email'])) {
    $maxLength = 12;
    $displayEmail = strlen($row['email']) > $maxLength ?
        substr($row['email'], 0, $maxLength) . '...' :
        $row['email'];
}
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
            <td class="Financia_box"><a class="Financia" href="Financia.php">Financia</a></td>
            <td style="width: 50vw;"></td>
            <td class="e-pay_box">
                <img class="e-pay_button" id="epayBtn" src="Financia_Home_Page_Images/plus.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuEpay">
                    <a href="Financia-E-Pay.php">E-Pay</a>
                </div>
            </td>

            <td class="notification_box"><img class="notification_button"
                    src="Financia_Home_Page_Images/Notification bell.png" alt=""></td>
            <td class="account_box">
                <img class="account" id="accountBtn" src="Financia_Home_Page_Images/Account profile.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuAccount">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <a href="Financia.php">Home</a>
                        <a href="Financia_Sign_Up.php">Sign Up</a>
                        <a href="Financia_Account.php" class="active">Account</a>
                        <a href="backend/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="Financia_Sign_Up.php">Sign Up</a>
                        <a href="Financia_Account.php">Account</a>
                        <a href="Financia.php">Home</a>
                    <?php endif; ?>
                </div>
            </td>
            <td class="settings_box"><img class="settings_button" src="Financia_Home_Page_Images/Settings logo.png"
                    alt=""></td>
        </tr>
    </table>
    <table class="table2">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <form action="">
                <tr>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='Financia_Dashboard_Overview.html'">Overview</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Summary</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">History</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Transactions</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Reports</button>
                    </td>
                </tr>
            </form>
        <?php else: ?>
            <tr>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Overview</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Summary</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">History</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Transactions</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Reports</button>
                </td>
            </tr>
        <?php endif; ?>
    </table>


    <div class="username-header">
        <span id="usernameDisplay"><?php echo htmlspecialchars($display_text); ?></span>
        <img src="edit (1).png" alt="edit" class="edit-icon" id="editUsernameBtn">
        <div id="usernameEditContainer" style="display: none;">
            <div class="input-wrapper">
                <input type="text" id="usernameInput" placeholder="Username">
            </div>
            <div class="button-wrapper">
                <button id="saveUsernameBtn">Save</button>
                <button id="cancelUsernameBtn">Cancel</button>
            </div>
        </div>
    </div>
    <div class="account-info">
        <div class="info-row info-grouped">
            <div class="info-group">
                <div class="info-label">Email</div>
                <div class="info-value" id="emailContainer">
                    <span id="emailDisplay" title="<?php echo htmlspecialchars($row['email'] ?? ''); ?>">
                        <?php echo !empty($displayEmail) ? htmlspecialchars($displayEmail) : 'Add email'; ?>
                    </span>
                    <img src="edit (1).png" alt="edit" class="edit-icon" id="editEmailBtn">
                </div>
                <div id="emailEditContainer">
                    <div class="input-wrapper">
                        <input type="email" id="emailInput" placeholder="Enter email">
                    </div>
                    <div class="button-wrapper">
                        <button id="saveEmailBtn">Save</button>
                        <button id="cancelEmailBtn">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="info-group">
                <div class="info-label">Account Created</div>
                <div class="info-value"><?php echo isset($row['created_at']) ? date('m/d/y', strtotime($row['created_at'])) : 'Not available'; ?></div>
            </div>
            <div class="info-group">
                <div class="info-label">City</div>
                <div class="info-value"><?php echo htmlspecialchars($row['city'] ?? 'Not specified'); ?></div>
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
                    <input type="text" class="account-input" id="accountNumber" name="accountNumber" placeholder="Account Number">
                    <input type="email" class="email-input" id="accountEmail" name="accountEmail" placeholder="Email Address">
                </div>
                <button class="connect-btn">Connect</button>
            </div>

            <div class="connected-status">
                <div class="status-label">Connected Bank Account</div>
                <div class="status-inputs-container">
                    <input type="text" class="status-input" id="bdoStatus" name="bdoStatus" disabled>
                    <input type="text" class="status-input" id="gcashStatus" name="gcashStatus" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="username-footer">
        <input type="button" class="footer-btn" value="Save Info">
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
            <td class="footer_link_box"><a class="footer_links" href="Financia-AboutUs-html">About Us</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Terms & Conditions</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Privacy Policy</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Contact Us</a></td>
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
            const accountInput = document.getElementById('accountNumber');

            // Set BDO placeholder by default on page load
            accountInput.placeholder = '12-digit Account Number';

            // Show placeholder when input loses focus and is empty or only contains '00'
            accountInput.addEventListener('blur', function() {
                if (!this.value || this.value === '00' || this.value === '09') {
                    if (selectedBankImage.src.includes('bdo')) {
                        this.placeholder = '12-digit Account Number';
                        this.value = '';
                    } else if (selectedBankImage.src.includes('gcash')) {
                        this.placeholder = '11-digit Phone Number';
                        this.value = '';
                    }
                    this.style.borderColor = '';
                }
            });

            // Clear placeholder when input is focused
            accountInput.addEventListener('focus', function() {
                this.placeholder = '';
                if (selectedBankImage.src.includes('bdo') && !this.value) {
                    this.value = '00';
                } else if (selectedBankImage.src.includes('gcash') && !this.value) {
                    this.value = '09';
                }
            });

            // Add input event listener for account number validation
            accountInput.addEventListener('input', function() {
                if (selectedBankImage.src.includes('bdo')) {
                    // Existing BDO validation
                    let value = this.value.replace(/\D/g, '');
                    if (!value.startsWith('00')) {
                        value = '00' + value;
                    }
                    value = value.slice(0, 12);
                    this.value = value;
                    this.style.borderColor = value.length === 12 ? '#4CAF50' : '#f44336';
                } else if (selectedBankImage.src.includes('gcash')) {
                    // GCash validation (Philippine phone number)
                    let value = this.value.replace(/\D/g, '');
                    if (!value.startsWith('09') && value.length > 0) {
                        value = '09' + value;
                    }
                    value = value.slice(0, 11);
                    this.value = value;
                    this.style.borderColor = value.length === 11 ? '#4CAF50' : '#f44336';
                }
            });

            selectedImage.addEventListener('click', function() {
                customSelect.classList.toggle('active');
            });

            option.addEventListener('click', function() {
                const newSrc = this.querySelector('img').src;
                const oldSrc = selectedBankImage.src;
                selectedBankImage.src = newSrc;
                this.querySelector('img').src = oldSrc;
                customSelect.classList.remove('active');

                // Reset account input value
                accountInput.value = '';
                accountInput.style.borderColor = '';

                // Show the appropriate account number in placeholder
                if (newSrc.includes('bdo')) {
                    accountInput.placeholder = accountInput.dataset.bdoAccount || '12-digit Account Number';
                } else if (newSrc.includes('gcash')) {
                    accountInput.placeholder = accountInput.dataset.gcashAccount || '11-digit Phone Number';
                }
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
                emailEditContainer.style.display = 'flex';
                emailInput.value = emailDisplay.title && emailDisplay.title !== 'Add email' ?
                    emailDisplay.title :
                    '';
            });

            cancelEmailBtn.addEventListener('click', function() {
                emailDisplay.style.display = 'inline';
                editEmailBtn.style.display = 'inline';
                emailEditContainer.style.display = 'none';
            });

            saveEmailBtn.addEventListener('click', function() {
                const newEmail = emailInput.value.trim();

                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(newEmail)) {
                    alert('Please enter a valid email address');
                    return;
                }

                // Check if email ends with @gmail.com
                if (!newEmail.toLowerCase().endsWith('@gmail.com')) {
                    alert('Please use a Gmail address');
                    return;
                }

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
                            const maxLength = 12;
                            const displayEmail = newEmail.length > maxLength ?
                                newEmail.substring(0, maxLength) + '...' :
                                newEmail;

                            emailDisplay.textContent = displayEmail;
                            emailDisplay.title = newEmail;
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

            emailInput.placeholder = 'Enter Gmail address';
            emailInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value && !value.toLowerCase().endsWith('@gmail.com')) {
                    this.style.borderColor = '#f44336';
                } else {
                    this.style.borderColor = '';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const usernameDisplay = document.getElementById('usernameDisplay');
            const editUsernameBtn = document.getElementById('editUsernameBtn');
            const usernameEditContainer = document.getElementById('usernameEditContainer');
            const usernameInput = document.getElementById('usernameInput');
            const saveUsernameBtn = document.getElementById('saveUsernameBtn');
            const cancelUsernameBtn = document.getElementById('cancelUsernameBtn');

            editUsernameBtn.addEventListener('click', function() {
                usernameDisplay.style.display = 'none';
                editUsernameBtn.style.display = 'none';
                usernameEditContainer.style.display = 'flex';
                // Don't pre-fill the input if it's the default "Username" text
                usernameInput.value = usernameDisplay.textContent === 'Username' ? '' : usernameDisplay.textContent;
            });

            saveUsernameBtn.addEventListener('click', function() {
                const newUsername = usernameInput.value.trim();
                if (!newUsername) {
                    alert('Please enter a valid username');
                    return;
                }

                // Add validation to prevent @ symbol in username
                if (newUsername.includes('@')) {
                    alert('Username cannot contain @ symbol');
                    return;
                }

                fetch('backend/update_username.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            username: newUsername
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const maxLength = 12;
                            const displayUsername = newUsername.length > maxLength ?
                                newUsername.substring(0, maxLength) + '...' :
                                newUsername;

                            usernameDisplay.textContent = displayUsername;
                            usernameDisplay.title = newUsername;
                            usernameDisplay.style.display = 'inline';
                            editUsernameBtn.style.display = 'inline';
                            usernameEditContainer.style.display = 'none';
                        } else {
                            alert('Failed to update username: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error updating username');
                        console.error('Error:', error);
                    });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const accountInput = document.getElementById('accountNumber');
            const emailInput = document.getElementById('emailInput');
            const statusInputs = document.querySelectorAll('.status-input');
            const saveInfoBtn = document.querySelector('.footer-btn[value="Save Info"]');
            const notification = document.createElement('div');
            notification.className = 'notification';
            document.body.appendChild(notification);

            // First, fetch saved accounts
            fetch('backend/get_saved_accounts.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.accounts) {
                        const accounts = data.accounts;

                        // Update BDO account if exists
                        if (accounts.bdo_account) {
                            accountInput.dataset.bdoAccount = accounts.bdo_account;
                            if (selectedBankImage.src.includes('bdo')) {
                                accountInput.placeholder = accounts.bdo_account;
                            }
                            statusInputs[0].value = '';
                            statusInputs[0].style.backgroundImage = 'url("Financia_E-Pay_Image/bdo.png")';
                            statusInputs[0].style.backgroundSize = '50px';
                            statusInputs[0].style.backgroundRepeat = 'no-repeat';
                            statusInputs[0].style.backgroundPosition = 'center center';
                            statusInputs[0].style.backgroundColor = '#ffffff';
                        }

                        // Update GCash account if exists
                        if (accounts.gcash_account) {
                            accountInput.dataset.gcashAccount = accounts.gcash_account;
                            if (selectedBankImage.src.includes('gcash')) {
                                accountInput.placeholder = accounts.gcash_account;
                            }
                            statusInputs[1].value = '';
                            statusInputs[1].style.backgroundImage = 'url("Financia_E-Pay_Image/gcash.png")';
                            statusInputs[1].style.backgroundSize = '50px';
                            statusInputs[1].style.backgroundRepeat = 'no-repeat';
                            statusInputs[1].style.backgroundPosition = 'center center';
                            statusInputs[1].style.backgroundColor = '#ffffff';
                        }
                    }
                })
                .catch(error => console.error('Error loading saved accounts:', error));

            // Rest of your existing event listeners...
        });

        // Delete account button click handler
        const deleteBtn = document.querySelector('.delete-btn');
        const statusInputs = document.querySelectorAll('.status-input');
        let deleteMode = false;

        // Add delete overlay to each status input
        statusInputs.forEach((input, index) => {
            const deleteOverlay = document.createElement('div');
            deleteOverlay.className = 'delete-overlay';
            deleteOverlay.style.position = 'absolute';
            deleteOverlay.style.top = '0';
            deleteOverlay.style.left = '0';
            deleteOverlay.style.width = '100%';
            deleteOverlay.style.height = '100%';
            deleteOverlay.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
            deleteOverlay.style.display = 'none';
            deleteOverlay.style.justifyContent = 'center';
            deleteOverlay.style.alignItems = 'center';
            deleteOverlay.style.cursor = 'pointer';
            deleteOverlay.style.zIndex = '1';
            deleteOverlay.style.color = 'red';
            deleteOverlay.style.fontWeight = 'bold';
            deleteOverlay.textContent = 'DELETE';

            input.parentElement.style.position = 'relative';
            input.parentElement.appendChild(deleteOverlay);

            // Handle click on delete overlay
            deleteOverlay.addEventListener('click', function() {
                if (!deleteMode) return;

                const accountType = index === 0 ? 'bdoAccount' : 'gcashAccount';

                // Send delete request to server
                fetch('backend/delete_account.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            accountType: accountType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            input.value = '';
                            input.style.backgroundImage = 'none';
                            deleteOverlay.style.display = 'none';
                            deleteMode = false;

                            notification.textContent = `${index === 0 ? 'BDO' : 'GCash'} account deleted successfully!`;
                            notification.style.backgroundColor = '#4CAF50';
                            notification.style.display = 'block';
                            setTimeout(() => notification.style.display = 'none', 3000);
                        }
                    });
            });
        });

        deleteBtn.addEventListener('click', function() {
            const confirmDialog = document.createElement('div');
            confirmDialog.className = 'confirm-dialog';
            confirmDialog.innerHTML = `
                <div class="confirm-content">
                    <p>Are you sure you want to delete this account?</p>
                    <div class="confirm-buttons">
                        <button class="confirm-yes">Yes</button>
                        <button class="confirm-no">No</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmDialog);

            confirmDialog.querySelector('.confirm-yes').addEventListener('click', function() {
                fetch('backend/delete_user_account.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear all form fields and status inputs
                            const statusInputs = document.querySelectorAll('.status-input');
                            statusInputs.forEach(input => {
                                input.value = '';
                                input.style.backgroundImage = 'none';
                                input.style.backgroundColor = '#ffffff';
                            });

                            // Show success notification
                            notification.textContent = 'Account deleted successfully';
                            notification.style.backgroundColor = '#4CAF50';
                            notification.style.display = 'block';

                            // Reload the current page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500); // 1.5 second delay to show the success message
                        }
                    });
                confirmDialog.remove();
            });

            confirmDialog.querySelector('.confirm-no').addEventListener('click', function() {
                confirmDialog.remove();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in and update display
            fetch('backend/check_login.php')
                .then(response => response.json())
                .then(data => {
                    if (data.loggedIn) {
                        // Update username display
                        const usernameDisplay = document.getElementById('usernameDisplay');
                        if (usernameDisplay) {
                            usernameDisplay.textContent = data.username;
                        }

                        // Get and update email display
                        fetch('backend/get_user_email.php')
                            .then(response => response.json())
                            .then(emailData => {
                                const emailDisplay = document.getElementById('emailDisplay');
                                if (emailDisplay && emailData.email) {
                                    const maxLength = 12;
                                    const displayEmail = emailData.email.length > maxLength ?
                                        emailData.email.substring(0, maxLength) + '...' :
                                        emailData.email;
                                    emailDisplay.textContent = displayEmail;
                                    emailDisplay.title = emailData.email;
                                }
                            });
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const connectBtn = document.querySelector('.connect-btn');
            const accountInput = document.getElementById('accountNumber');
            const accountEmail = document.getElementById('accountEmail');
            const selectedBankImage = document.getElementById('selectedBankImage');
            const statusInputs = document.querySelectorAll('.status-input');

            // Reset email input styling and placeholder on focus
            accountEmail.addEventListener('focus', function() {
                this.style.borderColor = '';
                this.placeholder = 'Email Address';
            });

            connectBtn.addEventListener('click', function() {
                const accountNumber = accountInput.value.trim();
                const email = accountEmail.value.trim();
                const accountType = selectedBankImage.src.includes('bdo') ? 'bdo' : 'gcash';

                // Check if account number is empty
                if (!accountNumber) {
                    accountInput.value = '';
                    accountInput.placeholder = 'Please add account number';
                    accountInput.style.borderColor = '#f44336';
                    return;
                }

                // Basic email validation - just check for @ symbol
                if (!email.includes('@')) {
                    accountEmail.value = '';
                    accountEmail.placeholder = 'Invalid email format';
                    accountEmail.style.borderColor = '#f44336';
                    return;
                }

                // Account number format validation
                let isValidAccount = false;
                if (accountType === 'bdo') {
                    isValidAccount = accountNumber.length === 12 && accountNumber.startsWith('00');
                    if (!isValidAccount) {
                        accountInput.value = '';
                        accountInput.placeholder = 'Invalid BDO account number';
                        accountInput.style.borderColor = '#f44336';
                        return;
                    }
                } else {
                    isValidAccount = accountNumber.length === 11 && accountNumber.startsWith('09');
                    if (!isValidAccount) {
                        accountInput.value = '';
                        accountInput.placeholder = 'Invalid GCash number';
                        accountInput.style.borderColor = '#f44336';
                        return;
                    }
                }

                // Reset account input styling when valid
                accountInput.style.borderColor = '';

                // Verify email matches account email
                fetch('backend/verify_email.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            accountEmail.value = '';
                            accountEmail.placeholder = 'Email does not match account email';
                            accountEmail.style.borderColor = '#f44336';
                            throw new Error('Email verification failed');
                        }

                        // If email is verified, proceed with saving bank info
                        return fetch('backend/save_bank_info.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                bdoAccount: accountType === 'bdo' ? accountNumber : '',
                                gcashAccount: accountType === 'gcash' ? accountNumber : '',
                                email: email
                            })
                        });
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the status display
                            const statusIndex = accountType === 'bdo' ? 0 : 1;
                            statusInputs[statusIndex].value = '';
                            statusInputs[statusIndex].style.backgroundImage =
                                `url("Financia_E-Pay_Image/${accountType}.png")`;
                            statusInputs[statusIndex].style.backgroundSize = '50px';
                            statusInputs[statusIndex].style.backgroundRepeat = 'no-repeat';
                            statusInputs[statusIndex].style.backgroundPosition = 'center center';
                            statusInputs[statusIndex].style.backgroundColor = '#ffffff';

                            // Clear inputs
                            accountInput.value = '';
                            accountEmail.value = '';
                            accountEmail.placeholder = 'Email Address';
                            accountEmail.style.borderColor = '';
                            accountInput.style.borderColor = '';
                            accountInput.placeholder = accountType === 'bdo' ? '12-digit Account Number' : '11-digit Phone Number';
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        if (error.message !== 'Email verification failed') {
                            accountInput.value = '';
                            accountInput.placeholder = 'Error: ' + error.message;
                            accountInput.style.borderColor = '#f44336';
                        }
                    });
            });
        });

        // Save Info button click handler
        document.querySelector('.footer-btn[value="Save Info"]').addEventListener('click', function() {
            const accountNumber = document.getElementById('accountNumber');
            const accountEmail = document.getElementById('accountEmail');
            const selectedBankImage = document.getElementById('selectedBankImage');
            const accountType = selectedBankImage.src.includes('bdo') ? 'bdo' : 'gcash';

            // Create notification element if it doesn't exist
            let notification = document.querySelector('.notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.className = 'notification';
                document.body.appendChild(notification);
            }

            // Save the account information
            fetch('backend/save_bank_info.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        bdoAccount: accountType === 'bdo' ? accountNumber.value : '',
                        gcashAccount: accountType === 'gcash' ? accountNumber.value : '',
                        email: accountEmail.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        notification.textContent = 'Information saved successfully!';
                        notification.className = 'notification success';
                        notification.style.display = 'block';
                        setTimeout(() => notification.style.display = 'none', 3000);

                        // Fetch updated account information
                        return fetch('backend/get_saved_accounts.php');
                    } else {
                        throw new Error(data.message);
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.accounts) {
                        const accounts = data.accounts;

                        // Update account number placeholder based on selected bank
                        if (accountType === 'bdo' && accounts.bdo_account) {
                            accountNumber.placeholder = accounts.bdo_account;
                            accountNumber.dataset.bdoAccount = accounts.bdo_account;
                        } else if (accountType === 'gcash' && accounts.gcash_account) {
                            accountNumber.placeholder = accounts.gcash_account;
                            accountNumber.dataset.gcashAccount = accounts.gcash_account;
                        }

                        // Update email placeholder
                        if (accounts.email) {
                            accountEmail.placeholder = accounts.email;
                        }

                        // Clear input values
                        accountNumber.value = '';
                        accountEmail.value = '';
                    }
                })
                .catch(error => {
                    notification.textContent = 'Error: ' + error.message;
                    notification.className = 'notification error';
                    notification.style.display = 'block';
                    setTimeout(() => notification.style.display = 'none', 3000);
                });
        });
    </script>
</body>

</html>