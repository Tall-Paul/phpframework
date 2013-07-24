<?php
class base_main_framework{
    private $dev_mode = false;    
    
    public function __construct($root_path,$router_class = "base_main_router",$parser_class = "base_main_parser"){
        $this->root_path = $root_path;
        $this->packages_path = $this->root_path."/packages";
        $this->templates_path = realpath($this->root_path."/../templates");
        if (!empty($_GET['dev_mode'])){
            $this->dev_mode = true;            
        }
        $this->router = new $router_class;       
        $this->parser = new $parser_class;
    }
    
    public function set_dev_mode($dev_mode){
        $this->dev_mode = $dev_mode;
    }        
    
    public function get_handler($url,$showme=false){
        $handler_name = $this->router->get_handler_name($url);
        if ($showme)
            return $handler_name;
        else{
            if ($handler_name) 
                return new $handler_name();
            else
                return false;
        }
    }
    
    public function handle($url){
        if ($handler = $this->get_handler($url)){
            $handler->handle();
            return true;
        }
        else
            return false;
    }
    
    public function get_static_file($url){     
        if ($this->dev_mode && file_exists($this->templates_path."/dev".$url)){
            return $this->templates_path."/dev".$url;
        }
        if (file_exists($this->templates_path."/live".$url)){                     
            return $this->templates_path."/live".$url;
        }
        return false;
    }
    
    public function display_static_file($url){
        if ($static = $this->get_static_file($url)){
            echo $this->parser->parse_file($static);
            return true; 
        } else {
            return false;
        }
        
    }
    
    public function parse_current_url($component = -1){
        return parse_url("http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],$component);        
    }
    
}