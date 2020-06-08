<?php
require_once 'Database/Database.php';
class Vote{

    public static function toVoteUpPost($post_id, $author){
        if (Vote::getPostVote($post_id, $author) == 1){
            $sql = 'update posts set votes = votes - 1 where post_id = ' . $post_id;
            if (Database::executeData($sql)){
                $sql = 'delete from post_votes where post_id = ' . $post_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return -1;
        }elseif (Vote::getPostVote($post_id, $author) == 0){
            $sql = 'update posts set votes = votes + 2 where post_id = ' . $post_id;
            if (Database::executeData($sql)){
                $sql = 'update post_votes set type = 1 where post_id = ' . $post_id . ' and author_id = ' . $author;
                Database::executeData($sql);
                }
            return 2;
        }else{
            $sql = 'update posts set votes = votes + 1 where post_id = '. $post_id;
            if (Database::executeData($sql)){
                $sql = 'insert into post_votes (post_id, author_id, type) values (' . $post_id . ', ' . $author . ', 1);';
                Database::executeData($sql);
            }
            return 1;
        }
    }

    public static function toVoteUpComment($comment_id, $author){
        if (Vote::getCommentVote($comment_id, $author) == 1){
            $sql = 'update comments set votes = votes - 1 where comment_id = ' . $comment_id;
            if (Database::executeData($sql)){
                $sql = 'delete from comment_votes where comment_id = ' . $comment_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return -1;
        }elseif (Vote::getCommentVote($comment_id, $author) == 0){
            $sql = 'update comments set votes = votes + 2 where comment_id = ' . $comment_id;
            if (Database::executeData($sql)){
                $sql = 'update comment_votes set type = 1 where comment_id = ' . $comment_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return 2;
        }else{
            $sql = 'update comments set votes = votes + 1 where comment_id = '. $comment_id;
            if (Database::executeData($sql)){
                $sql = 'insert into comment_votes (comment_id, author_id, type) values (' . $comment_id . ', ' . $author . ', 1);';
                Database::executeData($sql);
            }
            return 1;
        }
    }

    public static function toVoteDownComment($comment_id, $author){
        if (Vote::getCommentVote($comment_id, $author) == 0){
            $sql = 'update comments set votes = votes + 1 where comment_id = ' . $comment_id;
            if (Database::executeData($sql)){
                $sql = 'delete from comment_votes where comment_id = ' . $comment_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return 1;
        }elseif (Vote::getCommentVote($comment_id, $author) == 1){
            $sql = 'update comments set votes = votes - 2 where comment_id = ' . $comment_id;
            if (Database::executeData($sql)){
                $sql = 'update comment_votes set type = 0 where comment_id = ' . $comment_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return -2;
        }else{
            $sql = 'update comments set votes = votes - 1 where comment_id = '. $comment_id;
            if (Database::executeData($sql)){
                $sql = 'insert into comment_votes (comment_id, author_id, type) values (' . $comment_id . ', ' . $author . ', 0);';
                Database::executeData($sql);
            }
            return -1;
        }
    }

    public static function toVoteDownPost($post_id, $author){
        if (Vote::getPostVote($post_id, $author) == 0){
            $sql = 'update posts set votes = votes + 1 where post_id = ' . $post_id;
            if (Database::executeData($sql)){
                $sql = 'delete from post_votes where post_id = ' . $post_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return 1;
        }elseif (Vote::getPostVote($post_id, $author) == 1){
            $sql = 'update posts set votes = votes - 2 where post_id = ' . $post_id;
            if (Database::executeData($sql)){
                $sql = 'update post_votes set type = 0 where post_id = ' . $post_id . ' and author_id = ' . $author;
                Database::executeData($sql);
            }
            return -2;
        }else{
            $sql = 'update posts set votes = votes - 1 where post_id = '. $post_id;
            if (Database::executeData($sql)){
                $sql = 'insert into post_votes (post_id, author_id, type) values (' . $post_id . ', ' . $author . ', 0);';
                Database::executeData($sql);
            }
            return -1;
        }
    }


    public static function toVoteComment($type, $comment_id, $author){
        if ($type == 1){
            $method = '+';
        }else{
            $method = '-';
        }
        $sql = 'update comments set votes = votes ' . $method . ' 1 where comment_id = ' . $comment_id;
        if (Database::executeData($sql)){
            if (self::getCommentVote($comment_id, $author) == -1){
                $sql2 = 'insert into comment_votes (comment_id, author_id, type) values (' . $comment_id . ', ' . $author . ', ' . $type . ');';
            }
            else
                $sql2 = 'update comment_votes set type = ' . $type . ' where comment_id = ' . $comment_id . ' and author_id = ' . $author;
            Database::executeData($sql2);
            return 1;
        }
        return 0;
    }

    public static function getPostVote($post_id, $author){
        $sql = 'select type from post_votes where post_id = ' . $post_id . ' and author_id = ' . $author;
        return self::getVote($sql);
    }

    public static function getCommentVote($comment_id, $author){
        $sql = 'select type from comment_votes where comment_id = ' . $comment_id . ' and author_id = ' . $author;
        return self::getVote($sql);
    }


    private static function getVote($sql){
        if (sizeof(Database::getData($sql)) > 0){
            return Database::getData($sql)[0]['type'];
        }
        return -1;
    }
}
