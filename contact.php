<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Contact - Dolphin CRM</title>

    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/contact.css" />
    <link rel="stylesheet" href="css/dash.css" />
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
            <li><a href="contact.php" class="on"><img src="assets/user.png" />New Contact</a></li>
            <li><a href="users.php"><img src="assets/users.png" />Users</a></li>
            <hr />
            <li><a href="logout.php"><img src="assets/logout.png" />Logout</a></li>
        </ul>
    </aside>

    <main>
        <section class="dashboard">
            <div class="dash">
                <div class="dash-head">
                    <h1>New Contact</h1>
                </div>

                <form id="contactForm" class="dash-info" method="POST" action="add_contact.php">

                    <label for="title">Title</label>
                    <select id="title" name="title" required>
                        <option value="">Select title</option>
                        <option>Mr</option>
                        <option>Ms</option>
                        <option>Mrs</option>
                        <option>Dr</option>
                    </select>

                    <div class="fields">
                        <div class="field">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstname" required />
                        </div>

                        <div class="field">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastname" required />
                        </div>
                    </div>

                    <div class="fields">
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" />
                        </div>

                        <div class="field">
                            <label for="telephone">Telephone</label>
                            <input type="tel" id="telephone" name="telephone" />
                        </div>
                    </div>

                    <div class="fields">
                        <div class="field">
                            <label for="company">Company</label>
                            <input type="text" id="company" name="company" />
                        </div>

                        <div class="field">
                            <label for="type">Type</label>
                            <select id="type" name="type">
                                <option value="">Select type</option>
                                <option>Sales Lead</option>
                                <option>Support</option>
                            </select>
                        </div>
                    </div>

                    <label for="assigned">Assigned To</label>
                    <select id="assigned" name="assigned_to">
                        <option value="">Select user</option>
                        <?php
                        $users = $pdo->query("SELECT id, firstname, lastname FROM users")->fetchAll();
                        foreach($users as $user){
                            echo "<option value='{$user['id']}'>" . htmlspecialchars($user['firstname'] . " " . $user['lastname']) . "</option>";
                        }
                        ?>
                    </select>

           
                    <div class="btm-box">
                        <div class="message" id="formMessage"></div>
                        <button type="submit">Save</button>
                    </div>

                </form>
            </div>
        </section>
    </main>
</div>

<script src="contact.js" defer></script>
</body>
</html>
