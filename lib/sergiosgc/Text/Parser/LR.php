<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
namespace sergiosgc;

/**
 * Text_Parser is the base class for parsers. In order to be useful, it must
 * be extended to include proper reduction functions for the grammar, as well as
 * action and goto tables. 
 * 
 * The best bet for creating a Text_Parser subclass is to use a compiler compiler
 * that interprets a grammar description and produces the parser class.
 */
abstract class Text_Parser_LR
{
    /** The tokenizer provides a stream of Tokens (Text_Tokenizer_Token instances)*/
    protected $_tokenizer;
    /* _debugLevel {{{ */
    /** Debug verbosity */
    protected $_debugLevel = 0;
    public function setDebugLevel($val)
    {
        $this->_debugLevel = $val;
    }
    /* }}} */
    /* _stateStack field {{{ */
    protected $_stateStack = array();
    protected function pushState(&$nextState, &$token)
    {
        $this->_stateStack[] = $nextState;
        $this->_stateStack[] = $token;
    }
    protected function getCurrentState()
    {
        if (count($this->_stateStack) == 0) return 0;
        if (count($this->_stateStack) % 2 != 0) throw new Text_Parser_InvalidStateStackException('State stack is invalid (uneven count)');

        return $this->_stateStack[count($this->_stateStack) - 2];
    }
    protected function getTopToken()
    {
        if (count($this->_stateStack) == 0) return null;
        return  $this->_stateStack[count($this->_stateStack) - 1];

    }
    protected function popTokens(&$tokenArray, $count = 1)
    {
        if (count($this->_stateStack) % 2 != 0) throw new Text_Parser_InvalidStateStackException('State stack is invalid (uneven count)');
        if (count($this->_stateStack) < (2 * $count)) 
            throw new Text_Parser_EmptyStackException(sprintf('Unable to pop %d tokens from a stack with %d tokens', $count, count($this->_stateStack) / 2));

        $currentStateIndex = count($this->_stateStack) - 2 * $count - 2;
        $currentState = $currentStateIndex >= 0 ? $this->_stateStack[$currentStateIndex] : 0;
        $currentStateIndex += 2;
        for ($i=0; $i < $count; $i++) 
        {
            $tokenArray[] = $this->_stateStack[$currentStateIndex + 1];
            $currentStateIndex += 2;
        }
        $this->_stateStack = array_slice($this->_stateStack, 0, count($this->_stateStack) - 2 * $count);

        return $currentState;
    }
    protected function stateStackAsString()
    {
        $result = '[';
        $separator = '';
        for ($i=0; $i<count($this->_stateStack); $i+=2) {
            $result .= $separator . $this->_stateStack[$i];
            $separator = ' ';
        }
        $result .= ']';

        return $result;
    }
    /* }}} */
    /* _actionTable field {{{ */
    /**
     * The action table, indexed by the current state and terminal token id. 
     *
     * The action table is a matrix. The first coordinate is the current parser state, an integer. The second coordinate is the current terminal, a token id. 
     * The end of input is represented as an empty string terminal id.
     * Each element is an associative array:
     *  - For an accept action, it contains an element 'action' containing the string 'accept'
     *  - For a shift action, it contains an element 'action' containing the string 'shift' and an element 'nextState' containing the next state (an int)
     *  - For a reduce action, it contains:
     *    - An element 'action' containing the string 'reduce'
     *    - An element 'function' containing the function name that will execute the reduction
     *    - An element 'symbols' which is a numerically indexed array containing the names assigned to the symbols in the grammar rule being 
     *      reduced (non-assigned symbols should contain an empty string
     *    - An element 'rule' containing the human-readable representation of the grammar rule (for debugging purposes)
     *
     * Check Text_Parser_LR_Test for an example actionTable.
     */
    protected $_actionTable = null;
    protected function getAction($state, $nextToken)
    {
        if (!is_array($this->_actionTable)) throw new Text_Parser_InvalidParserException('This parser has not been configured. It has no action table');
        if ($nextToken === false) {
            $nextToken = new Text_Tokenizer_Token('','');
        }
        if (!array_key_exists($state, $this->_actionTable) || !array_key_exists($nextToken->getId(), $this->_actionTable[$state])) throw new Text_Parser_UnexpectedTokenException($nextToken, $state);

        return $this->_actionTable[$state][$nextToken->getId()];
    }
    /* }}} */
    /* _gotoTable field {{{ */
    /** 
     * The goto table, indexed by current parser state and non-terminal
     * 
     * The goto table is a matrix, whose first index is the parser state, an integer, and the second index is the non-terminal token id.
     * Each entry contains the next parser state.
     * 
     * Check Text_Parser_LR_Test for an example gotoTable.
     */
    protected $_gotoTable = null;
    protected function getNextState($state, $nextToken)
    {
        if (!is_array($this->_gotoTable)) throw new Text_Parser_InvalidParserException('This parser has not been configured. It has no goto table');
        if (!array_key_exists($state, $this->_gotoTable) || !array_key_exists($nextToken->getId(), $this->_gotoTable[$state])) throw new Text_Parser_UnexpectedTokenException($nextToken, $state);

        return $this->_gotoTable[$state][$nextToken->getId()];
    }
    /* }}} */
    /* parse {{{ */
    /**
     * Parse the input 
     */
    public function parse()
    {
        $nextToken = $this->_tokenizer->getNextToken();
        if ($this->_debugLevel > 0) printf("Read token %s(%s) state %s\n", $nextToken->getId(), $nextToken->getValue(), $this->stateStackAsString());
        do {
            $action = $this->getAction($this->getCurrentState(), $nextToken);
            switch ($action['action']) 
            {
                case 'accept':
                    if ($this->_debugLevel > 0) printf("Accepting\n");
                    return $this->getTopToken();
                    break;
                case 'shift':
                    if ($this->_debugLevel > 0) printf("Shifting to state %d\n", $action['nextState']);
                    $this->pushState($action['nextState'], $nextToken);
                    $nextToken = $this->_tokenizer->getNextToken();
                    if ($this->_debugLevel > 0) printf("Read token %s(%s) state %s\n", $nextToken ? $nextToken->getId() : '$', $nextToken ? $nextToken->getValue() : '$', $this->stateStackAsString());
                    break;
                case 'reduce':
                    if ($this->_debugLevel > 0) printf("Reducing using %s state %s\n", $action['function'], $this->stateStackAsString());
                    $values = array();
                    $nextState = $this->popTokens($values, count($action['symbols']));
                    $symbols = array();
                    foreach ($action['symbols'] as $idx => $symbol) {
                        if ($symbol != '') $symbols[$symbol] =& $values[$idx];
                    }
                    $token = call_user_func_array(array($this, $action['function']), $symbols);
                    if (!is_object($token) || !method_exists($token, 'getId') || !method_exists($token, 'getValue')) {
                        $token = new Text_Tokenizer_Token($action['leftNonTerminal'], $token);
                    }
                    $nextState = $this->getNextState($nextState, $token);
                    if ($this->_debugLevel > 0) printf("Pushing state %d ", $nextState);
                    $this->pushState($nextState, $token);
                    if ($this->_debugLevel > 0) printf("Result state %s\n", $this->stateStackAsString());
                    break;
            }
        } while (true); // Exit happens through an accept action
    }
    /* }}} */
    /* Constructor {{{ */
    public function __construct(&$tokenizer)
    {
        $this->_tokenizer = $tokenizer;
    }
    /* }}} */
}

?>
