<?php

if (!isset($_GET["email"]) || empty($_GET["email"]) || !isset($_GET["contactId"]) || empty($_GET["contactId"])) {
  header('Location: inbox.php');
}

include_once 'admin_partials/header.php';
include_once '../db/timeAgo.php';

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
            <li class="breadcrumb-item active">Compose Mail</li>
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
        <form class="col-md-9" id="composedMsgForm">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Compose New Message</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-append">
                    <span class="input-group-text">To</span>
                  </div>
                  <input type="text" name="email" class="form-control" value="<?php echo $_GET["email"]; ?>">
                </div>
              </div>

              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-append">
                    <span class="input-group-text">Subject:</span>
                  </div>
                  <input type="text" name="subject" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <textarea id="compose-textarea" name="comment" placeholder="Body..." class="form-control" style="height: 300px"></textarea>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="float-left composedMsgMsg">
              </div>
              <div class="float-right">
                <input type="hidden" name="contactId" value="<?php echo $_GET["contactId"]; ?>">
                <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
              </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </form>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>