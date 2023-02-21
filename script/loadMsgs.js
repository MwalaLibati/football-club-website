//LOAD MSGS
$(document).ready(function () {
  $(".reloadInbox").click(function () {
    loadMsgs();
  });
  loadMsgs();
  function loadMsgs() {
    $(".listOfMsgs").html(
      '<i class="fas fa-spinner fa-spin text-dark p-4"></i>'
    );
    $.ajax({
      url: "../db/loadMsgs.php",
      type: "POST",
      data: { data: "loadMsgs" },
      success: function (result) {
        $(".listOfMsgs").html(result);
      },
      error: function (error) {
        console.log(error);
        $(".listOfMsgs").html(
          "<i class='m-3'>Failed to load messages. Please reload page</i>"
        );
      },
    });
  } //end loadMsgs()

  $(".sentMsgBtn").click(function () {
    loadSentMsgs();
  });
  function loadSentMsgs() {
    $(".listOfMsgs").html(
      '<i class="fas fa-spinner fa-spin text-dark p-4"></i>'
    );
    $.ajax({
      url: "../db/loadSentMsgs.php",
      type: "POST",
      data: { data: "loadSentMsgs" },
      success: function (result) {
        $(".listOfMsgs").html(result);
        $(".inboxNewLabel").html('Replies');
      },
      error: function (error) {
        console.log(error);
        $(".listOfMsgs").html(
          "<i class='m-3'>Failed to load messages. Please reload page</i>"
        );
      },
    });
  } //end loadSentMsgs()
});
