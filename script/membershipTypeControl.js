$(document).ready(function () {
  //deactivate membership
  $(document).on("click", ".memberTypeDeactivateBtn", function () {
    let btn = $(this);
    let id = $(this).val();
    btn.html('<i class="fas fa-spinner fa-spin text-dark"></i>');
    $.ajax({
      type: "post",
      url: "../db/membershipTypeControl_db.php",
      data: { type: "deactivate", id: id },
      success: function (result) {
        console.log(result);
        btn
          .tooltip("hide")
          .attr(
            "data-original-title",
            "Users will be able to apply for this membership"
          )
          .tooltip("show");
        if (result === "success") {
          $(".memberTypeStatus" + id).html(
            '<span class="badge badge-danger">Not Active</span>'
          );
          btn.html("Activate");
          btn.removeClass("memberTypeDeactivateBtn");
          btn.addClass("memberTypeActivateBtn");
          toastMe("Membership Deactivated Successfully", "success", 10);
        } else {
          toastMe("Action Failed. Try Again", "error", 10);
        }
      },
      error: function (error) {
        console.log(error);
        toastMe("Action Failed. Try Again", "error", 10);
      },
    });
  });

  //activate membership
  $(document).on("click", ".memberTypeActivateBtn", function () {
    let btn = $(this);
    let id = $(this).val();
    btn.html('<i class="fas fa-spinner fa-spin text-dark"></i>');
    $.ajax({
      type: "post",
      url: "../db/membershipTypeControl_db.php",
      data: { type: "activate", id: id },
      success: function (result) {
        console.log(result);
        btn
          .tooltip("hide")
          .attr(
            "data-original-title",
            "Users will NOT be able to apply for this membership"
          )
          .tooltip("show");
        if (result === "success") {
          $(".memberTypeStatus" + id).html(
            '<span class="badge badge-success">Active</span>'
          );
          btn.html("Deactivate");
          btn.removeClass("memberTypeActivateBtn");
          btn.addClass("memberTypeDeactivateBtn");
          toastMe("Membership Activated Successfully", "success", 10);
        } else {
          toastMe("Action Failed. Try Again", "error", 10);
        }
      },
      error: function (error) {
        console.log(error);
        toastMe("Action Failed. Try Again", "error", 10);
      },
    });
  });

  //delete membership
  $(document).on("click", ".memberTypeDeleteBtn", function () {
    let id = $(this).val();
    $.ajax({
      type: "post",
      url: "../db/membershipTypeControl_db.php",
      data: { type: "delete", id: id },
      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".memberTypeRow" + id).hide();
          toastMe("Membership Deleted Successfully", "success", 10);
        } else {
          toastMe("Action Failed.. Try Again", "error", 10);
        }
      },
      error: function (error) {
        console.log(error);
        toastMe("Action Failed. Try Again", "error", 10);
      },
    });
  });

  //preset memberType values to edit
  $(document).on("click", ".memberTypeEditBtn", function () {
    let val = $(this).val();
    let id = val.split("___")[0];
    let memberTypeOld = val.split("___")[1];
    let price = val.split("___")[2];
    let monthDuration = val.split("___")[3];
    $("#memberTypeEditModal").modal();
    $(".membershipEditText").html("Edit " + memberTypeOld + " Membership");
    $("#editMemberTypeForm input[name=memberType]").val(memberTypeOld);
    $("#editMemberTypeForm input[name=price]").val(price);
    $("#editMemberTypeForm input[type=submit]").val("Edit");
    $("#editMemberTypeForm select[name=monthDuration]").val(monthDuration);
    $("#editMemberTypeForm select[name=monthDuration]")
      .find('option[value="' + monthDuration + '"]')
      .attr("selected", true);

    $("input[name=id]").val(id);
    $("input[name=memberTypeOld]").val(memberTypeOld);
  });

  //cancel memberType edit
  $(document).on("click", ".cancelEditMemberType", function () {
    $("input[name=id]").val("");
    $("input[name=memberTypeOld]").val("");
    $("#editMemberTypeForm").trigger("reset");
    $("#editMemberTypeForm select[name=monthDuration]").prop(
      "selectedIndex",
      0
    );
    $("#memberTypeEditModal").modal("hide");
  });
});
