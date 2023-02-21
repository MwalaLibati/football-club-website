<?php
include_once 'connect.php';
include_once 'timeAgo.php';

$data = $_POST['data'];

if (isset($data)) {

    $sent = mysqli_query($conn, "SELECT * FROM adminreplys ORDER BY replyDate DESC");
    $html = '';

    if (mysqli_num_rows($sent) > 0) {
        while ($result = mysqli_fetch_assoc($sent)) {

            $data2 = mysqli_query($conn, "SELECT * FROM contactus WHERE contactId = " . $result["contactId"]);
            $result2 = mysqli_fetch_assoc($data2);

            $html .= '<tr>
                        <td class="mailbox-name"><a title="Open" href="readMail.php?contactId=' . $result["contactId"] . '"><i class="fas fa-envelope mr-2 text-warning"></i> ' . $result2["fullName"] . '</a></td>
                        <td class="mailbox-subject">
                            <a title="Open" class="text-dark" href="readMail.php?contactId=' . $result["contactId"] . '">
                                <b>Msg:</b> 
                                ' . substr($result["comment"], 0, 30) . '...
                            </a>
                        </td>
                        <td class="mailbox-date">' . getTimeAgo($result["replyDate"]) . '</td>
                    </tr>';
        }
    }

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM adminreplys")) == 0) {
        $html = '<p class="p-2">No Replies</p>';
    }
    echo $html;
} else {
    $html = '<p class="p-2">Failed to load data. Reload page & try again</p>';
    echo $html;
}
