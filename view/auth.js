// login 
$("#loginBtn").click(function(){
    let username = $("#username").val();
    let password = $("#password").val();

    $.ajax({
        url: "../control/login.js",
        type: "POST",
        data: {
            username: username,
            password: password
        },
        success: function(){
            alert("success login");
        },
        error: function(){
            alert("error login");
        }
    });
});

// register
$("#registerBtn").click(function(){
    let username = $("#username").val();
    let firstname = $("#firstname").val();
    let middlename = $("#middlename").val();
    let lastname = $("#lastname").val();
    let password = $("#password").val();
    let studentcourse = $("#studentcourse").val();
    

    $.ajax({
        url: "register.php",
        type: "POST",
        data: {
            username: username,
            firstname: firstname,
            middlename: middlename,
            lastname: lastname,
            password: password,
            studentcourse: studentcourse
        },
        success: function(){
            alert("success register");
        },
        error: function(){
            alert("error register");
        }
    });
});



