$(document).ready(function () {
  $("#signinForm").submit(function (event) {
    event.preventDefault();

    $(".signinFormMsg").html('<i class="fas fa-spinner fa-spin text-white"></i>');

    $.ajax({
      type: "post",
      url: "db/signin_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".signinFormMsg").text("Login Successful");
          $(".signinFormMsg").css("color", "#5cd65c"); //text-green
          $("#signinForm").trigger("reset");
          $(".submitBtnSignin").css("background-color", "#4d4d4d");
          $(".submitBtnSignin").prop("disabled", true);
          setTimeout(function () {
            window.location.replace("index.php");
          }, 1000);
        } else if (result === "admin") {
          $(".signinFormMsg").text("Welcome Boss");
          $(".signinFormMsg").css("color", "#5cd65c"); //text-green
          $("#signinForm").trigger("reset");
          $(".submitBtnSignin").css("background-color", "#4d4d4d");
          $(".submitBtnSignin").prop("disabled", true);
          setTimeout(function () {
            window.location.replace("admin/index.php");
          }, 1000);
        } else {
          if (result.includes("<br />")) {
            // $(".signinFormMsg").text(result);
            $(".signinFormMsg").text("System Error! Reload Page & Try Again");
          } else {
            $(".signinFormMsg").text(result);
          }
          $(".signinFormMsg").css("color", "#ff8080"); //text-red
        }
        $(".signinFormMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".signinFormMsg").text("Error! Try Again");
        $(".signinFormMsg").css("color", "#ff8080"); //text-red
        $(".signinFormMsg").fadeIn();
      },
    });
  });
});
