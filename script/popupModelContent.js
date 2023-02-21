$(document).ready(function () {
  //listen to logout click------------------------
  $(".logoutLink").click(function () {
    //populate model content
    setModelContent(
      "Confirm",
      "Are you sure you want to logout?",
      '<a href="db/logout.php" class="btn btn-danger btn-lg mr-1">Yes</a><a class="btn btn-success btn-lg" data-dismiss="modal" aria-label="Close">No</a>'
    );
    //call model
    $("#randomModelBox").modal();
  });

  //listen to Membership payment-------------------
  $(".MembershipSubPriceLink").click(function () {
    //populate model content
    let MembershipSubPriceContent = $("#MembershipSubPriceContent").val();
    let active = $("#MembershipSubPriceContent").data("active");
    let imgPath = $("#MembershipSubPriceContent").data("img");
    let imgUI =
      '<img class="ml-2" src="membershipForms/images/' +
      imgPath +
      '.jpg" height="30" width="30">';
    let btn = "";
    let header = "";
    if (active == 0) {
      header = "Payment Notice";
      btn =
        '<a href="autoAddToCartService.php?payMembershipSubscription" class="btn btn-success btn-lg mr-1">Make Payment</a>';
    } else if (active == 1) {
      header = "Club Membership";
    }
    imgUI = "";
    setModelContent(header, MembershipSubPriceContent + imgUI, btn);
    //call model
    $("#randomModelBox").modal();
  });

  window.setModelContent = function setModelContent(title, text, buttons) {
    $(".random-modal-title").html(title);
    $(".random-text").html(text);
    $(".random-buttons").html(buttons);
  };

  //open signup model
  $(".openSignupModel").click(function () {
    $("#ritekhelamodalrg").modal();
  });

  //open login model
  $(".openLoginModel").click(function () {
    $("#ritekhelamodalcenter").modal();
  });

  //open forgot password model
  $(".forgotPassword").click(function () {
    $("#ritekhelamodalcenterForgotPassword").modal();
  });
});
