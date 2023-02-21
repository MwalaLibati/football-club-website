<?php

include 'connect.php';

//validate email
function validate_email($data, $required)
{
    if ($required == 'required') {
        if (
            isNotEmpty($data) &&
            filter_var($data, FILTER_VALIDATE_EMAIL) &&
            strlen($data) <= 255
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                filter_var($data, FILTER_VALIDATE_EMAIL) &&
                strlen($data) <= 255
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

//validate NRC number
function validate_nrc_number($data, $required)
{
    if ($required == 'required') {
        if (
            strlen($data) == 9 &&
            isNotEmpty($data) &&
            preg_match('/^[1-9][0-9]*$/', $data) &&
            validate_decimal_or_whole_number($data, $required)
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                strlen($data) == 9 &&
                preg_match('/^[1-9][0-9]*$/', $data) &&
                validate_decimal_or_whole_number($data, $required)
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

//validate phone number
function validate_phone_number($data, $required)
{
    if ($required == 'required') {
        if (
            strlen($data) == 10 &&
            isNotEmpty($data) &&
            validate_decimal_or_whole_number($data, $required)
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                strlen($data) == 10 &&
                preg_match('/^[0-9]*$/', $data) &&
                validate_decimal_or_whole_number($data, $required)
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

//validate All Numbers (Whole and Decimal Numbers starting from zero
function validate_decimal_or_whole_number($data, $required)
{
    if ($required == 'required') {
        if (is_numeric($data) && isNotEmpty($data)) {
            return true;
        } else {
            return false;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (is_numeric($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


//validate text data
function validate_text($data, $required)
{
    if ($required == 'required') {
        if (
            preg_match('/[\^`$%&*}{@#~?><>|=_+]/', $data) ||
            !isNotEmpty($data) ||
            strlen($data) > 255
        ) {
            return false;
        } else {
            return true;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                preg_match('/[\^`$%&*}{@#~?><>|=_+]/', $data) ||
                strlen($data) > 255
            ) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}



//validate textarea data
function validate_textarea($data, $required)
{
    if ($required == 'required') {
        if (
            preg_match('/[\^`$%&*}{@#~><>|=_+]/', $data) ||
            !isNotEmpty($data) ||
            strlen($data) > 1000
        ) {
            return false;
        } else {
            return true;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                preg_match('/[\^`$%&*}{@#~><>|=_+]/', $data) ||
                strlen($data) > 1000
            ) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}


//validate money (with decimals)
function validate_money($data, $required)
{
    if ($required == 'required') {
        if (
            !validate_decimal_or_whole_number($data, $required) ||
            strlen($data) > 10 ||
            !isNotEmpty($data)
        ) {
            return false;
        } else {
            return true;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (
                !validate_decimal_or_whole_number($data, $required) ||
                strlen($data) > 10
            ) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}

//validate token
function validate_token($data, $required)
{
    if ($required == 'required') {
        if (preg_match('/[\^`$%&*}{@#~?><>|=_+-]/', $data) || !isNotEmpty($data)) {
            return false;
        } else if (!isNotEmpty($data) || strlen($data) > 255) {
            return false;
        } else {
            return true;
        }
    } else {
        if (!isNotEmpty($data)) {
            return true;
        } elseif (isNotEmpty($data)) {
            if (preg_match('/[\^`$%&*}{@#~?><>|=_+-]/', $data) || strlen($data) > 255) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}

//check if file is uploaded
function isFileSelected($file, $required, $type)
{
    // if (count($file["file"]) <= 10) { //upload 10 files @ a time
    if ($required == 'required') {
        if ($file["file"]["error"][0] == 0) {
            if (validate_file($file, $type)) {
                return true;
            } else {
                return false;
            }
        } elseif ($file["file"]["error"][0] != 0) {
            return false;
        } else {
            return false;
        }
    } else {
        if ($file["file"]["error"][0] == 0) {
            if (validate_file($file, $type)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    // } else {
    //     return false;
    // }
} //end isFileSelected()

//validate file
function validate_file($file, $type)
{
    //Expected file extensions
    if ($type == 'img') {
        $fileExtensionsArr = array('jpg', 'png', 'jpeg');
    } elseif ($type == 'word') {
        $fileExtensionsArr = array('doc', 'docx');
    } elseif ($type == 'pdf') {
        $fileExtensionsArr = array('pdf');
    } elseif ($type == 'video') {
        $fileExtensionsArr = array('mp4', 'avi');
    } else {
        return false;
    }

    $filesArr = $file["file"];
    $fileNames = array_filter($filesArr['name']);
    $fileStatus = 0;

    if (!empty($fileNames)) {
        foreach ($filesArr['name'] as $key => $val) {
            // die(var_dump($filesArr['tmp_name'][$key]));
            $fileName = basename($filesArr['name'][$key]);
            $filesize = $filesArr['size'][$key];
            $tmp_name = $filesArr['tmp_name'][$key];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // check if actual image
            if (getimagesize($tmp_name) === false) {
                $fileStatus++;
            }

            //check size
            if ($filesize > 10485760) { //10MB
                $fileStatus++;
            }

            //check file extension
            if (!in_array($fileExtension, $fileExtensionsArr)) {
                $fileStatus++;
            }
        } //end foreach()
    } else {
        $fileStatus++;
    }

    if ($fileStatus == 0) {
        return true;
    } else {
        return false;
    }
} //end validate_file()




//validate password
function validate_password($data, $required)
{
    if (
        isNotEmpty($data) &&
        $required == 'required' &&
        strlen($data) <= 255
    ) {
        return true;
    } else {
        return false;
    }
} //end validate_password()


//validate password at signup
function validate_passwords_match($password, $confirmPassword)
{
    if ($password !== $confirmPassword) {
        return false;
    } else {
        return true;
    }
} //end validate_passwords_match()

//validate password at signup
function validate_signup_password($password)
{
    if (strlen($password) < 4) {
        return false;
    }
    /* elseif (!preg_match("#[0-9]+#", $password)) {
        return false;
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        return false;
    } elseif (!preg_match("#[a-z]+#", $password)) {
        return false;
    }  */ else {
        return true;
    }
} //end validate_signup_password()

//strip off special characters
function stripOff($conn, $data)
{
    return mysqli_real_escape_string($conn, test_input($data));
} //end stripOff()

//make sure not empty
function isNotEmpty($data)
{
    if (
        !empty($data) &&
        isset($data)
    ) {
        return true;
    } else {
        return false;
    }
} //end isNotEmpty()

//remove special characters
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}//end test_input()
