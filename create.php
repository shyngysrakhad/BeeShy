<?php
session_start();
require 'Database/Database.php';
include_once 'sessionCheck.php';
?>

<!DOCTYPE html>
<hmtl>
    <head>
        <title>BeeShy</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <style>
            *{
                color: #495057;
            }
            li {
                padding-left: 20px;
                padding-right: 20px;
            }
            .navbar-brand {
                padding-left: 100px;
            }
            .item-content {
                display: flex;
            }
            .title small, .content small {
                width: 200px;
                text-align: right;
            }
            p small {
                display: block;
            }
            .title small {
                font-weight: bold;
            }
            form {
                box-shadow: 0 0 10px rgba(0,0,0,0.5);
            }
            #myInput {
                padding: 20px;
                margin-top: -6px;
                border: 0;
                border-radius: 0;
                background: #f1f1f1;
            }
            li{
                cursor: pointer;
            }
            footer h6, footer p, footer a, footer a:hover{
                color: white;
                text-decoration: none;
            }
            footer hr{
                background-color: white;
            }
        </style>
        <script>
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu li").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
                $('#title').keypress(function(){
                    $('#response-message').hide();
                });
                $('#content').keypress(function(){
                    $('#response-message').hide();
                });

                $('#create-post').click(function(){
                    title = $('#title').val();
                    content = $('#content').val();
                    tags = $('#tags_id').val();
                    author = $('#author').val();

                    if (title == ''){
                        $('#response-message').show();
                        $('#response-message').text("Title cannot be empty");
                        return;
                    }
                    if (content == ''){
                        $('#response-message').show();
                        $('#response-message').text("Content cannot be empty");
                        return;
                    }
                    if (tags == ''){
                        $('#response-message').show();
                        $('#response-message').text("Please, choose tags");
                        return;
                    }
                    $.post('server.php', {createPost: 'ok', title: title, content: content, author: author, tags: tags})
                        .done(function(msg){
                            if (msg['code'] == 200){
                                alert('Successfully created!');
                                window.location.href = 'content.php?id=' + msg['id'];
                            }
                            else{
                                $('#response-message').show();
                                $('#response-message').text("Error :(");
                            }
                        });
                });

                $('.list-group-item').click(function(event){
                    tags = document.getElementsByClassName('tags')[0];
                    if (!$("#tags_id").val().includes($(this).attr('data-value'))) {
                        tag = document.createElement('button');
                        tag.innerHTML = $(this).text();
                        tag.value = $(this).attr('data-value');
                        tag.className = "btn btn-secondary mt-3 mr-3 btn-sm";
                        $(tag).click(function(){
                            $(this).remove();
                            var new_tags = $("#tags_id").val().replace($(this).val(), "");
                            if (new_tags.charAt(0) == ',') {
                                $("#tags_id").val(new_tags.substr(1));
                            }else{
                                $("#tags_id").val(new_tags);
                            }
                        });
                        tags.appendChild(tag);
                        var selectedTags = $("#tags_id").val();
                        if (!selectedTags.includes($(this).attr('data-value'))) {
                            if (selectedTags === "") {
                                $("#tags_id").val($(this).attr('data-value'));
                            }else{
                                $("#tags_id").val(selectedTags + "," + $(this).attr('data-value'));
                            }
                        }
                    }else{
                        alert($(this).text() + " is already added!");
                    }

                });
                $('#anonCheckBox').click(function(){
                    if ($(this).is(':checked')){
                        $('#author').val(0);
                    } else {
                        $('#author').val(<?php echo $_SESSION['user']['id']?>);
                    }
                });
            })
        </script>
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
            <div class="form-inline" style="padding-right: 100px;">
                <ul class="navbar-nav mr-auto">
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
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Open a public discussion</h1>
        <form class="mt-5 p-4">
            <div class="form-group">
                <label for="title">Enter Your Title</label>
                <input type="text" name="title" class="form-control" id="title" required="required">
            </div>
            <div class="form-group">
                <label for="content">Enter Your Content</label>
                <textarea class="form-control" name="content" id="content" rows="3" required="required"></textarea>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">Select tags
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    <?php
                        $tag_array = Database::getData('select * from tags');
                        for ($i = 0; $i < sizeof($tag_array); ++$i){
                            $id = $tag_array[$i]['tag_id'];
                            $name = $tag_array[$i]['name'];
                            ?>
                            <li class="list-group-item list-group-item-action" data-value="<?php echo $id?>"><?php echo $name?></li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            <div class="form-group">
                <div class="tags">

                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="anonCheckBox">
                    <label class="form-check-label" for="anonCheckBox">
                        Anonymous
                    </label>
                </div>
            </div>
            <input type="hidden" name="tags" id="tags_id" value="">
            <input type="hidden" name="author" id="author" value="<?php echo $_SESSION['user']['id']?>">
            <hr>
            <div class="alert alert-danger" role="alert" id="response-message" style="display: none;">
                A simple danger alert—check it out!
            </div>
            <input type="button" class="btn btn-primary btn-block" id="create-post" value="Post">
        </form>
    </div>
    <footer class="page-footer font-small bg-dark text-white pt-4 mt-5">
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