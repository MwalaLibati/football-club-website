$(document).ready(function () {
  $(document).on("click", "#changeMyPasswordBtn", function () {
    let btn = $(this);
    let email = btn.val();
    btn.html('<i class="fas fa-spinner fa-spin text-dark"></i>');

    $.ajax({
      type: "post",
      url: "db/forgot_db.php",
      data: { email: email },

      success: function (result) {
        console.log(result);
        if (result === "success") {
          toastMe(
            "<i class='fa fa-envelope'></i> A Reset Link Has Been<br>Sent To Your Email Address",
            "success",
            60
          );
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again", "neutral", 10);
          } else {
            toastMe(result, "error", 10);
          }
        }
        btn.html('Change My Password <i class="fas fa-key"></i>');
      },
      error: function (error) {
        console.log(error);
        toastMe("System Error! Reload Page & Try Again", "neutral", 10);
        btn.html('Change My Password <i class="fas fa-key"></i>');
      },
    });
  });
});
