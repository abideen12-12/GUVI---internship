$(document).ready(function() {

    $("#loginForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "php/login.php",
            type: "POST",
            dataType: "json",
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function(res) {

                console.log("Response:", res);

                if (res.status === "success") {

                    // Save session
                    localStorage.setItem("user_id", res.user_id);
                    localStorage.setItem("session_id", res.session_id);

                    window.location.href = "profile.html";

                } else {
                    alert(res.msg);
                }
            },
            error: function(err) {
                console.log("FULL ERROR:", err);
                console.log("Response Text:", err.responseText);
                alert("Server error");
                
            }
        });
    });

});