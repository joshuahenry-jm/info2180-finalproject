<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$stmt = $pdo->query("
    SELECT c.id, c.title, c.firstname, c.lastname, c.email, c.company, c.type, c.assigned_to
    FROM contacts c
    ORDER BY c.created_at DESC
");
$contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/dashboard.css" />
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
            <a href="dashboard.php" class="on"><img src="assets/house.svg" />Home</a>
          </li>
          <li>
            <a href="contact.php"><img src="assets/user.png" />New Contact</a>
          </li>
          <li>
            <a href="users.php"><img src="assets/users.png" />Users</a>
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
              <h1>Dashboard</h1>
              <a href="contact.php"><img src="assets/plus.svg" /> Add Contact</a>
            </div>

            <div class="dash-info">
              <ul class="dash-info-head">
                <li class="s-title">
                  <img src="assets/filter.svg" /><strong>Filter By:</strong>
                </li>
                <li><button id="filter-all" class="fil-on">All</button></li>
                <li><button id="filter-sales">Sales Leads</button></li>
                <li><button id="filter-support">Support</button></li>
                <li><button id="filter-assigned">Assigned to me</button></li>

              </ul>
              <table data-my-id="<?= $_SESSION['user_id'] ?>">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Company</th>
                  <th>Type</th>
                  <th></th>
                </tr>
                <?php foreach ($contacts as $contact): ?>
 <tr 
        data-type="<?= htmlspecialchars($contact['type']) ?>" 
        data-assigned="<?= htmlspecialchars($contact['assigned_to']) ?>"
    >
  <td>
    <?= htmlspecialchars($contact["title"] . ". " . $contact["firstname"] . " " . $contact["lastname"]) ?>
  </td>

  <td><?= htmlspecialchars($contact["email"]) ?></td>

  <td><?= htmlspecialchars($contact["company"]) ?></td>

  <td class="type">
    <?php if ($contact["type"] === "Support"): ?>
      <strong class="sup">Support</strong>
    <?php else: ?>
      <strong class="sale">Sales Lead</strong>
    <?php endif; ?>
  </td>

  <td>
    <a href="contact-d.php?id=<?= $contact["id"] ?>">View</a>
  </td>
</tr>
<?php endforeach; ?>

              </table>
            </div>
          </div>
        </section>
      </main>

    </div>
    <script src="filter.js"></script>
  </body>
</html>
