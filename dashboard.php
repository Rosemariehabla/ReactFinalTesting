<?php
include 'Functions/visitor_functions.php';
$title = 'Dashboard';
session_start();

// protect dashboard: redirect kung walang login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// counts
$todayCount   = countToday();
$examCount    = countByCategory('Exam');
$visitCount   = countByCategory('Visit');
$inquiryCount = countByCategory('Inquiry');

// default visitors
$visitors = getAllVisitors();

// kung may delete request sa URL
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if (deleteVisitor($id)) {
        $_SESSION['message'] = "Visitor deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting visitor.";
    }
    header("Location: dashboard.php");
    exit;
}

// filter by date
if (isset($_POST['filter_date']) && !empty($_POST['filter_date'])) {
    $date = $_POST['filter_date'];
    $visitors = getVisitorsByDate($date);
    $_SESSION['message'] = "Filtered visitors for $date";
}

?>
<!doctype html>
<html lang="en">
  <?php include 'components/head.php'; ?>
  <body>
    <?php include 'components/nav-bar.php'; ?>

    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar Menu -->
        <?php include 'components/side-bar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
                      align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>        
          </div>

          <!-- Success Message -->
          <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
              <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
          <?php endif; ?>

          <!-- Stats -->
          <div class="row text-center mb-4">
            <div class="col-3 bg-light p-3 border">
              <h6>Visitors Today</h6>
              <h2><?= $todayCount ?></h2>
            </div>
            <div class="col-3 bg-light p-3 border">
              <h6>Exam</h6>
              <h2><?= $examCount ?></h2>
            </div>
            <div class="col-3 bg-light p-3 border">
              <h6>Visit</h6>
              <h2><?= $visitCount ?></h2>
            </div>
            <div class="col-3 bg-light p-3 border">
              <h6>Inquiry</h6>
              <h2><?= $inquiryCount ?></h2>
            </div>
          </div>

          <!-- Add + Filter Section -->
           <div class="d-flex justify-content-between mb-3 mt-4">
            <a href="visitor-form.php" class="btn btn-primary">
              <i class="fas fa-user-plus"></i> Add New Visitor
            </a>
            <form class="form-inline" method="post">
              <label for="filter_date" class="mr-2">Filter by Date:</label>
              <input type="date" name="filter_date" id="filter_date" class="form-control mr-2">
              <button type="submit" class="btn btn-secondary">
                <i class="fas fa-filter"></i> Filter
              </button>
            </form>
              </div>
          <!-- Visitor Table -->
          <div class="mt-4">
            <h3>All Visitors</h3>
            <table class="table table-bordered">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Date of Visit</th>
                  <th>Purpose</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($visitors as $v): ?>
                  <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['name'] ?></td>
                    <td><?= $v['date_of_visit'] ?></td>
                    <td><?= $v['purpose'] ?></td>
                    <td class="text-center">
                      <!-- Edit Button -->
                      <a href="visitor-form.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-warning mr-1">
                        <i class="fas fa-pen"></i>
                      </a>
                      <!-- Delete Button -->
                      <a href="dashboard.php?delete_id=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this visitor?')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>
