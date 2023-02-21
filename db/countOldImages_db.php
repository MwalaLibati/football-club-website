<?php
include_once 'connect.php';

//COLLECT UNUSED PRE-EXISTING IMAGES
$imagesToDelete = array(); //store old images to be deleted
$pathsToDelete = array(); //store unused paths images to be deleted
$uploadFoldersPaths = array( //add new array path if new folder created in UPLOADS root folder
	"../images/uploads/membership_type_images/*.*",
	"../images/uploads/profile_pictures/*.*",
	"../images/uploads/homepage_banners/*.*",
	"../images/uploads/products/*.*"
);

//Collect unused images from folders
foreach ($uploadFoldersPaths as $uploadFoldersPath) { //loop through folder by folder
	foreach (glob($uploadFoldersPath) as $dirPath) { //loop through each file in current folder
		$data = mysqli_query($conn, "SELECT path FROM `sysfiles`");
		if (mysqli_num_rows($data) > 0) { //if tables have records
			$imgFound = false;
			while ($result = mysqli_fetch_assoc($data)) {
				$dbPath = $result["path"];
				if (strpos($dirPath, $dbPath)) { //if image from directory is found in db
					$imgFound = true;
					break;
				} else {
					if (!in_array($dbPath, $pathsToDelete)) {
						if (!file_exists("../" . $dbPath)) {
							array_push($pathsToDelete, $dbPath);
						}
					}
				}
			} //end while()
			if (!$imgFound && !strpos($dirPath, 'test.png')) { //if useless image is found, keep it in '$imagesToDelete' array
				array_push($imagesToDelete, $dirPath);
			}
		} //end if()
	} //end foreach()
} //end outer foreach()
