<?php

interface tts{
    function say($message);
}

class GNUStep implements tts{
    function say($message){
        return shell_exec('say "' . $message . '"');
    }
}

class Festival implements tts{
    function say($message){
        return shell_exec('echo "' . $message . '" | festival --tts');
    }
}