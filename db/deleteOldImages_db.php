<?php
//COLLECT & DELETE PRE EXISTING IMAGES
include_once 'connect.php';
include_once 'fileUploadManager.php';
include_once 'countOldImages_db.php';

//delete all old collected images
$deleteCount = 0;
foreach ($imagesToDelete as $path) {
	if (file_exists($path) && !strpos($path, 'test.png')) { //check if useless file exists in folders
		if (unlink($path)) { //delete it
			$deleteCount++;
		} //end if()
	} //end if()
} //end foreach()


//delete unused paths
$deletePathCount = 0;
foreach ($pathsToDelete as $path) {
	if (!file_exists('../' . $path) && !strpos($path, 'test.png')) { //check if useless file exists in folders
		if (deleteFile("path", $path, $conn)) { //delete it
			$deletePathCount++;
		}
	} //end if()
} //end foreach()

if ($deleteCount > 0 || $deletePathCount > 0) { //user feedback message
	header('Location: ../admin/fileManger.php?msg=' . $deleteCount . ' images deleted<br>' . $deletePathCount . ' database paths deleted&type=success');
} else {
	header('Location: ../admin/fileManger.php?msg=No images deleted&type=error');
}
