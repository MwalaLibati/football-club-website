<?php
if (!isset($_GET["contactId"])) {
  header('Location: inbox.php');
}
include_once 'admin_partials/header.php';
include_once '../db/timeAgo.php';


//get unread mail
$data = mysqli_query($conn, "SELECT * FROM contactus WHERE contactId = " . $_GET["contactId"]);
if (mysqli_num_rows($data) != 1) {
  header('Location: inbox.php');
}

//get email details
$result = mysqli_fetch_assoc($data);

if (!mysqli_query($conn, "UPDATE contactus SET markRead = 1 WHERE contactId = " . $_GET["contactId"])) {
  header('Location: inbox.php');
}


//get unread mail
$data = mysqli_query($conn, "SELECT contactId FROM contactus WHERE markRead = 0");
$inboxCount = mysqli_num_rows($data);

//get unread mail
$data = mysqli_query($conn, "SELECT contactId FROM contactus WHERE markRead = 1");
$oldMsgCount = mysqli_num_rows($data);

//get sent mail 
$data = mysqli_query($conn, "SELECT replyId FROM adminreplys");
$replyCount = mysqli_num_rows($data);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Compose</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="inbox.php">Inbox</a></li>
            <li class="breadcrumb-item active">Read Mail</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <a href="inbox.php" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Folders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="inbox.php" class="nav-link">
                    <i class="fas fa-envelope text-warning"></i> Inbox
                    <span class="badge float-right"><?php echo $inboxCount; ?> New</span>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link">
                    <i class="fas fa-envelope-open text-gray"></i> Old
                    <span class="badge float-right"><?php echo $oldMsgCount; ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link comingSoon">
                    <i class="fa fa-paper-plane text-info"></i> Sent
                    <span class="badge float-right"><?php echo $replyCount; ?></span>
                  </a>
                </li> -->
              </ul>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h4 class="card-title">Read Mail</h4>
              <div class="card-tools">
                <a href="composeMsg.php?email=<?php echo $result["email"]; ?>&contactId=<?php echo $_GET["contactId"]; ?>" class="btn btn-default btn" data-container="body">
                  <i class="fas fa-reply"></i> Reply
                </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <b class="mb-2 block font-x-large">From: <?php echo $result["fullName"]; ?></b>
                <h6>Email: <?php echo $result["email"]; ?>
                  <span class="mailbox-read-time float-right">
                    <?php
                    $dt = new DateTime($result["contactDate"]);
                    echo $dt->format('d-m-Y | h:m A') . '<br>' . getTimeAgo($result["contactDate"]);
                    ?>
                  </span>
                </h6>
              </div>

              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <b>Hello Support Team,</b>
                <br>
                <br>
                <p><?php echo $result["comment"]; ?></p>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-footer -->
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->





          <?php

          $contactId = $_GET["contactId"];
          $sent = mysqli_query($conn, "SELECT * FROM adminreplys WHERE contactId = " . $contactId);

          while ($result = mysqli_fetch_assoc($sent)) {

            $dt = new DateTime($result["replyDate"]);
            echo '<div class="card card-dark card-outline">
                  <div class="card-body p-0">
                    <div class="mailbox-read-info pb-5">
                      <b class="mb-2 block font-small float-left">Admin Reply</b>
                      <span class="mailbox-read-time float-right">
                        ' . $dt->format('d-m-Y | h:m A') . '<br>' . getTimeAgo($result["replyDate"]) . '
                      </span>
                    </div>
                    <div class="mailbox-read-message">
                      <br>
                      <p>' . $result["comment"] . '</p>
                    </div>
                  </div>
                </div>';
          }
          ?>


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>