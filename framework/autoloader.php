<?php
    //autoloader
    
  

function autoloader($class_name=null) {
    $dir = realpath(dirname(__FILE__));
    $package_root = $dir."/packages";
    $default_module = "main";
    $default_package = "legacy";
    $parts = explode("_",$class_name);
    //TODO maybe change this so includes / handlers don't overlap?    
    foreach (Array("includes"=>"class","handlers"=>"handler") as $classpath=>$classtype){   
        $include = "{$package_root}/{$parts[0]}/{$parts[1]}/{$classpath}/{$parts[2]}.{$classtype}.php";
        if (file_exists($include)){
          return include_once($include);
        }
    }    
   
}

function legacy_autoloader($class_name=null){
    //everything below here is the legacy autoloader stuff
    $dir = realpath(dirname(__FILE__))."/legacy/xml/include";    
    $specials = Array(
        "Site" => "{$dir}/site.php",
        "Layout" => "{$dir}/layout.php",
    );
    if (isset($specials[$class_name]))
        return include_once($specials[$class_name]);
    $files = Array(
        "{$dir}/../../plugins/{$class_name}.class.php",
        "{$dir}/{$class_name}.class.php",
        "{$dir}/common/{$class_name}.class.php",
        "{$dir}/../../custom_smarty_plugins/{$class_name}.class.php",
        "{$dir}/../../include/{$class_name}.class.php",
        "{$dir}/../../mc-common/include/{$class_name}.class.php",
    );
    foreach ($files as $file) {
        if (file_exists($file))
            return include_once($file);
    }
    //app1 'module' loading
    $class_parts = explode("_",$class_name);
    if ($class_parts[0] == "mod"){      
        $class = "{$dir}/../modules/".$class_parts[1]."/includes/".implode("/",array_slice($class_parts,2)).".class.php";
        if (file_exists($class))
            return include_once($class);
    }
}


spl_autoload_register("autoloader");  
if (defined("LEGACY_ENABLED") && LEGACY_ENABLED == true){
    spl_autoload_register("legacy_autoloader");
}
