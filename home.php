<?php

// Start the session.
include "includes/session.php";

// Load the helper function.
include "includes/functions.php";

// Connect to the database.
include "config/database.php";

// Allow only logged-in users to open this page.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Get the id of the logged-in user from the session.
$userId = $_SESSION["user_id"];
$message = "";
$errors = [];
$editNote = null;
$requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";

// Show a simple message after create, update, or delete.
if (isset($_GET["message"])) {
    if ($_GET["message"] == "created") {
        $message = "Note created successfully.";
    }

    if ($_GET["message"] == "updated") {
        $message = "Note updated successfully.";
    }

    if ($_GET["message"] == "deleted") {
        $message = "Note deleted successfully.";
    }
}

// Create, update, and delete are handled here.
if ($requestMethod == "POST") {
    // Read the hidden action value from the form.
    $action = $_POST["action"] ?? "";

    // CREATE: add a new note.
    if ($action == "create") {
        $title = trim($_POST["title"] ?? "");
        $body = trim($_POST["body"] ?? "");

        // Make sure both fields are filled in.
        if ($title == "" || $body == "") {
            $errors[] = "Title and description are required.";
        } else {
            // Save the new note in the notes table.
            $insertNote = $conn->prepare("INSERT INTO notes (user_id, title, body) VALUES (?, ?, ?)");
            $insertNote->bind_param("iss", $userId, $title, $body);
            $insertNote->execute();

            // Redirect so the page reloads with a success message.
            header("Location: home.php?message=created");
            exit;
        }
    }

    // UPDATE: change an existing note.
    if ($action == "update") {
        $noteId = $_POST["note_id"] ?? "";
        $title = trim($_POST["title"] ?? "");
        $body = trim($_POST["body"] ?? "");

        // Make sure all update fields were filled in.
        if ($noteId == "" || $title == "" || $body == "") {
            $errors[] = "All update fields are required.";
        } else {
            // Update only the selected note that belongs to this user.
            $updateNote = $conn->prepare("UPDATE notes SET title = ?, body = ? WHERE id = ? AND user_id = ?");
            $updateNote->bind_param("ssii", $title, $body, $noteId, $userId);
            $updateNote->execute();

            // Redirect so the page reloads with a success message.
            header("Location: home.php?message=updated");
            exit;
        }
    }

    // DELETE: remove an existing note.
    if ($action == "delete") {
        $noteId = $_POST["note_id"] ?? "";

        if ($noteId != "") {
            // Delete only the selected note that belongs to this user.
            $deleteNote = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
            $deleteNote->bind_param("ii", $noteId, $userId);
            $deleteNote->execute();

            // Redirect so the page reloads with a success message.
            header("Location: home.php?message=deleted");
            exit;
        }
    }
}

// Load one note into the form when the user clicks edit.
if (isset($_GET["edit"])) {
    $noteId = $_GET["edit"];
    $findNote = $conn->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
    $findNote->bind_param("ii", $noteId, $userId);
    $findNote->execute();
    $result = $findNote->get_result();
    $editNote = $result->fetch_assoc();
}

// Read all notes for the logged-in user.
$notes = [];
$listNotes = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC");
$listNotes->bind_param("i", $userId);
$listNotes->execute();
$result = $listNotes->get_result();

// Put each note into the $notes array so it can be shown in the table.
while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="page dashboard-layout">
        <div class="dashboard-top">
            <div>
                <p class="muted">Home page</p>
                <h1>Welcome, <?php echo show($_SESSION["user_name"]); ?></h1>
                <p class="intro-text">
                    This page shows session login and CRUD in one place.
                </p>
            </div>

            <div class="actions">
                <a class="button secondary" href="index.php">Landing Page</a>
                <a class="button" href="logout.php">Logout</a>
            </div>
        </div>

        <?php // Show success messages after create, update, or delete. ?>
        <?php if ($message != ""): ?>
            <div class="flash success"><?php echo show($message); ?></div>
        <?php endif; ?>

        <?php // Show validation errors if they exist. ?>
        <?php if (!empty($errors)): ?>
            <div class="flash error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo show($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="grid">
            <article class="card">
                <h2>Create Note</h2>
                <p class="intro-text">This is the Create part of CRUD.</p>

                <form method="POST">
                    <input type="hidden" name="action" value="create">

                    <label>
                        Title
                        <input type="text" name="title" required>
                    </label>

                    <label>
                        Description
                        <textarea name="body" required></textarea>
                    </label>

                    <button type="submit">Save Note</button>
                </form>
            </article>

            <article class="card">
                <h2>Update Note</h2>
                <p class="intro-text">This is the Update part of CRUD.</p>

                <form method="POST">
                    <input type="hidden" name="action" value="update">

                    <label>
                        Note ID
                        <input type="number" name="note_id" value="<?php echo show($editNote["id"] ?? ""); ?>" required>
                    </label>

                    <label>
                        Title
                        <input type="text" name="title" value="<?php echo show($editNote["title"] ?? ""); ?>" required>
                    </label>

                    <label>
                        Description
                        <textarea name="body" required><?php echo show($editNote["body"] ?? ""); ?></textarea>
                    </label>

                    <div class="form-actions">
                        <button type="submit">Update Note</button>
                        <a class="button secondary" href="home.php">Clear Form</a>
                    </div>
                </form>
            </article>
        </section>

        <section class="card">
            <h2>Your Notes</h2>
            <p class="intro-text">This table shows the Read and Delete parts of CRUD.</p>

            <?php if (empty($notes)): ?>
                <div class="empty-state">No notes found.</div>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // Loop through all notes and print one table row for each note. ?>
                            <?php foreach ($notes as $note): ?>
                                <tr>
                                    <td><?php echo show($note["id"]); ?></td>
                                    <td><?php echo show($note["title"]); ?></td>
                                    <td><?php echo nl2br(show($note["body"])); ?></td>
                                    <td><?php echo show($note["created_at"]); ?></td>
                                    <td><?php echo show($note["updated_at"]); ?></td>
                                    <td>
                                        <div class="form-actions">
                                            <a class="button secondary" href="home.php?edit=<?php echo show($note["id"]); ?>">Edit</a>

                                            <form class="mini-form" method="POST">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="note_id" value="<?php echo show($note["id"]); ?>">
                                                <button class="danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
