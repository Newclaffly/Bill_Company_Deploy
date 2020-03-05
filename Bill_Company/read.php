<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>เปิดอ่านข้อมูล</title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php
      session_start();
      if ($_SESSION['permis'] == "Supplier") {
      ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="history.php">หน้าหลัก <span class="sr-only">(current)</span></a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li> -->
          </ul>
        <?php
      } else {
        ?>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="history_member.php">หน้าหลัก <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
          </ul>
        <?php } ?>
        <ul class="navbar-nav ml-auto">
          <?php if (isset($_SESSION['id'])) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ยินดีต้อนรับคุณ <?php echo $_SESSION['username'];
                                $user = $_SESSION['username']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link " href="login.php" tabindex="-1" aria-disabled="true">Login</a>
            </li>
          <?php } ?>
        </ul>
        </div>
    </div>
  </nav>
  <?php
  ini_set('display_errors', 1);
  error_reporting(~0);

  $strCustomerID = null;

  if (isset($_GET["id"])) {
    $strCustomerID = $_GET["id"];
  }
  date_default_timezone_set('Asia/Bangkok');
  include_once('connect.php');

  $sql = "SELECT * FROM bill_data_message WHERE id = '" . $strCustomerID . "' ";

  $query = mysqli_query($conn, $sql);

  $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
  $date = date('Y-m-d h:i:s');
  ?>
  <div class="container">
    <div class="mx-auto mt-5">
      <h1 align="center">เปิดอ่านข้อมูล</h1>
    </div>
    <form action="save_read.php" name="frmAdd" method="POST">
      <input type="hidden" name="txtid" value="<?php echo $result["id"]; ?>">
      <input type="hidden" name="txtpo" size="20" value="<?php echo $result["po"]; ?>">
      <input type="hidden" name="txtheader" size="20" value="<?php echo $result["header"]; ?>">
      <input type="hidden" name="txtprocess" size="2" value="Success">
      <input type="hidden" name="txtowner" size="5" value="<?php echo $result["owner"]; ?>">
      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <td><input type="hidden" name="txtid" class="form-control" value="<?php echo $result["id"]; ?>" disabled><?php echo $result["id"]; ?></td>
        </tr>
        <tr>
          <th>Po</th>
          <td><input type="text" name="txtpo" class="form-control" value="<?php echo $result["po"]; ?>" disabled></td>
        </tr>
        <tr>
          <th>Header</th>
          <td><input type="text" name="txtheader" class="form-control" value="<?php echo $result["header"]; ?>" disabled></td>
        </tr>
        <tr>
          <th>Process</th>
          <td><input type="text" name="txtprocess" class="form-control" value="<?php echo $result["process"]; ?>" disabled></td>
        </tr>
        <tr>
          <th>Owner</th>
          <td><input type="hidden" name="txtowner" class="form-control" value="<?php echo $result["owner"]; ?>" disabled><?php echo $result["owner"]; ?></td>

        </tr>
      </table>
      <!-- <input type="submit" name="submit" class="btn btn-success float-right" value="ยินยันการแก้ไขข้อมูล"> -->
    </form>
  </div>
  <?php
  mysqli_close($conn);
  ?>


  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
</body>

</html>