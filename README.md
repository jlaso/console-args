[![Latest Stable Version](https://poser.pugx.org/jlaso/console-args/v/stable.svg)](https://packagist.org/packages/jlaso/console-args) [![Total Downloads](https://poser.pugx.org/jlaso/console-args/downloads.svg)](https://packagist.org/packages/jlaso/console-args) [![Latest Unstable Version](https://poser.pugx.org/jlaso/console-args/v/unstable.svg)](https://packagist.org/packages/jlaso/console-args) [![License](https://poser.pugx.org/jlaso/console-args/license.svg)](https://packagist.org/packages/jlaso/console-args)

console-args
=====================

This is an wrapper for the argv global

The difference between arguments and options are:
* arguments are strings like ```--help```
* options are strings like ```--file=filename```
* other arguments without ```--``` are not recognized because the magic of this wrapper is that doesn't matter the order of the arguments/options

Version
----

1.0.0


Installation
--------------

Add the module by composer.json, adding in require clause:
```
{
    "jlaso/console-args": "1.0.0"
}
```

Sample of use
-------------

```
$consoleArgs = new ConsoleArgs($argv, array('help'), array('arg1', 'arg2'));

if($consoleArgs->hasHelp){
    print <<<EOD
        Please, use this arguments to invoke this command:

             --help       \tto see this help
             --arg1=filename \tthe first argument
             --arg2=filename\toptional, the second argument
EOD;
   exit();
}
$arg1 = $consoleArgs->getArg1;
$arg2 = $consoleArgs->getArg2;
```

License
----

MIT



