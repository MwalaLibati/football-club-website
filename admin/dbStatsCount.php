<?php

//count memberType
$memberUI = '';
$memberIndexUI = '';
$membershipCount = 0;
$data = mysqli_query($conn, "SELECT COUNT(memId) AS num, memberType FROM membership GROUP BY memberType");
while ($result = mysqli_fetch_assoc($data)) {
  $memberUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">' . $result["memberType"] . '<span class="badge badge-primary badge-pill font-large">' . $result["num"] . '</span></li>';
  $memberIndexUI .= '<a>' . $result["memberType"] . ' Members = ' . $result["num"] . '</a><br>';
  $membershipCount += $result["num"];
}

//count active memberships
$data = mysqli_query($conn, "SELECT COUNT(memId) AS num, active FROM membership GROUP BY active");
while ($result = mysqli_fetch_assoc($data)) {
  if ($result["active"] == 1) {
    $memberUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">Paid Up Members<span class="badge badge-success badge-pill font-large">' . $result["num"] . '</span></li>';
  } elseif ($result["active"] == 0) {
    $memberUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">UnPaid Members<span class="badge badge-danger badge-pill font-large">' . $result["num"] . '</span></li>';
  }
}

//count all users
$data = mysqli_query($conn, "SELECT userId FROM users");
$userCount = mysqli_num_rows($data);

//count active users
$userUI = '';
$userIndexUI = '';
$userCount = 0;
$data = mysqli_query($conn, "SELECT COUNT(userId) AS num, active FROM users GROUP BY active");
while ($result = mysqli_fetch_assoc($data)) {
  if ($result["active"] == 1) {
    $active = 'Active';
    $userUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">Active Users<span class="badge badge-success badge-pill font-large">' . $result["num"] . '</span></li>';
  } elseif ($result["active"] == 0) {
    $active = 'Non Active';
    $userUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">Non Active Users<span class="badge badge-danger badge-pill font-large">' . $result["num"] . '</span></li>';
  }
  $userIndexUI .= '<a>' . $active . ' users = ' . $result["num"] . '</a><br>';
  $userCount += $result["num"];
}

//count all products
$data = mysqli_query($conn, "SELECT prodId FROM products");
$productsCount = mysqli_num_rows($data);

//count active products
$productsUI = '';
$productsIndexUI = '';
$productsCount = 0;
$data = mysqli_query($conn, "SELECT COUNT(prodId) AS num, active FROM products GROUP BY active");
while ($result = mysqli_fetch_assoc($data)) {
  if ($result["active"] == 1) {
    $stock = 'Available';
    $productsUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">Product Available<span class="badge badge-success badge-pill font-large">' . $result["num"] . '</span></li>';
  } elseif ($result["active"] == 0) {
    $stock = 'Unavailable';
    $productsUI .= '<li class="list-group-item d-flex justify-content-between align-items-center hover-white-light-bg">Product Unavailable<span class="badge badge-danger badge-pill font-large">' . $result["num"] . '</span></li>';
  }
  $productsIndexUI .= '<a>' . $result["num"] . ' Product ' . $stock . '</a><br>';
  $productsCount += $result["num"];
}

//count all unread inbox
$data = mysqli_query($conn, "SELECT contactId FROM contactus WHERE markRead = 0");
$inboxCount = mysqli_num_rows($data);
if (!isset($inboxCount) || empty($inboxCount)) {
  $inboxCount = 0;
}
