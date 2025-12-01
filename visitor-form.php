<?php
include 'Functions/visitor_functions.php';
session_start();

// kung may ID sa URL → edit mode
$visitor = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $all = getAllVisitors();
    foreach ($all as $v) {
        if ($v['id'] == $id) {
            $visitor = $v;
            break;
        }
    }
}

// kapag nag-submit ang form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $_POST['name'];
    $contact = $_POST['contact_number'];
    $address = $_POST['address'];
    $school  = $_POST['school_office'];
    $purpose = $_POST['purpose'];
    $date    = $_POST['date_of_visit'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // update existing visitor
        $id = $_POST['id'];
        if (updateVisitor($id, $name, $date, $contact, $address, $school, $purpose)) {
            $_SESSION['message'] = "Visitor updated successfully!";
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Error updating visitor.";
        }
    } else {
        // add new visitor
        if (addVisitor($name, $date, $contact, $address, $school, $purpose)) {
            $_SESSION['message'] = "New visitor added successfully!";
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Error adding visitor.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <title><?= $visitor ? 'Edit Visitor' : 'Add Visitor' ?></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container mt-4">
  <h2><?= $visitor ? 'Edit Visitor' : 'Add New Visitor' ?></h2>
  <form method="post">
    <?php if ($visitor): ?>
      <input type="hidden" name="id" value="<?= $visitor['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" 
             value="<?= $visitor['name'] ?? '' ?>" required>
    </div>
    <div class="form-group">
      <label>Contact #</label>
      <input type="text" name="contact_number" class="form-control"
             value="<?= $visitor['contact_number'] ?? '' ?>">
    </div>
    <div class="form-group">
      <label>Address</label>
      <input type="text" name="address" class="form-control"
             value="<?= $visitor['address'] ?? '' ?>">
    </div>
    <div class="form-group">
      <label>School/Office</label>
      <input type="text" name="school_office" class="form-control"
             value="<?= $visitor['school_office'] ?? '' ?>">
    </div>
    <div class="form-group">
      <label>Purpose</label>
      <select name="purpose" class="form-control" required>
        <option <?= ($visitor['purpose'] ?? '')=='Exam'?'selected':'' ?>>Exam</option>
        <option <?= ($visitor['purpose'] ?? '')=='Inquiry'?'selected':'' ?>>Inquiry</option>
        <option <?= ($visitor['purpose'] ?? '')=='Visit'?'selected':'' ?>>Others</option>
      </select>
    </div>
    <div class="form-group">
      <label>Date of Visit</label>
      <input type="date" name="date_of_visit" class="form-control"
             value="<?= $visitor['date_of_visit'] ?? '' ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
