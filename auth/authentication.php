<?php
session_start();
if (isset($_SESSION['user'])){
    header("Location: ../main.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authentication</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <style type="text/css">
        .form {
            padding: 15px;
            box-shadow: 2px 2px 5px grey;
        }

        .login-container {
            margin-top: 150px;
        }
        .register-container {
            margin-top: 70px;
            display: none;
        }

        a {
            cursor: pointer;
        }
        .container {
            display: flex;
            justify-content: center;
        }
        .state{
            margin-bottom: 10px;
        }
    </style>
    <script type="text/javascript">
        $("document").ready(function() {
            $("#button-show-login").click(function(){
                $(".login-container").show();
                $(".register-container").hide();
            });
            $("#button-show-register").click(function(){
                $(".login-container").hide();
                $(".register-container").show();
            });
            function request(e, url, data){
                event.preventDefault();
                $(e).siblings('.state').hide();
                $.post(url, data)
                    .done(function(msg){
                        console.log(msg);
                        if (msg['message'] === 'success'){
                            location.reload();
                        }else{
                            $(e).siblings('.state').fadeIn();
                            $(e).siblings('.state').css('color', 'red');
                            $(e).siblings('.state').text(msg['message']);
                        }
                    });
            }

            $("#button-login").click(function(){
                email = $("#input-email-login").val();
                password = $("#input-password-login").val();
                request(this, "login.php", {login: "ok", email: email, password: password});
            });

            $("#button-register").click(function(){
                email = $("#input-email-register").val();
                password = $("#input-password-register").val();
                firstName = $("#input-first-name").val();
                lastName = $("#input-last-name").val();
                birthdate = $("#input-birthdate").val();
                ava = $("#input-ava").val();
                data = {
                    register: "ok",
                    email: email,
                    password: password,
                    firstName: firstName,
                    lastName: lastName,
                    birthdate: birthdate,
                    ava: ava
                };
                request(this, "register.php", data);
            });
            $('#input-email-register').focusout(function(){
                if ($(this).val() !== ''){
                    $.post('register.php', {checkEmail: 'ok',email: $(this).val()})
                        .done(function(msg){
                            console.log(msg);
                            if (msg['message'] == 'success'){
                                $("#emailState").show();
                                $("#emailState").css('color', 'mediumseagreen');
                                $("#emailState").text('Email is free');
                                $('#button-register').prop('disabled','');
                            }else{
                                $("#emailState").show();
                                $("#emailState").css('color', 'red');
                                $("#emailState").text(msg['message']);
                                $('#button-register').prop('disabled','true');
                            }
                        });
                }
            });

        });
    </script>
</head>

<body>
<div class="container">
    <div class="login-container form card">
        <p class="text-center h4">Sign in</p>
        <hr>
        <form>
            <div class="form-group">
                <label for="input-email-login">Email address</label>
                <input type="email" class="form-control" id="input-email-login" aria-describedby="emailHelp" placeholder="Enter email" required="required">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="input-password-login">Password</label>
                <input type="password" class="form-control" id="input-password-login" placeholder="Enter password" required="required">
            </div>
            <small class="form-text state" style="color: deepskyblue; display: none">Loading</small>
            <button type="submit" class="btn btn-primary btn-block" id="button-login">Sign in</button>
        </form>
        <a class="btn btn-link btn-sm text-muted" id="button-show-register">Not a member? Sign up</a>
    </div>
    <div class="register-container form card">
        <p class="text-center h4">Sign up</p>
        <hr>
        <form>
            <div class="form-group">
                <label for="input-email-register">Email</label>
                <input type="email" class="form-control" id="input-email-register" placeholder="Enter email" required="required">
                <small id="emailState" class="form-text" style="color: deepskyblue; display: none"></small>
            </div>
            <div class="form-group">
                <label for="input-password-register">Password</label>
                <input type="password" class="form-control" id="input-password-register" placeholder="Enter password" required="required">
            </div>
            <div class="form-group">
                <label for="input-first-name">First Name</label>
                <input type="text" class="form-control" id="input-first-name" placeholder="Enter First Name" required="required">
            </div>
            <div class="form-group">
                <label for="input-last-name">Last Name</label>
                <input type="text" class="form-control" id="input-last-name" placeholder="Enter Last Name" required="required">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="input-birthdate">Birthday</label>
                    <input type="text" class="form-control" id="input-birthdate" required="required">
                </div>
                <div class="form-group col-md-8">
                    <label for="input-ava">Ava Url</label>
                    <input type="text" class="form-control" id="input-ava" placeholder="Enter URL" required="required">
                </div>
            </div>
            <small class="form-text state" style="color: deepskyblue; display: none"></small>
            <button type="submit" class="btn btn-success btn-block" id="button-register">Sign up</button>
        </form>
        <a class="btn btn-link btn-sm text-muted" id="button-show-login">Already registered? Sign in</a>
    </div>
</div>
</body>

</html>