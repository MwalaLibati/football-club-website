$(document).ready(function () {
  $("#composedMsgForm").submit(function (event) {
    event.preventDefault();

    $(".composedMsgMsg").html(
      '<i class="fas fa-spinner fa-spin text-dark"></i>'
    );

    $.ajax({
      type: "post",
      url: "../db/composeMsg_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".composedMsgMsg").html("Email Sent Successfully");
          $(".composedMsgMsg").css("color", "#5cd65c"); //text-green
          $("#composedMsgForm").trigger("reset");
          /* setTimeout(function () {
            window.location.replace("inbox.php");
          }, 1000); */
        } else {
          if (result.includes("<br />")) {
            $(".composedMsgMsg").text("System Error! Reload Page & Try Again");
          } else {
            $(".composedMsgMsg").text(result);
          }
          $(".composedMsgMsg").css("color", "#ff8080"); //text-red
        }
        $(".composedMsgMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".composedMsgMsg").text("Error! Try Again");
        $(".composedMsgMsg").css("color", "#ff8080"); //text-red
        $(".composedMsgMsg").fadeIn();
      },
    });
  });
});
