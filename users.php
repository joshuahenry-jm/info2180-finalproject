<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$stmt = $pdo->query("
    SELECT 
        u.id,
        u.firstname,
        u.lastname,
        u.email,
        u.role,
        u.created_at
    FROM users u
    ORDER BY u.created_at DESC
");

$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/users.css" />
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
          <li>
            <a href="dashboard.php"><img src="assets/house.svg" />Home</a>
          </li>
          <li>
            <a href="contact.php"><img src="assets/user.png" />New Contact</a>
          </li>
          <li>
            <a href="users.php" class="on"
              ><img src="assets/users.png" />Users</a
            >
          </li>
          <hr />
          <li>
            <a href="logout.php"><img src="assets/logout.png" />Logout</a>
          </li>
        </ul>
      </aside>

      <main>
        <section class="dashboard">
          <div class="dash">
            <div class="dash-head">
              <h1>Users</h1>
              <a href="user-new.php"><img src="assets/plus.svg" />Add User</a>
            </div>

            <div class="dash-info">
              <table>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Created</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                  <td>
    <?= htmlspecialchars( $user["firstname"] . " " . $user["lastname"]) ?>
  </td>

  <td><?= htmlspecialchars($user["email"]) ?></td>
                  <td><?= htmlspecialchars($user["role"]) ?></td>
                  <td><?= htmlspecialchars($user["created_at"]) ?></td>
                </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </section>
      </main>

      <footer>
        <div class="wrapper">Copyright &copy; 2025 Dolphin CRM</div>
      </footer>
    </div>
  </body>
</html>
