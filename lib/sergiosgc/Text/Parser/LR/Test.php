<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
namespace sergiosgc;

/**
 * Text_Parser_Test is a simple parser for the grammar defined in 
 *  http://en.wikipedia.org/wiki/LR_parser
 * used in the test cases for Text_Parser
 */
class Text_Parser_LR_Test extends Text_Parser_LR
{
    /* Constructor {{{ */
    public function __construct()
    {
        require_once('Text/Tokenizer/Token.php');
        parent::__construct($this);
        $this->_gotoTable = array(
         0 => array(
          'E' => 3,
          'B' => 4
         ),
         5 => array(
          'B' => 7
         ),
         6 => array(
          'B' => 8
         )
        );
        $this->_actionTable = array(
         0 => array(
          '0' => array(
           'action' => 'shift',
           'nextState' => 1
          ),
          '1' => array(
           'action' => 'shift',
           'nextState' => 2
          )
         ),
         1 => array(
          '*' => array(
           'action' => 'reduce',
           'function' => 'reduce4',
           'symbols' => array(''),
           'rule' => 'B -> 0'
          ),
          '+' => array(
           'action' => 'reduce',
           'function' => 'reduce4',
           'symbols' => array(''),
           'rule' => 'B -> 0'
          ),
          '0' => array(
           'action' => 'reduce',
           'function' => 'reduce4',
           'symbols' => array(''),
           'rule' => 'B -> 0'
          ),
          '1' => array(
           'action' => 'reduce',
           'function' => 'reduce4',
           'symbols' => array(''),
           'rule' => 'B -> 0'
          ),
          '' => array(
           'action' => 'reduce',
           'function' => 'reduce4',
           'symbols' => array(''),
           'rule' => 'B -> 0'
          )
         ),
         2 => array(
          '*' => array(
           'action' => 'reduce',
           'function' => 'reduce5',
           'symbols' => array(''),
           'rule' => 'B -> 1'
          ),
          '+' => array(
           'action' => 'reduce',
           'function' => 'reduce5',
           'symbols' => array(''),
           'rule' => 'B -> 1'
          ),
          '0' => array(
           'action' => 'reduce',
           'function' => 'reduce5',
           'symbols' => array(''),
           'rule' => 'B -> 1'
          ),
          '1' => array(
           'action' => 'reduce',
           'function' => 'reduce5',
           'symbols' => array(''),
           'rule' => 'B -> 1'
          ),
          '' => array(
           'action' => 'reduce',
           'function' => 'reduce5',
           'symbols' => array(''),
           'rule' => 'B -> 1'
          )
         ),
         3 => array(
          '*' => array(
           'action' => 'shift',
           'nextState' => 5
          ),
          '+' => array(
           'action' => 'shift',
           'nextState' => 6
          ),
          '' => array(
           'action' => 'accept'
          )
         ),
         4 => array(
          '*' => array(
           'action' => 'reduce',
           'function' => 'reduce3',
           'symbols' => array('B'),
           'rule' => 'E -> B'
          ),
          '+' => array(
           'action' => 'reduce',
           'function' => 'reduce3',
           'symbols' => array('B'),
           'rule' => 'E -> B'
          ),
          '0' => array(
           'action' => 'reduce',
           'function' => 'reduce3',
           'symbols' => array('B'),
           'rule' => 'E -> B'
          ),
          '1' => array(
           'action' => 'reduce',
           'function' => 'reduce3',
           'symbols' => array('B'),
           'rule' => 'E -> B'
          ),
          '' => array(
           'action' => 'reduce',
           'function' => 'reduce3',
           'symbols' => array('B'),
           'rule' => 'E -> B'
          )
         ),
         5 => array(
          '0' => array(
           'action' => 'shift',
           'nextState' => 1
          ),
          '1' => array(
           'action' => 'shift',
           'nextState' => 2
          )
         ),
         6 => array(
          '0' => array(
           'action' => 'shift',
           'nextState' => 1
          ),
          '1' => array(
           'action' => 'shift',
           'nextState' => 2
          )
         ),
         7 => array(
          '*' => array(
           'action' => 'reduce',
           'function' => 'reduce1',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E * B'
          ),
          '+' => array(
           'action' => 'reduce',
           'function' => 'reduce1',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E * B'
          ),
          '0' => array(
           'action' => 'reduce',
           'function' => 'reduce1',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E * B'
          ),
          '1' => array(
           'action' => 'reduce',
           'function' => 'reduce1',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E * B'
          ),
          '' => array(
           'action' => 'reduce',
           'function' => 'reduce1',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E * B'
          )
         ),
         8 => array(
          '*' => array(
           'action' => 'reduce',
           'function' => 'reduce2',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E + B'
          ),
          '+' => array(
           'action' => 'reduce',
           'function' => 'reduce2',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E + B'
          ),
          '0' => array(
           'action' => 'reduce',
           'function' => 'reduce2',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E + B'
          ),
          '1' => array(
           'action' => 'reduce',
           'function' => 'reduce2',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E + B'
          ),
          '' => array(
           'action' => 'reduce',
           'function' => 'reduce2',
           'symbols' => array('E', '', 'B'),
           'rule' => 'E -> E + B'
          )
         )
        );
        $this->_tokens = array(
         new Text_Tokenizer_Token('1', '1'),
         new Text_Tokenizer_Token('+', '+'),
         new Text_Tokenizer_Token('1', '1'),
         new Text_Tokenizer_Token('', null),
         );
    }
    /* }}} */
    public function getNextToken()
    {
        $result = current($this->_tokens);
        next($this->_tokens);
        return $result;
    }
    public function reduce1($symbols = null)
    {
        return new Text_Tokenizer_Token('E', 'E');
    }
    public function reduce2($symbols = null)
    {
        return new Text_Tokenizer_Token('E', 'E');
    }
    public function reduce3($symbols = null)
    {
        return new Text_Tokenizer_Token('E', 'E');
    }
    public function reduce4($symbols = null)
    {
        return new Text_Tokenizer_Token('B', 'B');
    }
    public function reduce5($symbols = null)
    {
        return new Text_Tokenizer_Token('B', 'B');
    }
}

?>
