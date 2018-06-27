# Text_Parser
Driver class for LALR text parsers.

This package contains an abstract LR parser and an abstract LALR parser. These abstract parsers lack the transition tables (an action 
table containing shift and reduce actions and a goto table), as well as reduction functions. The transition tables are 
usually automatically generated from a grammar definition, using 
[Text_Parser_Generator](https://github.com/sergiosgc/Text_Parser_Generator).

You probably have no direct need for this package, and should use 
[Structures_Grammar](https://github.com/sergiosgc/Text_Parser_BNF) or [Text_Parser_BNF](https://github.com/sergiosgc/Text_Parser_BNF)
to define a grammar and 
[Text_Parser_Generator](https://github.com/sergiosgc/Text_Parser_Generator) to generate a parser.
