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

                // Inside the AJAX success function:
                if (res.status === "success") {
                    localStorage.setItem("session_id", res.session_id); // This is our Redis key
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
