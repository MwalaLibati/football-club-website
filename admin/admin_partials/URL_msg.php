<?php
if (isset($_GET["msg"])) {

  if ($_GET["type"] == 'success') {
    $class = 'success';
    $icon = '<h5><i class="icon fas fa-check"></i> Success!</h5>';
  } elseif ($_GET["type"] == 'error') {
    $class = 'danger';
    $icon = '<h5><i class="icon fas fa-ban"></i> Error!</h5>';
  } elseif ($_GET["type"] == 'neutral') {
    $class = 'info';
    $icon = '<h5><i class="icon fas fa-info"></i> Info!</h5>';
  } else {
    $class = 'info';
    $icon = '<h5><i class="icon fas fa-info"></i> Info!</h5>';
  }
  echo '<div class="alert alert-' . $class . ' alert-dismissible m-1">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          ' . $icon . '
          ' . $_GET["msg"] . '
        </div>';
}
