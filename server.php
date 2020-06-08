<?php
require_once 'Vote.php';
require_once 'Comment.php';
require_once 'Post.php';
header('Content-Type: application/json');

if (isset($_POST['upVote'])){
    $author = $_POST['author'];
    $post_id = $_POST['post_id'];
    $result = Vote::toVoteUpPost($post_id, $author);
    if ($result == -1){
        echo json_encode(array('message' => 'vote removed'));
        return;
    }
    elseif ($result == 2){
        echo json_encode(array('message' => 'vote changed'));
        return;
    }
    else{
        echo json_encode(array('message' => 'voted up'));
        return;
    }
}

if (isset($_POST['downVote'])){
    $author = $_POST['author'];
    $post_id = $_POST['post_id'];
    $result = Vote::toVoteDownPost($post_id, $author);
    if ($result == 1){
        echo json_encode(array('message' => 'vote removed'));
        return;
    }
    elseif ($result == -2){
        echo json_encode(array('message' => 'vote changed'));
        return;
    }
    else{
        echo json_encode(array('message' => 'voted down'));
        return;
    }
}

if (isset($_POST['upVoteComment'])){
    $comment_id = $_POST['comment_id'];
    $author = $_POST['author'];
    $result = Vote::toVoteUpComment($comment_id, $author);
    if ($result == -1){
        echo json_encode(array('message' => 'vote removed'));
        return;
    }
    elseif ($result == 2){
        echo json_encode(array('message' => 'vote changed'));
        return;
    }
    else{
        echo json_encode(array('message' => 'voted up'));
        return;
    }
}

if (isset($_POST['downVoteComment'])){
    $comment_id = $_POST['comment_id'];
    $author = $_POST['author'];
    $result = Vote::toVoteDownComment($comment_id, $author);
    if ($result == 1){
        echo json_encode(array('message' => 'vote removed'));
        return;
    }
    elseif ($result == -2){
        echo json_encode(array('message' => 'vote changed'));
        return;
    }
    else{
        echo json_encode(array('message' => 'voted down'));
        return;
    }
}

if (isset($_POST['createComment'])){
    $author = $_POST['author'];
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    if ($content == ''){
        echo json_encode(array(
            'code'=>300,
            'message'=>'Content cannot be empty'
        ));
        return;
    }
    if (Comment::createComment($author, $post_id, $content) == 1){
        echo json_encode(array(
            'code'=>200,
            'message'=>'Success'
        ));
        return;
    }
    else{
        echo json_encode(array(
            'code'=>500,
            'message'=>'Error'
        ));
        return;
    }
}

if (isset($_POST['removeComment'])){
    $author = $_POST['author'];
    $comment_id = $_POST['comment_id'];
    if (Comment::removeComment($author, $comment_id) == 1){
        echo json_encode(array('code' => 200));
        return;
    }
    echo json_encode(array('code' => 300));
    return;
}

if (isset($_POST['deletePost'])){
    $post_id = $_POST['post_id'];
    $author = $_POST['author'];
    if (Post::deletePost($post_id, $author) == 1){
        echo json_encode(array('code' => 200));
        return;
    }
    echo json_encode(array('code' => 300));
    return;
}

if (isset($_POST['updateDiscussion'])){
    $post_id = $_POST['post_id'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    if (Post::updatePost($post_id, $author, $title, $content) == 1){
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code' => 300));
    return;
}

if (isset($_POST['createPost'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $tags = $_POST['tags'];
    $tags_array = explode(',', $tags);

    $id = Post::createPost($author, $title, $content, $tags);
    if ($id != null){
        echo json_encode(array('code'=>200, 'id'=>$id));
        return;
    }
    echo json_encode(array('code'=>501));
    return;
}


if (isset($_POST['updatePersonal'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $user_id = $_POST['user_id'];
    $ava = $_POST['ava'];
    if ($ava == ''){
        $ava = 'https://image.flaticon.com/icons/svg/2919/2919600.svg';
    }
    $sql = 'update users set firstName = "' . $firstName . '", lastName = "' . $lastName . '", birthdate = "' . $birthDate . '", ava = "' . $ava . '" where user_id = ' . $user_id;
    if (Database::executeData($sql)){
        session_start();
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['birthDate'] = $birthDate;
        $_SESSION['user']['ava'] = $ava;
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code'=>501));
    return;
}

if (isset($_POST['updatePassword'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];
    $user_id = $_POST['user_id'];
    $sql = 'select * from users where user_id = ' . $user_id . ' and password = "' . $current_password . '"';
    if (sizeof(Database::getData($sql)) == 0){
        echo json_encode(array('code' => 300, 'message'=>'Password is incorrect'));
        return;
    }else{
        if ($new_password == '' || $current_password == ''){
            echo json_encode(array('code'=>300, 'message'=>'New password cannot be empty'));
            return;
        }
        if ($new_password == $retype_password){
            $sql = 'update users set password = "' . $new_password . '" where user_id = ' . $user_id;
            Database::executeData($sql);
            echo json_encode(array('code'=>200));
            return;
        }else{
            echo json_encode(array('code'=>400, 'message'=>'Passwords do not match'));
            return;
        }
    }
}

if (isset($_POST['updateDescription'])){
    session_start();
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];
    $sql = 'update users set description = "' . $description . '" where user_id = ' . $user_id;
    if (Database::executeData($sql)){
        $_SESSION['user']['description'] = $description;
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code'=>300));
    return;
}

if (isset($_POST['updateComment'])){
    $content = $_POST['content'];
    $author = $_POST['author'];
    $comment_id = $_POST['comment_id'];
    $sql = 'update comments set content = "' . $content . '" where author_id = ' . $author;
    if (Database::executeData($sql)){
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code'=>300));
    return;
}