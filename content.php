<?php
$post_id = $_GET['id'];
session_start();
include_once 'sessionCheck.php';
?>
    <!DOCTYPE html>
    <hmtl>

        <head>
            <title>Discussion</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
            <link href="fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                    crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            <style>
                *{
                    color: #495057;
                }
                .lol{
                    background: white;
                    box-shadow: 0px 0px 0px transparent;
                    border: 0px solid transparent;
                    text-shadow: 0px 0px 0px transparent;
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
                    width: 150px;
                    text-align: right;
                }
                .flex {
                    display: flex;
                }
                p small, span, div small {
                    display: block;
                }
                .tags a{
                    margin: 4px 5px;
                }
                .tags {
                    position: absolute;
                    bottom: 10px;
                }
                .pre-items {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin: 15px 0px;
                }
                .commentContainer {
                    box-shadow: 0 0 10px rgba(0,0,0,0.5);
                    margin-top: 30px;
                }
                .curPage{
                    pointer-events: none;
                }
                form{
                    margin-block-end: 0;
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
                    $('#comment_content').keypress(function(){
                       $('#comment_response').hide();
                    });
                    $('#anonBox').click(function(){
                        if ($(this).is(':checked')){
                            $('#comment_author').val(0);
                        } else {
                            $('#comment_author').val(<?php echo $_SESSION['user']['id']?>);
                        }
                    });
                    $('#upVote').click(function(){
                        $.post('server.php', {upVote: 'ok', post_id: <?php echo $post_id?>, author: <?php echo $_SESSION['user']['id']?>})
                            .done(function(msg){
                                if (msg['message'] == 'vote removed'){
                                    $('#upVote i').removeAttr('style');
                                    $('#votes').text(parseInt($("#votes").text(), 10) - 1);
                                }
                                else if(msg['message'] == 'vote changed'){
                                    $('#upVote i').css('color', '#057bfe');
                                    $('#downVote i').removeAttr('style');
                                    $('#votes').text(parseInt($("#votes").text(), 10) + 2);
                                }
                                else{
                                    $('#upVote i').css('color', '#057bfe');
                                    $('#votes').text(parseInt($("#votes").text(), 10) + 1);
                                }
                            });
                    });

                    $('#downVote').click(function(){
                        $.post('server.php', {downVote: 'ok', post_id: <?php echo $post_id?>, author: <?php echo $_SESSION['user']['id']?>})
                            .done(function(msg){
                                if (msg['message'] == 'vote removed'){
                                    $('#downVote i').removeAttr('style');
                                    $('#votes').text(parseInt($("#votes").text(), 10) + 1);
                                }
                                else if(msg['message'] == 'vote changed'){
                                    $('#downVote i').css('color', '#057bfe');
                                    $('#upVote i').removeAttr('style');
                                    $('#votes').text(parseInt($("#votes").text(), 10) - 2);
                                }
                                else{
                                    $('#downVote i').css('color', '#057bfe');
                                    $('#votes').text(parseInt($("#votes").text(), 10) - 1);
                                }
                            });
                    });
                });
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

        <?php
        require_once 'Post.php';
        require_once 'Vote.php';
        $current_post = new Post($post_id);
        if (!isset($_GET['id']) || $current_post->getTitle() == ''){
            print "<p class='w-100 text-center m-5 h1'>Content Not Found</p>";
            return;
        }

        $per_page = 5;
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        } else{
            $page = 1;
        }
        ?>

        <div class="main-content container mt-5" >
            <h2><?php echo $current_post->getTitle()?></h2>
            <hr>
            <div class="item-content list-group-item">
                <div class="mr-3 text-center" style="width: 50px;">
                    <?php
                        if (Vote::getPostVote($post_id, $_SESSION['user']['id']) == 1){
                            $upVoteStyle = 'style="color: #057bfe"';
                            $downVoteStyle = '';
                        }
                        elseif (Vote::getPostVote($post_id, $_SESSION['user']['id']) == 0){
                            $upVoteStyle = '';
                            $downVoteStyle = 'style="color: #057bfe"';
                        }
                        else{
                            $upVoteStyle = '';
                            $downVoteStyle = '';
                        }
                        if (Post::isMyPost($_SESSION['user']['id'] ,$_GET['id'])){
                            $disabled = 'disabled';
                        }
                    ?>
                    <button type="button" class="lol"  id="upVote" <?php echo $disabled?>>
                        <i class="fas fa-caret-up fa-2x" <?php echo $upVoteStyle?>></i>
                    </button>
                    <span class="text-center"><span class="text-center" id="votes"><?php echo $current_post->getVotes(); ?></span> <small> Votes</small></span>
                    <button type="button" class="lol" id="downVote" <?php echo $disabled?>>
                        <i class="fas fa-caret-down fa-2x" <?php echo $downVoteStyle?>></i>
                    </button>
                </div>
                <div class="w-100">
                    <div class="d-flex w-100 justify-content-between content">
                        <p class="mb-1"><?php echo $current_post->getContent(); ?></p>
                        <small><?php echo $current_post->getAuthor(); ?>
                            <small><?php echo $current_post->getDate() ?></small>
                            <div class="mt-5">
                                <?php
                                if (Post::isMyPost($_SESSION['user']['id'], $post_id)){
                                    ?>
                                    <button type="button" class="lol" data-toggle="modal" data-target="#updateModal">
                                        <i class="fas fa-edit" style="color: #057bfe"></i>
                                    </button>
                                    <button type="button" class="lol" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash" style="color: #dc3444"></i>
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </small>
                    </div>
                    <br>
                    <div class="tags">
                        <?php
                        $tags_array = $current_post->getTags();
                        for ($i = 0; $i < sizeof($tags_array); ++$i){
                            $tag_name = $tags_array[$i]['name'];
                            $tag_id = $tags_array[$i]['id'];
                            print "<a href=\"main.php?tag=$tag_id\" target=\"_blank\" class=\"badge badge-primary badge-pill\">$tag_name</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div>
                <div class="pre-items">
                    <div>
                        <?php
                        $start_from = ($page-1) * $per_page;
                        $total_pages = ceil($current_post->getComments() / $per_page); // calculate total pages with results
                        print "<div class='btn-group mt-3' role='group' aria-label=\"Pages\">";
                        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
                            echo "<a href='?id=$post_id&page=$i' class='btn btn-secondary";
                            if ($i == $page) echo " curPage active";
                            echo "'>$i</a>";
                        };
                        print "</div>"
                        ?>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal">Leave a comment</button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reportModal">Report</button>
                    </div>
                </div>
                <div>
                    <?php
                    require_once 'Comment.php';
                    $comments_array = Comment::getAllComments($post_id);
                    for ($i = 0; $i < sizeof($comments_array); ++$i){
                        $comment_id = $comments_array[$i]['comment_id'];
                        $comment_author_id = $comments_array[$i]['user_id'];
                        $comment_author = $comments_array[$i]['firstName'] . ' ' . $comments_array[$i]['lastName'];
                        $comment_date = $comments_array[$i]['date_'];
                        $comment_content = $comments_array[$i]['content'];
                        $comment_votes = $comments_array[$i]['votes'];

                        if (Vote::getCommentVote($comment_id, $_SESSION['user']['id']) == 1){
                            $upVoteStyle = 'style="color: #057bfe"';
                            $downVoteStyle = '';
                        }
                        elseif (Vote::getCommentVote($comment_id, $_SESSION['user']['id']) == 0){
                            $upVoteStyle = '';
                            $downVoteStyle = 'style="color: #057bfe"';
                        }
                        else{
                            $upVoteStyle = '';
                            $downVoteStyle = '';
                        }
                        if (Comment::isMyComment($_SESSION['user']['id'], $comment_id)){
                            $disabled_comment = 'disabled';
                        }

                        ?>

                    <div class="item-content list-group-item">

                        <div class="mr-3 text-center" style="width: 50px;">
                            <button class="lol" type="button" onclick="upVoteComment(<?php echo $comment_id?>, this);" <?php echo $disabled_comment?>>
                                <i class="fas fa-caret-up fa-2x" <?php echo $upVoteStyle?>></i>
                            </button>
                            <span class="text-center"><span><?php echo $comment_votes?></span> <small>Votes</small></span>
                            <button type="button" class="lol" onclick="downVoteComment(<?php echo $comment_id?>, this);" <?php echo $disabled_comment?>>
                                <i class="fas fa-caret-down fa-2x" <?php echo $downVoteStyle?>></i>
                            </button>
                        </div>
                        <div class="w-100">
                            <div class="d-flex w-100 justify-content-between content">
                                <p class="mb-1"><?php echo $comment_content; ?></p>
                                <small><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                    <?php
                                        if (Comment::isMyComment($_SESSION['user']['id'], $comment_id)){
                                    ?>
                                        <button type="button" class="lol mt-5" onclick="showUpdateCommentModal('<?php echo $comment_content?>', <?php echo $comment_author_id?>, <?php echo $comment_id?>);">
                                            <i class="fas fa-edit" style="color: #057bfe"></i>
                                        </button>
                                        <button type="button" class="lol mt-5" onclick="comment(<?php echo $comment_id?>, 6);">
                                            <i class="fas fa-trash" style="color: #dc3444"></i>
                                        </button>
                                    <?php
                                        }
                                    ?>
                                </small>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                    <script>
                        function comment(comment_id, author_id){
                            event.preventDefault();
                            $.post('server.php', {removeComment: 'ok', comment_id: comment_id, author: author_id})
                            .done(function(msg){
                                if (msg['code'] == 200)
                                    location.reload();
                                else
                                    alert('Error removing comment');
                            });
                        }
                        function upVoteComment(id, b){
                            var voteCount = $(b).siblings('span').children('span');
                            var iconSibling = $(b).siblings('button').children('i');
                            var iconThis = $(b).children('i');

                            $.post('server.php', {upVoteComment: 'ok', comment_id: id, author: <?php echo $_SESSION['user']['id']?>})
                                .done(function(msg){
                                    if (msg['message'] == 'vote removed'){
                                        iconThis.removeAttr('style');
                                        voteCount.text(parseInt(voteCount.text(), 10) - 1);
                                    }
                                    else if(msg['message'] == 'vote changed'){
                                        iconThis.css('color', '#057bfe');
                                        iconSibling.removeAttr('style');
                                        voteCount.text(parseInt(voteCount.text(), 10) + 2);
                                    }
                                    else{
                                        iconThis.css('color', '#057bfe');
                                        voteCount.text(parseInt(voteCount.text(), 10) + 1);
                                    }
                                });
                        }

                        function downVoteComment(id, b){
                            var voteCount = $(b).siblings('span').children('span');
                            var iconSibling = $(b).siblings('button').children('i');
                            var iconThis = $(b).children('i');

                            $.post('server.php', {downVoteComment: 'ok', comment_id: id, author: <?php echo $_SESSION['user']['id']?>})
                                .done(function(msg){
                                    if (msg['message'] == 'vote removed'){
                                        iconThis.removeAttr('style');
                                        voteCount.text(parseInt(voteCount.text(), 10) + 1);
                                    }
                                    else if(msg['message'] == 'vote changed'){
                                        iconThis.css('color', '#057bfe');
                                        iconSibling.removeAttr('style');
                                        voteCount.text(parseInt(voteCount.text(), 10) - 2);
                                    }
                                    else{
                                        iconThis.css('color', '#057bfe');
                                        voteCount.text(parseInt(voteCount.text(), 10) - 1);
                                    }
                                });
                        }
                    </script>
                </div>
            </div>
        </div style="display: none;">
        <div class="deleted-message text-center" style="margin: 300px 0; display: none;">
            <h1 class="display-4">The content was deleted :(</h1>
        </div>
        <div class="modal" id='deleteModal' tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete a post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="button-delete" onclick="deletePost();">Delete</button>
                    </div>
                    <script>
                        function deletePost(){
                            event.preventDefault();
                            $.post('server.php', {deletePost: 'ok', post_id: <?php echo $post_id?>, author: <?php echo $_SESSION['user']['id']?>})
                                .done(function(msg){
                                    if (msg['code'] == 200){
                                        $('#deleteModal').modal('hide');
                                        $('.main-content').hide();
                                        $('.deleted-message').show();
                                        window.open('main.php');
                                    }
                                    else
                                        alert('Error');
                                });
                        }
                    </script>
                </div>
            </div>
        </div>


        <!--insert into posts(`author_id`, `title`, `content`, `date_`)
        values (6, 'Test', 'Test 2', 'Today');-->

        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">New comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="comment_content" class="col-form-label">Comment:</label>
                                <textarea class="form-control" name="content" id="comment_content" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="anonBox">
                                    <label class="form-check-label" for="anonBox">
                                        Anonymous
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" id="comment_author" value="<?php echo $_SESSION['user']['id']?>">
                        </div>
                        <div class="alert alert-danger mr-3 ml-3" role="alert" id="comment_response" style="display: none;">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-primary" id="button-create-comment" value="Send message"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="updateCommentModal" tabindex="-1" role="dialog" aria-labelledby="updateCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCommentModalLabel">Update comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="update_comment_content" class="col-form-label">Comment:</label>
                                <textarea class="form-control" id="update_comment_content" rows="4"></textarea>
                            </div>
                            <input type="hidden" id="comment_author" value="<?php echo $_SESSION['user']['id']?>">
                        </div>
                        <input type="hidden" id="update_comment_author">
                        <input type="hidden" id="update_comment_id">
                        <div class="alert alert-danger mr-3 ml-3" role="alert" id="update_comment_response" style="display: none;">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-primary" id="button-update-comment" onclick="updateComment();" value="Update comment"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $('document').ready(function(){
                $('#button-create-comment').click(function(){
                    event.preventDefault();
                    $.post('server.php', {createComment: 'ok', post_id: <?php echo $post_id?>, author: $('#comment_author').val(), content: $('#comment_content').val()})
                        .done(function(msg){

                            if (msg['code'] == 200){
                                location.reload();
                            }else if (msg['code'] == 300){
                                $('#comment_response').show();
                                $('#comment_response').text(msg['message']);
                            }
                            else{
                                $('#comment_response').show();
                                $('#comment_response').text(msg['message']);
                            }
                        });
                });
            });
        </script>

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="udpateModalLabel">Update the discussion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="dis_title" class="col-form-label">Update the title:</label>
                                <input type="text" class="form-control" id="dis_title" value="<?php echo $current_post->getTitle()?>">
                            </div>
                            <div class="form-group">
                                <label for="dis_content" class="col-form-label">Update the content:</label>
                                <textarea class="form-control" name="dis_content" id="dis_content" rows="5"><?php echo $current_post->getContent()?></textarea>
                            </div>
                        </div>
                        <div class="alert alert-danger mr-3 ml-3" role="alert" id="dis_response" style="display: none;">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-primary" id="button-update-discussion" value="Update" onclick="updateDiscussion();"/>
                        </div>
                        <script>
                            $('#update_comment_content').keypress(function () {
                                $('#update_comment_response').hide();
                            });
                            function showUpdateCommentModal(content, author, id){
                                $('#updateCommentModal').modal('show');
                                $('#update_comment_content').val(content);
                                $('#update_comment_author').val(author);
                                $('#update_comment_id').val(id);
                            }
                            function updateComment(){
                                content = $('#update_comment_content').val();
                                if (content == ''){
                                    $('#update_comment_response').show();
                                    $('#update_comment_response').text('Content cannot be empty');
                                    return;
                                }
                                $.post('server.php', {updateComment: 'ok', content: content, comment_id: $('#update_comment_id').val(), author: $('#update_comment_author').val()})
                                .done(function(msg){
                                   if (msg['code'] == 200){
                                       location.reload();
                                   }else{
                                       $('#update_comment_response').show();
                                       $('#update_comment_response').text('Error');
                                   }
                                });
                            }

                            $('#dis_content').keypress(function(){
                                $('#dis_response').hide();
                            });
                            function updateDiscussion(){
                                title = $('#dis_title').val();
                                content = $('#dis_content').val();
                                if (title == '' || content == ''){
                                    $('#dis_response').show();
                                    $('#dis_response').text('Please, fill the required fields!');
                                    return;
                                }
                                $.post('server.php', {
                                    updateDiscussion: 'ok',
                                    post_id: <?php echo $post_id?>,
                                    author: <?php echo $_SESSION['user']['id']?>,
                                    title: title,
                                    content: content
                                }).done(function(msg){
                                   if (msg['code'] == 200){
                                       alert('Successfully updated!');
                                       location.reload();
                                   }else{
                                       $('#dis_response').show();
                                       $('#dis_response').text('Error');
                                   }
                                });
                            }
                        </script>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="content.php?id=<?php echo $post_id?>&page=<?php echo $page?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reportFormControlSelect">Why are you reporting this post?</label>
                                <select class="form-control" id="reportFormControlSelect" name="report">
                                    <option>It's spam</option>
                                    <option>Hate speech or symbols</option>
                                    <option>Violence or dangerous organization</option>
                                    <option>Suicide, self-injury</option>
                                    <option>Sale of illegal or regulated goods</option>
                                </select>
                            </div>
                            <input type="hidden" name="author" id="author" value="<?php echo $_SESSION['user']['id']?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Submit report"/>
                        </div>
                    </form>
                </div>
            </div>
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
<?php
