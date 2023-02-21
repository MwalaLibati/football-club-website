$(document).ready(function () {
  $("#signupForm").submit(function (event) {
    event.preventDefault();

    //source of trigger
    let db = $(this).data("db");
    let color;
    if (db == "user") {
      color = "text-white";
      db = "db/signup_db.php";
      $(".signupFormMsg").html(
        '<i class="fas fa-spinner fa-spin text-white"></i>'
      );
    } else if (db == "admin") {
      color = "text-dark";
      db = "../db/signup_db.php";
      $(".signupFormMsg").html(
        '<i class="fas fa-spinner fa-spin text-dark"></i>'
      );
    }
    console.log(db);

    $.ajax({
      type: "post",
      url: db,
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".signupFormMsg").html(
            'Signup Successful.<br><i class="fa fa-envelope"></i> A Verification Link Has<br>Been Sent To Your Email Address. If you do not receive this link, please <a class="' +
              color +
              ' text-underline" target="_blank" href="mailto:support@mufulirawanderers.com?Subject=Hello Support Team">contact support</a>'
          );
          $(".signupFormMsg").css("color", "#5cd65c"); //text-green
          $("#signupForm").trigger("reset");
          $(".submitBtnSignup").css("background-color", "#4d4d4d");
          $(".submitBtnSignup").prop("disabled", true);
        } else {
          if (result.includes("<br />")) {
            // $(".signupFormMsg").text(result);
            $(".signupFormMsg").text("System Error! Reload Page & Try Again");
          } else {
            $(".signupFormMsg").text(result);
          }
          $(".signupFormMsg").css("color", "#ff8080"); //text-red
        }
        $(".signupFormMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".signupFormMsg").text("Error! Try Again");
        $(".signupFormMsg").css("color", "#ff8080"); //text-red
        $(".signupFormMsg").fadeIn();
      },
    });
  });
});
