<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
namespace sergiosgc;

class Text_Parser_UnexpectedTokenException extends Text_Parser_Exception
{
    public function __construct($token, $state)
    {
        parent::__construct(sprintf("Unexpected token %s(%s) on state %d", (string) $token->getId(), (string) $token->getValue(), $state));
        $this->token = $token;
        $this->state = $state;
    }
}
?>
