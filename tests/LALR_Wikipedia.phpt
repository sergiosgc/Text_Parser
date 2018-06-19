--TEST--
Execute wikipedia example for LR parsers
--FILE--
<?php
require_once(__DIR__ . '/../vendor/autoload.php');
$parser = new \sergiosgc\Text_Parser_LALR_Test();
$parser->setDebugLevel(1);
var_dump($parser->parse());
?>
--EXPECT--
Read token 1(1) state []
Shifting to state 2
Read token +(+) state [2]
Reducing using reduce5 state [2] Result state [4]
Reducing using reduce3 state [4] Result state [3]
Shifting to state 6
Read token 1(1) state [3 6]
Shifting to state 2
Read token () state [3 6 2]
Reducing using reduce5 state [3 6 2] Result state [3 6 8]
Reducing using reduce2 state [3 6 8] Result state [3]
Accepting
object(sergiosgc\Text_Tokenizer_Token)#10 (2) {
  ["_id":protected]=>
  string(1) "E"
  ["_value":protected]=>
  string(0) ""
}
