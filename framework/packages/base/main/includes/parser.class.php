<?php
    class base_main_parser{
        public function __construct(){
        }
        
        public function parse_file($filename){
            //for now just return the file
            return file_get_contents($filename);
        }
    }
