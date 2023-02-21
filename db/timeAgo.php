<?php

//GET TIME AGO
function getTimeAgo($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);

    if ($seconds <= 60) {    //seconds
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 min ago";
        } else {
            return $minutes . " min ago";
        }
    } else if ($hours <= 24) {    //hours
        if ($hours == 1) {
            return "An hour ago";
        } else {
            return $hours . " hours ago";
        }
    } else if ($days <= 7) {    //days
        if ($days == 1) {
            return "A day ago";
        } else {
            return $days . " days ago";
        }
    } else if ($weeks <= 4.3) {    //weeks
        if ($weeks == 1) {
            return "A week ago";
        } else {
            return $weeks . " weeks ago";
        }
    } else if ($months <= 12) {    //months
        if ($months == 1) {
            return "A month ago";
        } else {
            return $months . " months ago";
        }
    } else {    //years
        if ($years == 1) {
            return "A year ago";
        } else {
            return $years . " years ago";
        }
    } //end main elseif()

}//end time_ago_uploaded()