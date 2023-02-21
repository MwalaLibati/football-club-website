$(document).ready(function () {
  $("#newPasswordForm").submit(function (event) {
    event.preventDefault();

    $(".newPasswordFormMsg").html(
      '<i class="fas fa-spinner fa-spin text-white"></i>'
    );

    $.ajax({
      type: "post",
      url: "db/newPassword_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".newPasswordFormMsg").html("Password Changed Successfully.");
          $(".newPasswordFormMsg").css("color", "#5cd65c"); //text-green
          $("#newPasswordForm").trigger("reset");
          $(".submitBtnNewPassword").css("background-color", "#4d4d4d");
          $(".submitBtnNewPassword").prop("disabled", true);
          localStorage.setItem("autoDisplayModel", "login");
          setTimeout(function () {
            window.location.replace("index.php");
          }, 3000);
        } else {
          if (result.includes("<br />")) {
            // $(".newPasswordFormMsg").text(result);
            $(".newPasswordFormMsg").text(
              "System Error! Reload Page & Try Again"
            );
          } else {
            $(".newPasswordFormMsg").text(result);
          }
          $(".newPasswordFormMsg").css("color", "#ff8080"); //text-red
        }
        $(".newPasswordFormMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".newPasswordFormMsg").text("Error! Try Again");
        $(".newPasswordFormMsg").css("color", "#ff8080"); //text-red
        $(".newPasswordFormMsg").fadeIn();
      },
    });
  });
});
