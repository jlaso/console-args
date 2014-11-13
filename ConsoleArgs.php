<?php

/**
 * Class ConsoleArgs, a wrapper for the global $argv
 *
 * @author Patrick JL Laso <wld1373@gmail.com>
 * @version 1.0.0
 *
 * The difference between arguments and options are:
 *          arguments are strings like --help
 *          options are strings like --file=filename
 *          other arguments without -- are not recognized because the magic of this wrapper is that doesn't matter the order of the arguments/options
 *
 * Sample of use:
 *         $consoleArgs = new ConsoleArgs($argv, array('help'), array('arg1', 'arg2'));
 *         if($consoleArgs->hasHelp){
 *              print <<<EOD
 *              Please, use this arguments to invoke this command:
 *
 *                  --help       \tto see this help
 *                  --arg1=filename \tthe first argument
 *                  --arg2=filename\toptional, the second argument
 *         EOD;
 *              exit();
 *         }
 *         $arg1 = $consoleArgs->getArg1;
 *         $arg2 = $consoleArgs->getArg2;
 */

namespace JLaso\ConsoleArgs;

class ConsoleArgs
{

    private $args;
    private $options;

    /**
     * @param $args
     * @param array $validArgs a list of valid arguments
     * @param array $validOpts a list of valid options
     */
    function __construct($args, $validArgs = array(), $validOpts = array())
    {
        $this->options = array();
        $this->args = array();

        foreach($validOpts as $option){
            $this->options[$option] = false;
        }
        foreach($validArgs as $arg){
            $this->args[$arg] = null;
        }

        foreach($args as $index=>$arg){

            if($index>0){    // ignore first argument that is the name of the executable file

                if(preg_match("/^--(?<arg>.*)$/", $arg, $matches)){

                    $result = explode("=", $matches['arg']);
                    if(!isset($result[1])){
                        list($key) = $result;
                        if(!array_key_exists($key, $this->args)){
                            die("argument $key not recognized!\n\tUse: ".implode(",", $validArgs));
                        }
                        $this->args[$key] = true;
                    }else{
                        list($key, $value) = $result;
                        if(!array_key_exists($key,$this->options)){
                            die("option $key not recognized!\n\tUse: ".implode(",", $validOpts));
                        }
                        $this->options[$key] = $value;
                    }

                }else{

                    die("argument $arg not recognized");

                }

            }
        }
    }

    /**
     * returns true if the argument passed has been found in the current console arguments
     *
     * @param $arg
     *
     * @return bool
     */
    function isArgument($arg)
    {
        return array_key_exists($arg, $this->args);
    }

    /**
     * returns the value of the argument passed or null if not found
     *
     * @param $arg
     *
     * @return null
     */
    function getArgument($arg)
    {
        return $this->isArgument($arg) ? $this->args[$arg] : null;

    }

    /**
     * returns true if the option passed has been found in the current console arguments
     *
     * @param $option
     *
     * @return bool
     */
    function isOption($option)
    {
        return array_key_exists($option, $this->options);
    }


    /**
     * return the value of the option passed or null if not found
     *
     * @param $option
     *
     * @return null
     */
    function getOption($option)
    {
        return $this->isOption($option) ? $this->options[$option] : null;
    }

    /**
     * magic method that gets options or args
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if(preg_match("/^has(?<option>.*)$/", $name, $matches)){
            return $this->getArgument(lcfirst($matches['option']));
        }
        if(preg_match("/^get(?<argument>.*)$/", $name, $matches)){
            return $this->getOption(lcfirst($matches['argument']));
        }

        return null;
    }

}