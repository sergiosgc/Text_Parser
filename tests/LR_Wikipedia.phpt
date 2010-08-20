--TEST--
Execute wikipedia example for LR parsers
--FILE--
<?php
ini_set('include_path', realpath(dirname(__FILE__) . '/../') . ':' .
                        realpath(dirname(__FILE__) . '/../../Text_Tokenizer/') . ':' .
                        ini_get('include_path'));
require_once('Text/Parser/LR/Test.php');
$parser = new Text_Parser_LR_Test();
$parser->setDebugLevel(1);
var_dump($parser->parse());
?>
--EXPECT--
Read token 1(1) state []
Shifting to state 2
Read token +(+) state [2]
Reducing using reduce5 state [2]
Pushing state 4 Result state [4]
Reducing using reduce3 state [4]
Pushing state 3 Result state [3]
Shifting to state 6
Read token 1(1) state [3 6]
Shifting to state 2
Read token () state [3 6 2]
Reducing using reduce5 state [3 6 2]
Pushing state 8 Result state [3 6 8]
Reducing using reduce2 state [3 6 8]
Pushing state 3 Result state [3]
Accepting
object(Text_Tokenizer_Token)#8 (2) {
  ["_id":protected]=>
  string(1) "E"
  ["_value":protected]=>
  string(1) "E"
}