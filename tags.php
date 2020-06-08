<?php
session_start();
include_once 'sessionCheck.php';
?>
<!DOCTYPE html>
<hmtl>
    <head>
        <title>All tags</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
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
            .flex {
            	display: flex;
            }
            footer h6, footer p, footer a, footer a:hover{
                color: white;
                text-decoration: none;
            }
            footer hr{
                background-color: white;
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
                    <li class="nav-item" style="border-bottom: 1px solid white">
                        <a class="nav-link" href="tags.php">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Users</a>
                    </li>
                </ul>
                <form class="form-inline" style="padding-right: 100px;">
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
                </form>
            </div>
        </nav>
        <div class="container mt-5">
        	<h4>All tags</h4>
        	<hr>
        	<div class="row">
                <?php
                    require 'Tag.php';
                    $tags_array = Tag::getAllTags();
                    for ($i = 0; $i < sizeof($tags_array); ++$i){
                        $postsCount = Tag::getPostsCountByTags($tags_array[$i]['tag_id']);
                        ?>
                        <a href="main.php?tag=<?php echo $tags_array[$i]['tag_id']?>" class="card list-group-item-action" style="width: 15rem; margin: 5px;">
                            <div class="card-body">
                                <h5><?php echo $tags_array[$i]['name']?></h5>
                                <p class="mb-1"><?php echo $postsCount?> posts</p>
                            </div>
                        </a>
                        <?php
                    }
                ?>
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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</hmtl>