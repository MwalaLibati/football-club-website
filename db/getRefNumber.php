<?php

//Generate Unique Ref Number------------------------------------------------------
function getRef($refType, $conn)
{
	while (true) {
		$refNo = time() . rand(10 * 45, 100 * 98);
		$data = mysqli_query($conn, "SELECT refNo FROM refs WHERE refType = '$refType' AND refNo = '$refNo'");
		if (mysqli_num_rows($data) == 0) {
			$sql = "INSERT INTO refs (refType, refNo) VALUES ('$refType', '$refNo')";
			if (mysqli_query($conn, $sql)) {
				break;
			}
		}
	} //end while()
	return $refType . "-" . $refNo;
} //end getRef()