<?php
include_once 'connect.php';
include_once 'timeAgo.php';

$data = $_POST['data'];

if (isset($data)) {

    $unread = mysqli_query($conn, "SELECT * FROM contactus WHERE markRead = 0 ORDER BY contactDate DESC");
    $read = mysqli_query($conn, "SELECT * FROM contactus WHERE markRead = 1 ORDER BY contactDate DESC");
    $html = '';

    if (mysqli_num_rows($unread) > 0) {
        while ($result = mysqli_fetch_assoc($unread)) {

            //check if system user
            $email = $result["email"];
            $data3 = mysqli_query($conn, "SELECT email FROM users WHERE email LIKE '$email'");
            if (mysqli_num_rows($data3) == 1) {
                $userType = '<i class="text-dark bold font-small">(User)</i>';
            } else {
                $userType = '<i class="text-dark font-small">(Not User)</i>';
            }
            $html .= '<tr>
                        <td class="mailbox-name"><a title="Open" href="readMail.php?contactId=' . $result["contactId"] . '"><i class="fas fa-envelope mr-2 text-warning"></i> ' . $result["fullName"] . ' ' . $userType . '</a></td>
                        <td class="mailbox-subject">
                            <a title="Open" class="text-dark" href="readMail.php?contactId=' . $result["contactId"] . '">
                                <b>Msg:</b> 
                                ' . substr($result["comment"], 0, 30) . '...
                            </a>
                        </td>
                        <td class="mailbox-date">' . getTimeAgo($result["contactDate"]) . '</td>
                    </tr>';
        }
    }
    $html .= '<tr class="bg-white border-top border-primary border-3">
                    <td class="font-large">Old <i class="fas fa-angle-down p-1 text-dark"></i></td>
                    <td></td>
                    <td></td>
                </tr>';
    if (mysqli_num_rows($read) > 0) {
        while ($result = mysqli_fetch_assoc($read)) {
            //check if system user
            $email = $result["email"];
            $data3 = mysqli_query($conn, "SELECT email FROM users WHERE email LIKE '$email'");
            if (mysqli_num_rows($data3) == 1) {
                $userType = '<i class="text-dark bold font-small">(User)</i>';
            } else {
                $userType = '<i class="text-dark font-small">(Not User)</i>';
            }
            $html .= '<tr>
                        <td class="mailbox-name"><a title="Open" href="readMail.php?contactId=' . $result["contactId"] . '"><i class="fas fa-envelope-open text-gray"></i> ' . $result["fullName"] . '' . $userType . '</a></td>
                        <td class="mailbox-subject">
                            <a title="Open" class="text-dark" href="readMail.php?contactId=' . $result["contactId"] . '">
                                <b>Msg:</b> 
                                ' . substr($result["comment"], 0, 30) . '...
                            </a>
                        </td>
                        <td class="mailbox-date">' . getTimeAgo($result["contactDate"]) . '</td>
                    </tr>';
        }
    }


    if (mysqli_num_rows(mysqli_query($conn, "SELECT contactId FROM contactus")) == 0) {
        $html = '<p class="p-2">No Mail</p>';
    }
    echo $html;
} else {
    $html = '<p class="p-2">Failed to load data. Reload page & try again</p>';
    echo $html;
}
