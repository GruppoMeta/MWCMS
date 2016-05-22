<?php
class museoweb_modules_comments_CommentException extends Exception
{
    public static function userNotLogged()
    {
        return new self('User not logged.');
    }

    public static function wrongParams($resourceId, $text)
    {
        return new self('Wrong params: '.$resourceId.' '.$text);
    }

    public static function notFound($id)
    {
        return new self('Comment not found #id: '.$id);
    }

    public static function forbidden()
    {
        return new self('Forbidden');
    }
}