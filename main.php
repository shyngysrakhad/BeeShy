<?php
session_start();
include_once 'sessionCheck.php';
?>

<!DOCTYPE html>
<hmtl>
    <head>
        <title>BeeShy</title>
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
                    <a style="border-bottom: 1px solid white" class="nav-link" href="main.php">News</a>
                </li>
                <li class="nav-item">
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
                            <a class="dropdown-item" href="create.php">Create</a>
                            <div class= "dropdown-divider"></div>
                            <a class="dropdown-item" href="auth/signOut.php">Sign out</a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="main">
            <?php
            require_once 'Tag.php';
            require_once 'User.php';
            $sort = $_GET['sortBy'];
            if (isset($_GET['tag'])){
                $tag_id = $_GET['tag'];
                $tag = 'tag=' . $tag_id . '&';
                if ($sort != '')
                    $title = 'sorted by ' . $sort . ', tag = ' . Tag::getTagName($tag_id);
                else
                    $title = 'sorted by tag = ' . Tag::getTagName($tag_id);
            }else{
                if ($sort != ''){
                    $title = 'sorted by ' . $sort;
                }
            }
            if ($sort == 'votes'){
                $radio_votes = 'checked';
                $votes_style = 'active';
            }
            elseif ($sort == 'date'){
                $radio_date = 'checked';
                $date_style = 'active';
            }
            elseif ($sort == 'recalls'){
                $radio_recalls = 'checked';
                $recalls_style = 'active';
            }else{
                $radio_date = 'checked';
                $date_style = 'active';
            }
            if (isset($_GET['author'])){
                $author = $_GET['author'];
                $user = new User($_GET['author']);
                $title = 'of user ' . $user->getFirstName() . ' ' . $user->getLastName();
            }
            ?>
            <h4>All discussions <?php echo $title?></h4>
            <div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary <?php echo $date_style?>">
                        <a href="main.php?<?php echo $tag?>sortBy=date" <?php echo $radio_date?>>Date</a>
                    </label>
                    <label class="btn btn-secondary <?php echo $votes_style?>">
                        <a href="main.php?<?php echo $tag?>sortBy=votes" <?php echo $radio_votes?>>Votes</a>
                    </label>
                    <label class="btn btn-secondary <?php echo $recalls_style?>">
                        <a  href="main.php?<?php echo $tag?>sortBy=recalls"<?php echo $radio_recalls?>>Recalls</a>
                    </label>
                </div>
            </div>

            <a href="create.php" class="btn btn-outline-primary float">Create a discussion</a>
        </div>
        <hr>
        <div class="list-group">
            <?php
            require_once 'Post.php';

            $per_page = 5;

            if(isset($_GET["page"])){
                $page = $_GET["page"];
            } else{
                $page = 1;
            }

            $start_from = ($page-1) * $per_page;

            if (isset($_GET["tag"])){
                $result = Post::getAllPostsByTag($_GET["tag"], $start_from, $per_page);
                $total_pages = ceil(Post::getAllPostCountByTag($_GET['tag']) / $per_page);
            }else{
                $result = Post::getAllPosts($start_from, $per_page);
                $total_pages = ceil(Post::getAllPostCount() / $per_page);
            }
            $sort = '';
            if (isset($_GET['sortBy'])){
                $sort = $_GET['sortBy'];
                switch ($sort){
                    case 'recalls':
                        usort($result, function($a, $b) {
                            return $a['comments'] - $b['comments'];
                        });
                        $result = array_reverse($result);
                        break;
                    case 'votes':
                        usort($result, function($a, $b) {
                            return $a['votes'] - $b['votes'];
                        });
                        $result = array_reverse($result);
                        break;
                    case 'date':
                        usort($result, function($a, $b) {
                            return $a['date_'] - $b['date_'];
                        });
                        break;
                }
            }
            if (isset($_GET['author'])){
                $result = Post::getAllPostsOfUser($user->getId(), $start_from, $per_page);
                $total_pages = ceil(Post::getAllPostCountByUser($_GET['author']) / $per_page);
            }
            for ($i = 0; $i < sizeof($result); ++$i){
                $current_post = new Post($result[$i]['post_id']);
                $tags = '';
                for ($q = 0; $q < sizeof($current_post->getTags()); ++$q){
                    $tag_name = $current_post->getTags()[$q]['name'];
                    if ($tags == '')
                        $tags = $tag_name;
                    else
                        $tags .= ', ' . $tag_name;
                }
                if (strlen($result[$i]['content']) > 250){
                    $result[$i]['content'] = substr($result[$i]['content'], 0, 250) . '...';
                }

                ?>
                <a href="content.php?id=<?php echo $result[$i]['post_id']?>" class="list-group-item list-group-item-action">
                    <div class="item-content">
                        <div class="mr-3" style="width: 50px;">
                            <p class="text-center"><?php echo $result[$i]['votes']?> <small>Votes</small></p>
                            <p class="text-center"><?php echo $result[$i]['comments']?> <small>Recalls</small></p>
                        </div>
                        <div class="w-100">
                            <div class="d-flex w-100 justify-content-between content">
                                <h5 class="mb-1"><?php echo $result[$i]['title']?></h5>
                                <small><?php echo $result[$i]['firstName'] . ' ' . $result[$i]['lastName']?></small>
                            </div>
                            <div class="d-flex w-100 justify-content-between content">
                                <p class="mb-1"><?php echo $result[$i]['content']?></p>
                                <small><?php echo $result[$i]['date_']?></small>
                            </div>
                            <small>Tags: <?php echo $tags?></small>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
        <?php
        print "<div class='btn-group mt-3' role='group' aria-label=\"Pages\">";
        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
            if (isset($_GET['tag'])){
                $tag = $_GET['tag'];
                echo "<a href='?tag=$tag&page=$i' class='btn btn-secondary";
            }
            else{
                if (isset($_GET['author']))
                    echo "<a href='?author=$author&page=$i' class='btn btn-secondary";
                else
                    echo "<a href='?page=$i' class='btn btn-secondary";
            }
            if ($i == $page) echo " curPage active";
            echo "'>$i</a>";
        };
        print "</div>"
        ?>

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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</hmtl>