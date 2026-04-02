$("#registerForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: "php/register.php",
        type: "POST",
        data: {
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val()
        },
        success: function(res) {
            alert("Registered Successfully");
            window.location.href = "login.html";
        }
    });
});