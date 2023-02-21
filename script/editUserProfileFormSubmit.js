$(document).ready(function () {
  //pre collect
  let firstName = $("#userProfileForm input[name=firstName]").val();
  let lastName = $("#userProfileForm input[name=lastName]").val();

  $("#userProfileForm").submit(function (event) {
    event.preventDefault();

    let firstNameSubmitted = $("#userProfileForm input[name=firstName]").val();
    let lastNameSubmitted = $("#userProfileForm input[name=lastName]").val();

    if (firstName == firstNameSubmitted && lastName == lastNameSubmitted) {
      toastMe("No Changes Made", "neutral", 10);
      return;
    }

    $(".submitBtnEditUserProfile").html(
      '<i class="fas fa-spinner fa-spin text-dark"></i>'
    );
    $.ajax({
      type: "post",
      url: "db/editUserProfile_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          toastMe("Profile Updated<br>Successfully", "success", 10);
          $(".firstNameDisplay").html(firstNameSubmitted);
          $(".lastNameDisplay").html(lastNameSubmitted);

          firstName = firstNameSubmitted;
          lastName = lastNameSubmitted;
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again", "error", 10);
          } else {
            toastMe(result, "error", 10);
          }
        }
        $(".submitBtnEditUserProfile").html("Save Changes");
      },
      error: function (error) {
        console.log(error);
        toastMe(error, "Error! Try Again", 10);
        $(".submitBtnEditUserProfile").html("Save Changes");
      },
    });
  });
});
