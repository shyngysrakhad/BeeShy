<?php
session_start();
include_once 'sessionCheck.php';
$sort = $_GET['sortBy'];

if ($sort == 'comm'){
    $_COOKIE['how'] = 'com';
    $style1 = '';
    $style2 = '';
    $style3 = 'active';
}
elseif ($sort == 'post'){
    $_COOKIE['how'] = 'post';
    $style1 = '';
    $style2 = 'active';
    $style3 = '';
}
elseif ($sort == 'mix'){
    $_COOKIE['how'] = 'mix';
    $style1 = 'active';
    $style2 = '';
    $style3 = '';
} else{
    $_COOKIE['how'] = 'mix';
    $style1 = 'active';
    $style2 = '';
    $style3 = '';
}
?>

<!DOCTYPE html>
<hmtl>
    <head>
        <title>Rating</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
            .main{
                display: flex;
                justify-content: space-between;
            }
            .curPage{
                pointer-events: none;
            }
            footer h6, footer p, footer a, footer a:hover{
                color: white;
                text-decoration: none;
            }
            footer hr{
                background-color: white;
            }
            .btn-group-toggle a{
                color: white;
            }
            #curRate{
                border-bottom: 2px solid white;
            }
            .btn-group-toggle a{
                color: white;
            }
        </style>
    </head>
    <body>
    <?php include_once('nav.php');?>
    <div class="container mt-5">
        <div class="main">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary <?php echo $style1;?>">
                    <a href="ratings.php?sortBy=mix">Mix Rating</a>
                </label>
                <label class="btn btn-secondary <?php echo $style2;?>">
                    <a href="ratings.php?sortBy=post">Post Rating</a>
                </label>
                <label class="btn btn-secondary <?php echo $style3;?>">
                    <a  href="ratings.php?sortBy=comm">Comment Rating</a>
                </label>
            </div>

        </div>
        <hr>
        <div class="list-group">
            <table class='table'>
                <thead class='thead-dark'>
                <tr><th scope='col'>#</th>
                    <th scope='col'>Ava</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Post Votes</th>
                    <th scope="col">Comment Votes</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once("showRatings.php");
                ?>
        </div>
        <?php require_once('footer.php');?>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</hmtl>