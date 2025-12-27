<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "Admin") {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User - Dolphin CRM</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/dash.css">
     <link rel="stylesheet" href="css/contact.css">
</head>
<body>
<div class="container">
    <header>
        <div class="wrapper">
            <img class="dol" src="assets/dolphin.svg" />
            <p>Dolphin CRM</p>
        </div>
    </header>

    <aside>
        <ul>
            <li><a href="dashboard.php"><img src="assets/house.svg" />Home</a></li>
            <li><a href="users.php" class="on"><img src="assets/users.png" />Users</a></li>
            <hr />
            <li><a href="logout.php"><img src="assets/logout.png" />Logout</a></li>
        </ul>
    </aside>

    <main>
        <section class="dashboard new">
            <div class="dash">
                <div class="dash-head">
                    <h1>New User</h1>
                </div>

                <!-- AJAX Form -->
                <form id="userForm" class="dash-info" method="POST" action="add_user.php">
                    <div class="fields">
                        <div class="field">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstname" required>
                        </div>
                        <div class="field">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastname" required>
                        </div>
                    </div>

                    <div class="fields">
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="fields">
                        <div class="field">
                            <label for="type">Role</label>
                            <select id="type" name="type">
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="field"></div>
                    </div>

                    <div class="btm-box">
                        <div class="message" id="formMessage"></div>
                        <button type="submit">Save</button>
                    </div>
                </form>

            </div>
        </section>
    </main>
</div>

<script src="user.js" defer></script>
</body>
</html>
