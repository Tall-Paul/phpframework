<?php
    class base_main_stringFunctions {
        static public function  startsWith($haystack, $needle)
        {
            return !strncmp($haystack, $needle, strlen($needle));
        }
        
        static public function endsWith($haystack, $needle)
        {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }
            return (substr($haystack, -$length) === $needle);
        }
        
    }
