<?php
//(DO NOT PUT A '/' IN FRONT OR BEHIND THE 'path' PARAMETER WHEN CALLING THIS FUNCTION)
function validate_and_upload_Image($path, $filename, $tmp_name, $filetype, $filesize, $prefixName)
{
    if (isset($filename)) {

        $target_dir = $path . "/";
        $target_file = $target_dir . basename($filename);
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if actual image
        if (getimagesize($tmp_name) === false) {
            return 'msg=Please Attach An Image.&type=error';
        }

        // Check file size not more that 10MB
        if ($filesize > 10485760) { //10MB
            return 'msg=File Too Large. Allowed File Size Is Least 10MB.&type=error';
            // return 'File Too Large. Allowed File Size Is Least 10MB.&&&false';
        }

        // Allow certain file formats
        if (
            $extension != "jpg" &&
            $extension != "png" &&
            $extension != "jpeg"
        ) {
            return 'msg=Allowed File Formats Include:<br> .jpg, .png, and .jpeg&type=error';
        }

        $fileName = $prefixName . "." . md5(md5(time() . 'burnerBoy' . rand(0, 9999))) . "." . $extension;
        $destination_url = $path . '/' . $fileName;

        if (compress_image($tmp_name, $destination_url, 75)) { //success
            return 'jdslk_____' . $destination_url;
        } else {
            return 'msg=File Could Not Be Uploaded. Please Try Again.&type=error';
        }
    } else {
        return 'msg=Image size too large&type=error';
    }
}

function compress_image($source_url, $destination_url, $quality)
{
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

    return imagejpeg($image, $destination_url, $quality);
}//end compress_image