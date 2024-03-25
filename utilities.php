<?php
    const ANSI_WHITE = "\e[0m";
    const ANSI_RED = "\e[31m";
    const ANSI_GREEN = "\e[32m";
    const ANSI_YELLOW = "\e[33m";
    const ANSI_BLUE = "\e[34m";
    const ANSI_MAGENTA = "\e[35m";
    const ANSI_CYAN = "\e[36m";

    function echoEndl($string){
        echo ANSI_WHITE . "{$string} \n" ;
    }

    function echoError($string){
        echo ANSI_RED . "{$string} \n" ;
    }
    function echoSuccess($string){
        echo ANSI_GREEN . "{$string} \n" ;
    }
    function echoInfo($string){
        echo ANSI_BLUE . "{$string} \n" ;
    }
    function echoSkip($skips){
        for ($i = 0; $i < $skips; $i++){
            echo "\n";
        }
    }