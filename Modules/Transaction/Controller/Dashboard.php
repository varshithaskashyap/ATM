<?php
namespace Modules\Transaction\Controller; 

class Dashboard 
{

    public function getReceipt(){
        session_start();
        if (isset($_GET) && isset($_GET["name"])) {
            $helper = new  \Modules\Transaction\Model\Helper();
            $isValidTransaction = $helper->download(($_GET["name"]));
            if($isValidTransaction == true)
            {            
                echo "download completed";
            } 
        }
    }

    public function Balence(){
        session_start();
        $helper = new  \Modules\Transaction\Model\Helper();
        $balence = $helper->getBalence();
        $result['balance'] = $balence;
        $result['name'] = $_SESSION['first_name']." ".$_SESSION['last_name'];
        echo json_encode($result);
    }    

}