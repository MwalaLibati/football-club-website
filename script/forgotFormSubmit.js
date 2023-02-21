$(document).ready(function () {
  $("#forgotForm").submit(function (event) {
    event.preventDefault();

    $(".forgotFormMsg").html(
      '<i class="fas fa-spinner fa-spin text-white"></i>'
    );
    $(".forgotFormMsg").removeClass("text-white");

    $.ajax({
      type: "post",
      url: "db/forgot_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".forgotFormMsg").html(
            "<i class='fa fa-envelope'></i> A Reset Link Has Been Sent To Your Email Address"
          );
          $(".forgotFormMsg").css("color", "#5cd65c"); //text-green
          $("#forgotForm").trigger("reset");
          // $(".submitBtnForgot").css("background-color", "#4d4d4d");
          // $(".submitBtnForgot").prop("disabled", true);
        } else {
          if (result.includes("<br />")) {
            // $(".forgotFormMsg").text(result);
            $(".forgotFormMsg").text("System Error! Reload Page & Try Again");
          } else {
            $(".forgotFormMsg").text(result);
          }
          $(".forgotFormMsg").css("color", "#ff8080"); //text-red
        }
        $(".forgotFormMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".forgotFormMsg").text("Error! Try Again");
        $(".forgotFormMsg").css("color", "#ff8080"); //text-red
        $(".forgotFormMsg").fadeIn();
      },
    });
  });
});
