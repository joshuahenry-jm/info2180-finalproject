<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$contact_id = $_GET['id'] ?? null;
if (!$contact_id) {
    die("Contact ID missing");
}


$stmt = $pdo->prepare("
    SELECT 
        c.id, 
        c.title,
        c.firstname, 
        c.lastname, 
        c.email, 
        c.telephone,
        c.company, 
        c.type, 
        c.assigned_to,  
        c.created_at, 
        c.updated_at, 
        u.firstname AS creator_firstname,
        u.lastname AS creator_lastname,
        ua.firstname AS assigned_firstname,
        ua.lastname AS assigned_lastname
    FROM contacts c
    LEFT JOIN users u ON c.created_by = u.id
    LEFT JOIN users ua ON c.assigned_to = ua.id
    WHERE c.id = ?
");
$stmt->execute([$contact_id]);
$contact = $stmt->fetch();

if (!$contact) {
    die("Contact not found");
}


$notesStmt = $pdo->prepare("
    SELECT 
        n.comment,
        n.created_at,
        u.firstname,
        u.lastname
    FROM notes n
    JOIN users u ON n.created_by = u.id
    WHERE n.contact_id = ?
    ORDER BY n.created_at DESC
");
$notesStmt->execute([$contact_id]);
$notes = $notesStmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/contact-d.css" />
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
            <a href="users.php"><img src="assets/users.png" />Users</a>
          </li>
          <hr />
          <li>
            <a href="login.php"><img src="assets/logout.png" />Logout</a>
          </li>
        </ul>
      </aside>

      <main>
        <section class="dashboard">
          <div class="dash">
            <div class="dash-head">
              <div class="profile">
                <div class="img-box"><img src="assets/user2.png" /></div>

                <div class="profile-info">
                  <h2><?= htmlspecialchars( $contact['firstname'] . " " . $contact['lastname']) ?></h2>
<p class="create">
 Created on <?= date('F j, Y', strtotime($contact['created_at']))?> by <?= htmlspecialchars($contact['creator_firstname'] . " " . $contact['creator_lastname']) ?>
</p>
<p class="update">
  Updated on <?= date('F j, Y', strtotime($contact['updated_at']))?>
</p>

                </div>
              </div>

              <div class="buttons">
                <button
  class="assign"
  id="assignBtn"
  data-contact="<?= $contact['id'] ?>"
  data-user="<?= $_SESSION['user_id'] ?>"
>
  <img src="assets/hand.png" />Assign to me
</button>

                <button
  class="switch"
  id="switchTypeBtn"
  data-id="<?= $contact['id'] ?>"
  data-type="<?= $contact['type'] ?>"
>
  <img src="assets/arrow.png" />
  Switch to <?= $contact['type'] === "Support" ? "Sales Lead" : "Support" ?>
</button>

              </div>
            </div>

            <div class="dash-info">
              <div class="top">
                <div class="fields">
                  <div class="field">
                    <h4>Email</h4>
                    <p><?= htmlspecialchars( $contact['email']) ?></p>
                  </div>

                  <div class="field">
                    <h4>Telephone</h4>
                    <p><?= htmlspecialchars( $contact['telephone']) ?></p>
                  </div>
                </div>

                <div class="fields">
                  <div class="field">
                    <h4>Company</h4>
                    <p><?= htmlspecialchars( $contact['company']) ?></p>
                  </div>

                  <div class="field">
  <h4>Assigned To</h4>
  <p id="assignedTo">
    <?= htmlspecialchars(
        $contact['assigned_firstname']
            ? $contact['assigned_firstname'] . " " . $contact['assigned_lastname']
            : "Unassigned"
    ) ?>
  </p>
</div>

                </div>
              </div>

              <div class="btm">
                <div class="btm-title">
                  <img src="assets/note.png" />
                  <p>Notes</p>
                </div>

                <div class="notes" id="notesContainer">
  <?php foreach ($notes as $note): ?>
    <div class="note">
      <strong><?= htmlspecialchars($note['firstname'] . ' ' . $note['lastname']) ?></strong>
      <p class="text"><?= nl2br(htmlspecialchars($note['comment'])) ?></p>
      <p class="date"><?= date("F j, Y \\a\\t g:i a", strtotime($note['created_at'])) ?></p>
    </div>
  <?php endforeach; ?>
</div>


        <form id="noteForm" class="type-box">
  <label>Add a note about <?= htmlspecialchars($contact['firstname']) ?></label>

  <textarea
    name="comment"
    rows="4"
    required
    placeholder="Enter details here"
  ></textarea>

  <input type="hidden" name="contact_id" value="<?= $contact_id ?>">

  <div class="btn">
    <button type="submit">Add Note</button>
  </div>
</form>


              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
    <script src="contact-d.js"></script>

  </body>
</html>
