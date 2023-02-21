<?php
include_once 'admin_partials/header.php';

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
          <h1>Inbox</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Inbox</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- <a href="compose.html" class="btn btn-primary btn-block mb-3">Compose</a> -->

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
                <a href="#!" class="nav-link reloadInbox">
                  <i class="fas fa-envelope text-warning"></i> Inbox
                  <span class="badge float-right"><?php echo $inboxCount; ?> New</span>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link">
                  <i class="fas fa-envelope-open text-gray"></i> Old
                  <span class="badge float-right"><?php echo $oldMsgCount; ?></span>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="#" class="nav-link sentMsgBtn">
                  <i class="fas fa-reply text-info"></i> Replies
                  <span class="badge float-right"><?php echo $replyCount; ?></span>
                </a>
              </li> -->
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h4 class="card-title font-large inboxNewLabel">New <i class="fas fa-angle-down p-1 text-dark"></i></h4>

            <div class="card-tools">
              <button type="button" class="btn btn-default btn-sm reloadInbox" data-toggle="tooltip" title="Reload">
                <i class="fas fa-sync-alt"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive mailbox-messages" style="max-height: 500px;">
              <table class="table table-head-fixed text-nowrap table-hover table-striped">
                <tbody class="listOfMsgs">

                </tbody>
              </table>
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'admin_partials/footer.php'; ?>