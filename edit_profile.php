<?php
session_start();
include_once 'sessionCheck.php';
?>
<!DOCTYPE html>
<hmtl>
    <head>
        <title>All tags</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <style>
            li {
                padding-left: 20px;
                padding-right: 20px;
            }
            .navbar-brand {
                padding-left: 100px;
            }
            .title small, .content small {
                width: 200px;
                text-align: right;
            }
            footer h6, footer p, footer a, footer a:hover{
                color: white;
                text-decoration: none;
            }
            footer hr{
                background-color: white;
            }
            .container{
                display: flex;
                justify-content: space-evenly;
            }
            .personal-container, .password-container, .description-container{
                margin-top: 100px;
            }
            .password-container{
                width: 400px;
            }
            .description-container{
                width: 900px;
            }
        </style>

    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="main.php">BeeShy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="main.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tags.php">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Users</a>
                </li>
            </ul>
            <form class="form-inline" style="padding-right: 100px;" >
                <ul class="navbar-nav mr-auto" >
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['user']['id']?>">Profile</a>
                            <a class="dropdown-item" href="edit_profile.php">Edit profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="auth/signOut.php">Sign out</a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="personal-container">
            <h4 class="text-center">Personal Info</h4>
            <hr>
            <form>
                <div class="form-group">
                    <label for="input-first-name">First Name</label>
                    <input type="text" class="form-control" id="input-first-name" placeholder="Enter First Name" required="required" value="<?php echo $_SESSION['user']['firstName']?>">
                </div>
                <div class="form-group">
                    <label for="input-last-name">Last Name</label>
                    <input type="text" class="form-control" id="input-last-name" placeholder="Enter Last Name" required="required" value="<?php echo $_SESSION['user']['lastName']?>">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="input-birthdate">Birthday</label>
                        <input type="text" class="form-control" id="input-birthdate" placeholder="10-10-2010" required="required" value="<?php echo $_SESSION['user']['birthDate']?>">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="input-ava">Ava Url</label>
                        <input type="text" class="form-control" id="input-ava" placeholder="Enter URL" required="required" value="<?php echo $_SESSION['user']['ava']?>">
                    </div>
                </div>
                <small class="form-text state" style="color: deepskyblue; display: none"></small>
                <div class="alert alert-danger" role="alert" id="personal-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success btn-block" id="button-update-personal">Update</button>
            </form>
            <script>
                $('document').ready(function(){
                    $('input[type=text]').keypress(function(){
                        $('#personal-response').hide();
                    });
                    $('input[type=password').keypress(function(){
                        $('#password-response').hide();
                    });
                   $('#button-update-personal').click(function(){
                       firstName = $('#input-first-name').val();
                       lastName = $('#input-last-name').val();
                       birthDate = $('#input-birthdate').val();
                       ava = $('#input-ava').val();
                       if (firstName == ''){
                           $('#personal-response').show();
                           $('#personal-response').text('First Name cannot be empty');
                           return;
                       }
                       if (lastName == ''){
                           $('#personal-response').show();
                           $('#personal-response').text('Last Name cannot be empty');
                           return;
                       }
                       if (birthDate == ''){
                           $('#personal-response').show();
                           $('#personal-response').text('Birthday cannot be empty');
                           return;
                       }
                      $.post('server.php', {updatePersonal: 'ok', firstName: firstName, lastName: lastName, birthDate: birthDate, ava: ava, user_id: <?php echo $_SESSION['user']['id']?>})
                       .done(function(msg){
                           if (msg['code'] == 200){
                               alert('Successfully updated!');
                               location.reload();
                           }
                           else{
                               $('#personal-response').show();
                               $('#personal-response').text('Error');
                           }
                       });
                   });
                   $('#button-update-password').click(function(){
                       current_password = $('#current-password').val();
                       new_password = $('#new-password').val();
                       retype_password = $('#retype-password').val();
                       if (current_password == ''){
                           $('#password-response').show();
                           $('#password-response').text('Current password cannot be empty');
                           return;
                       }
                       $.post('server.php', {
                           updatePassword: 'ok',
                           current_password: current_password,
                           new_password: new_password,
                           retype_password: retype_password,
                           user_id: <?php echo $_SESSION['user']['id']?>
                       }).done(function(msg){
                           if (msg['code'] == 200){
                               alert('Password updated successfully!');
                               location.reload();
                           }else{
                               $('#password-response').show();
                               $('#password-response').text(msg['message']);
                           }
                       });
                   });
                   $('textarea').keypress(function(){
                       $('#description-response').hide();
                   });
                   $('#button-update-description').click(function(){
                      description = $('#description').val();
                      if (description == ''){
                          $('#description-response').show();
                          $('#description-response').text('Description cannot be empty');
                          return;
                      }
                      $.post('server.php', {updateDescription: 'ok', description: description, user_id: <?php echo $_SESSION['user']['id']?>})
                       .done(function(msg){
                          if (msg['code'] == 200){
                              alert('Description updated successfully');
                              location.reload();
                          }else{
                              $('#description-response').show();
                              $('#description-response').text('Error');
                          }
                       });
                   });
                });
            </script>
        </div>
        <div class="password-container">
            <h4 class="text-center">Update password</h4>
            <hr>
            <form>
                <div class="form-group">
                    <label for="current-password">Current password</label>
                    <input type="password" class="form-control" id="current-password" placeholder="Enter Current password" required="required">
                </div>
                <div class="form-group">
                    <label for="new-password">New password</label>
                    <input type="password" class="form-control" id="new-password" placeholder="Enter New password" required="required">
                </div>
                <div class="form-group">
                    <label for="retype-password">Re-type password</label>
                    <input type="password" class="form-control" id="retype-password" placeholder="Re-type password" required="required">
                </div>
                <small class="form-text state" style="color: deepskyblue; display: none"></small>
                <div class="alert alert-danger" role="alert" id="password-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success btn-block" id="button-update-password">Update</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="description-container">
            <h4 class="text-center">Update description</h4>
            <hr>
            <form>
                <div class="form-group">
                    <label for="description">About me</label>
                    <textarea class="form-control" id="description" rows="5" required="required"><?php echo $_SESSION['user']['description']?></textarea>
                </div>
                <div class="alert alert-danger" role="alert" id="description-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success" id="button-update-description">Update description</button>
            </form>
        </div>
    </div>

    <footer class="page-footer font-small bg-dark text-white pt-4" style="margin-top: 200px;">
        <div class="container text-center text-md-left mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">BeeShy</h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>Tell us about your observations and concerns. Do not be shy</p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="main.php">News</a>
                    </p>
                    <p>
                        <a href="tags.php">Tags</a>
                    </p>
                    <p>
                        <a href="create.php">Create</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <i class="fas fa-home mr-3"></i> Nur-sultan, KZ</p>
                    <p>
                        <i class="fas fa-envelope mr-3"></i> dev.chinga@gmail.com</p>
                    <p>
                        <i class="fas fa-phone mr-3"></i> + 7 777 111 2233</p>
                    <p>
                        <i class="fas fa-phone mr-3"></i> + 7 776 208 6923</p>

                </div>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a> Shyngys Rakhad & Beigut Beisenkhan</a>
        </div>
    </footer>
    </body>
</hmtl>