<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: loginform.php');
    exit;
}

include 'db.php';

$teacherId = $_SESSION['teacher_id'];
$stmt = $conn->prepare("SELECT username FROM teachers WHERE id = ?");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$stmt->bind_result($teacherName);
$stmt->fetch();
$stmt->close();

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="portal-container">
        <h2>Welcome to the Teacher Portal</h2>
        <div id="logout">
            <span style="margin-left: 330px;">Welcome, <?php echo htmlspecialchars($teacherName); ?>!<button
                    id="logout-btn">Logout</button></span>
        </div>
        <br><br>
        <button id="add-student-btn"
            style="padding: 8px;background-color: blue;border: none;border-radius: 4px;color: #fff;cursor: pointer;font-size: 14px;">Add
            New Student</button>
        <table id="student-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr data-id="<?= $row['id'] ?>">
                        <td contenteditable="true" class="editable" data-field="name"><?= htmlspecialchars($row['name']) ?>
                        </td>
                        <td contenteditable="true" class="editable" data-field="subject">
                            <?= htmlspecialchars($row['subject']) ?>
                        </td>
                        <td contenteditable="true" class="editable" data-field="marks">
                            <?= htmlspecialchars($row['marks']) ?>
                        </td>
                        <td>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div id="add-student-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Student</h2>
                <form id="add-student-form">
                    <div class="form-group">
                        <label for="student-name">Name:</label>
                        <input type="text" id="student-name" name="student-name" required>
                    </div>
                    <div class="form-group">
                        <label for="student-subject">Subject:</label>
                        <input type="text" id="student-subject" name="student-subject" required>
                    </div>
                    <div class="form-group">
                        <label for="student-marks">Marks:</label>
                        <input type="number" id="student-marks" name="student-marks" required>
                    </div>
                    <button type="submit" style="padding: 8px;background-color: #4caf50;border: none;border-radius: 4px;color: #fff;cursor: pointer;font-size: 14px;">Add Student</button>
                    <div id="add-error" class="error-message"></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const modal = $('#add-student-modal');
            const closeModalBtn = $('.close');
            const addStudentForm = $('#add-student-form');
            const addError = $('#add-error');

            $('#add-student-btn').on('click', function () {
                modal.show();
            });

            closeModalBtn.on('click', function () {
                modal.hide();
            });

            addStudentForm.on('submit', function (e) {
                e.preventDefault();

                const name = $('#student-name').val().trim();
                const subject = $('#student-subject').val().trim();
                const marks = $('#student-marks').val().trim();

                addError.text('');

                if (name === '' || subject === '' || marks === '') {
                    addError.text('Please fill in all fields.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'add_student.php',
                    data: { name: name, subject: subject, marks: marks },
                    success: function (response) {
                        if (response === 'success') {
                            window.location.reload();
                        } else {
                            addError.text(response);
                        }
                    }
                });
            });

            $('.delete-btn').on('click', function () {
                const row = $(this).closest('tr');
                const studentId = row.data('id');

                $.ajax({
                    type: 'POST',
                    url: 'delete_student.php',
                    data: { id: studentId },
                    success: function (response) {
                        if (response === 'success') {
                            row.remove();
                        } else {
                            alert(response);
                        }
                    }
                });
            });

            $('.editable').on('blur', function () {
                const field = $(this).data('field');
                const value = $(this).text().trim();
                const row = $(this).closest('tr');
                const studentId = row.data('id');

                $.ajax({
                    type: 'POST',
                    url: 'update_student.php',
                    data: { id: studentId, field: field, value: value },
                    success: function (response) {
                        if (response !== 'success') {
                            alert(response);
                        }
                    }
                });
            });

            $('#logout-btn').on('click', function () {
                window.location.href = 'logout.php';
            });
        });
    </script>
</body>

</html>