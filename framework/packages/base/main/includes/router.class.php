<?php
    class base_main_router{
        private $routing_table = array();
        
        
        public function __construct(){
        }
        
        public function load($routing_file){
            if (file_exists($routing_file)){
                $data = file_get_contents($routing_file);
                if ($data = json_decode($data,true))
                    $this->routing_table = $data;
            }
            //if (file_exists($routing_file))    
        }
        
        public function save($routing_file){
                $out = json_encode($this->routing_table);
                file_put_contents($routing_file,$out);            
        }
                
        
        public function add($name,$source,$startswith,$endswith,$handler){
            $this->routing_table[] = Array("name"=>$name,"source"=>$source,"startswith"=>$startswith,"endswith"=>$endswith,"handler"=>$handler);
            return count($this->routing_table);
        }
        
        public function remove($route_id){
            
        }
        
        public function get_handler_name($url){
            foreach($this->routing_table as $route){
                if (base_main_stringFunctions::startsWith($url,$route['startswith']) && base_main_stringFunctions::endsWith($url,$route['startswith']))
                    return $route['handler'];                
            }
            return false;
        }
        
        public function debug_routes(){
            echo "<table><tr><th>name</th><th>source</th><th>startswith</th><th>endswith</th><th>handler</th>";
            foreach($this->routing_table as $route){
                echo "<tr><td>{$route['name']}</td><td>{$route['source']}</td><td>{$route['startswith']}</td><td>{$route['endswith']}</td><td>{$route['handler']}</td></tr>";
            }
            echo "</table>";            
        }
                
    }
