$(document).ready(function() {

    console.log("PROFILE JS LOADED");

    let session_id = localStorage.getItem("session_id");

    if (!session_id) {
        window.location.href = "login.html";
    }

    //Load profile
    $.ajax({
        url: "php/profile.php",
        type: "GET",
        dataType: "json",
        data: { session_id: session_id },
        success: function(res) {

            console.log("PROFILE:", res);

            $("#name").val(res.name || "");
            $("#age").val(res.age || "");
            $("#dob").val(res.dob || "");
            $("#contact").val(res.contact || "");
        }
    });

    $("#editBtn").on("click", function() {

        console.log("EDIT CLICKED");

        $("#name").prop("disabled", false);
        $("#age").prop("disabled", false);
        $("#dob").prop("disabled", false);
        $("#contact").prop("disabled", false);

        $("#editBtn").hide();
        $("#saveBtn").show();
    });

    //Save profile
    $("#saveBtn").click(function() {

    $.ajax({
        url: "php/profile.php",
        type: "POST",
        dataType: "json",
        data: {
            session_id: session_id,
            name: $("#name").val(),
            age: $("#age").val(),
            dob: $("#dob").val(),
            contact: $("#contact").val()
        },
        success: function() {
            alert("Saved");
        }
    });

});

});

function logout() {
    localStorage.clear();
    window.location.href = "login.html";
}