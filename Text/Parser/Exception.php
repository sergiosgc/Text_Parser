<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
 * Top level exception for the Text_Parser package
 */
class Text_Parser_Exception extends Exception
{
}

class Text_Parser_InvalidStateStackException extends Text_Parser_Exception
{
}

class Text_Parser_EmptyStack_Exception extends Text_Parser_Exception
{
}

class Text_Parser_InvalidReduction_Exception extends Text_Parser_Exception
{
}

class Text_Parser_UnexpectedTokenException extends Text_Parser_Exception
{
    public function __construct($token, $state)
    {
    }
}
?>
