<?php
include_once '../db/connect.php';

//check if user logged in
if (!isset($_COOKIE["userId"])) {
	header('Location: ../index.php');
}
$userId = $_COOKIE["userId"];

//get price of membership
$price = $path = '';
if (isset($_GET["memberType"])) {
	$memberType = $_GET["memberType"];
	$data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE memberType LIKE '$memberType' AND active = 1");
	if (mysqli_num_rows($data) == 1) {
		$user = mysqli_fetch_assoc($data);
		$price = $user["price"];
		$path = $user["path"];
		$monthDuration = $user["monthDuration"];
	} else {
		header('Location: ../index.php?msg=' . $memberType . ' membership unavailable.<br>You may apply for another membership&type=neutral');
	}
}

//check if already a member
$someText = '';
$currentMembershipType = '';
if (isset($_COOKIE["currentMembershipType"])) {
	$currentMembershipType = $_COOKIE["currentMembershipType"];

	$data = mysqli_query($conn, "SELECT memId, membNo, active FROM membership WHERE userId = $userId AND memberType LIKE '$currentMembershipType'");
	$membership2 = mysqli_fetch_assoc($data);
	if (mysqli_num_rows($data) == 1) {
		$someText = 'CURRENT MEMBERSHIP: <b>' . $currentMembershipType . '</b> <br>';
		$someText .= '<br>REFERENCE No: <b>' . $membership2["membNo"] . '</b>';

		if ($membership2["active"] == 0) {
			$someText .= '<br><br><a href="../autoAddToCartService.php?payMembershipSubscription" class="btn btn-sm btn-light">Pay Now</a>';
		}
	} else {
		$someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b>. <br> Kind fill in and submit the form to get started';
	}
} else {
	$someText = 'Welcome <b>' . $_COOKIE["firstName"] . '</b>. <br> Kind fill in and submit the form to get started';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Apply For Membership</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="shortcut icon" type="image/x-icon" href="../images/mwfc_images/logos/logo1.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/style1.css">
	<!--===============================================================================================-->


</head>

<body>

	<!-- Toast msg -->
	<div class="toast m-3 text-center hide p-2 bg-white">
		<div class="toast-header">
			<span class="mdi mdi-message mdi-18px"></span>
			<strong class="mr-auto ml-2">INFO</strong>
			<button type="button" class="ml-2 mb-1 close toast-close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="toast-body p-4">
			Hello there, in the weldi!
		</div>
	</div>

	<div class="container-contact100">

		<div class="wrap-contact100">

			<form id="membershipForm" autocomplete="on" enctype="multipart/form-data">

				<div class="text-center">
					<img width="100" height="100" class="mb-4 mt-0" src="<?php echo $path; ?>" alt="">
					<h4 class="mb-4">Apply for <?php echo $_GET["memberType"]; ?> Membership</h4>
				</div>

				<label class="label-input100 bold-text text-label-green" for="firstName">First Name</label>
				<div class="wrap-input100  validate-input">
					<input class="input100" id="firstName" value="<?php echo $_COOKIE['firstName']; ?>" disabled>
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="lastName">Last Name</label>
				<div class="wrap-input100 validate-input">
					<input id="lastName" class="input100" type="text" value="<?php echo $_COOKIE['lastName']; ?>" disabled>
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="email">Email</label>
				<div class="wrap-input100 validate-input">
					<input id="email" class="input100" type="text" value="<?php echo $_COOKIE['email']; ?>" disabled>
					<span class="focus-input100"></span>
				</div>


				<label class="label-input100 bold-text text-label-green" for="profilePic">Profile Picture | <i class="font-x-small">Allowed Formats: (.jpg / .png)</i></label>
				<div class="wrap-input100 validate-input">
					<input id="profilePic" class="input100" name="image[]" data-toggle="tooltip" title="Max Size: 5MB." style="padding-top: 10px;" type="file" accept="image/*">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="nrc">NRC Number</label>
				<div class="wrap-input100  validate-input">
					<input id="nrc" class="input100 formatNRC" type="text" name="nrc" placeholder="Eg. 112233/44/5" value="<?php echo $nrc ?>">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="gender">Gender</label>
				<div class="wrap-input100  validate-input">
					<select id="gender" class="form-control input100 border-none" name="gender">
						<option>- Select -</option>
						<option <?php if ($gender == 'Male') {
									echo 'selected';
								} ?> value="Male">Male</option>
						<option <?php if ($gender == 'Female') {
									echo 'selected';
								} ?> value="Female">Female</option>
						<option <?php if ($gender == 'Other') {
									echo 'selected';
								} ?> value="Other">Other</option>
					</select>
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="contact">Phone Number</label>
				<div class="wrap-input100">
					<input id="contact" class="input100" type="text" name="contact" value="<?php echo $contact ?>" placeholder="Eg. 09/07...">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="country">Country</label>
				<div class="wrap-input100  validate-input">
					<select id="country" class="form-control input100 border-none" name="country">
						<?php
						include_once 'countriesList.php';
						?>
					</select>
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="town">Town</label>
				<div class="wrap-input100 validate-input">
					<input id="town" class="input100" type="text" name="town" value="<?php echo $town ?>">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100 bold-text text-label-green" for="address">Physical Address</label>
				<div class="wrap-input100  validate-input">
					<textarea id="address" class="input100" type="text" name="address" placeholder="Current Physical Address"><?php echo $address ?></textarea>
				</div>

				<input type="hidden" name="memberType" value="<?php echo $_GET["memberType"]; ?>">

				<div class="container-contact100-form-btn ">
					<p class="membershipFormMsg"></p>
				</div>

				<div class="container-contact100-form-btn membershipSubmitBtn">
					<button class="contact100-form-btn submitBtn" type="submit">
						Submit
					</button>
				</div>

				<div class="container-contact100-form-btn makePaymentBtn hide text-center">
					<a class="contact100-form-btn submitBtn text-white" href="../autoAddToCartService.php?payMembershipSubscription">
						Make Payment (K <?php echo $price; ?>)
					</a>
					<br>
					<a href="../index.php" class="italic text-underline">Pay Later</a>
				</div>


			</form>

			<div class="contact100-more">

				<a href="../index.php" data-toggle="tooltip" title="Go Back Home" class="fa fa-home fa-2x text-white home_link p-3"></a>

				<div class="dropdown altText">
					<button type="button" class="btn btn-white bg-white btn-sm dropdown-toggle" style="border-radius:0px;" data-toggle="dropdown">
						Memberships
					</button>
					<div class="dropdown-menu">
						<?php
						$data = mysqli_query($conn, "SELECT * FROM membershipConfig WHERE active = 1");
						while ($result = mysqli_fetch_assoc($data)) {
							echo '<a class="dropdown-item" href="membershipForm.php?memberType=' . $result["memberType"] . '">' . $result["memberType"] . '</a>';
						}
						?>

					</div>
				</div>

				<div class="flex-w p-b-1">
					<div class="dis-flex p-b-47 text-center">
						<div class="flex-col">
							<h4 class="text-white m-4 line-height-2">
								<img width="100" height="100" class="block center-img" src="../images/mwfc_images/logos/logo1.png" alt="logo">
								Mufulira Wanderers <br>
								<?php echo $_GET["memberType"]; ?> Membership
								<hr class="bg-white">
								Fee: K
								<?php
								$DisplayMonthDuration = '';
								if ($monthDuration == 0) {
									$DisplayMonthDuration = '';
								} elseif ($monthDuration == 1) {
									$DisplayMonthDuration = '(Per Month)';
								} elseif ($monthDuration == 3) {
									$DisplayMonthDuration = '(Per 3 Month)';
								} elseif ($monthDuration == 6) {
									$DisplayMonthDuration = '(Per 6 Month)';
								} elseif ($monthDuration == 12) {
									$DisplayMonthDuration = '(Per Year)';
								}
								echo $price . ' ' . $DisplayMonthDuration;

								?>
								<?php if (isset($_GET["msg"]) && ($_GET["type"] == "success")) {
									echo '<br><br><br>' . $_GET["msg"];
								} ?>
							</h4>
						</div>
					</div>
				</div>

				<!-- Type Some Text-->
				<div class="flex-w p-b-47">
					<div class="dis-flex p-b-47 text-center">
						<div class="flex-col">
							<p class="text-white someText">
								<i class="fa fa-circle fa-xs text-white"></i>
								<?php echo $someText; ?>
							</p>
						</div>
					</div>
				</div>

				<!-- Type Some Text-->
				<div class="flex-w p-b-47">
					<div class="dis-flex p-b-47 text-center">
						<div class="flex-col">
							<p class="text-white someText">
								<i class="fa fa-circle fa-xs text-white"></i>
								Need some assistance? <br>
								Feel free to contact our <a class="text-white text-underline" target="_blank" href="mailto:support@mufulirawanderers.com?Subject=Hello Support Team">support team</a>
							</p>
						</div>
					</div>
				</div>

			</div>

		</div>
		<!-- </div> -->



		<div id="dropDownSelect1"></div>

		<!--===============================================================================================-->
		<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/bootstrap/js/popper.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/daterangepicker/moment.min.js"></script>
		<script src="../script/cartControls.js"></script>
		<script src="../script/membershipForm.js"></script>


		<script src="vendor/daterangepicker/daterangepicker.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/countdowntime/countdowntime.js"></script>
		<!--===============================================================================================-->
		<script src="js/main.js"></script>
		<script src="../script/toastManager.js"></script>
		<script src="../script/NRC_Formatting.js"></script>


		<?php
		//DISPLAY MSG-----------------------------------------------------------------
		if (isset($_GET["msg"]) && isset($_GET["type"])) {
			echo '
				<script>
					$(document).ready(function () {
						toastMe("' . $_GET["msg"] . '", "' . $_GET["type"] . '", 120);
					});
				</script>
			';
		}
		?>
</body>

</html>