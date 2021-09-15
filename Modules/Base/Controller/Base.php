<?php
namespace Modules\Base\Controller; 

class Base 
{
    public function render(){
        $template = 'Index.phtml';
        $filepath = explode("index.php",$_SERVER["SCRIPT_FILENAME"])[0];
        require_once($filepath.'Modules/Base/View'.DIRECTORY_SEPARATOR.$template);
    }
}