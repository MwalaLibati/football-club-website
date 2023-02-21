$(document).ready(function () {
  //listen to delete account click------------------------
  $("#deleteMyAccountPreBtn").click(function () {
    //populate model content
    let email = $(this).val();
    setModelContent(
      "Confirm",
      "Are you sure you want to DELETE your account?<br>Please note this action is irreversible.",
      '<a href="db/deleteAccount_db.php?email=' +
        email +
        '" class="btn btn-danger btn-lg mr-1">Yes</a><a class="btn btn-success btn-lg" data-dismiss="modal" aria-label="Close">No</a>'
    );
    //call model
    $("#randomModelBox").modal();
  });
});
