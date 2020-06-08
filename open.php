<?php
require_once 'Post.php';
require_once 'User.php';
require_once 'Comment.php';
require_once 'Tag.php';
require_once 'Vote.php';
require_once 'Database/Database.php';

echo Tag::getTagName(1);