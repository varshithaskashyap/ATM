<?php
namespace  Modules\Accounts\Controller\Submit;
class Accounts
{
    public function login()
    {
        $helper = new  \Modules\Accounts\Model\Helper();
        if (isset($_POST) && isset($_POST["acc-number"]) && isset($_POST["pin"])){
            $isValiduser = $helper->verifyUser(($_POST["acc-number"]) , ($_POST["pin"]));
            if ($isValiduser == true){
                echo "true";
            } else {                
                echo "Invalid Account Number or Password";
            }
        }else{
            $dashboardController = new \Modules\Base\Controller\Auth();
            if(isset($_SESSION['acc_number'])){
                echo "true";
            }else{
               echo "Enter Account Number or Password";
            }

        }
    }

    public function changepin(){
        session_start();
        $helper = new  \Modules\Accounts\Model\Helper();        
        if (isset($_POST) &&  isset($_POST["new-password"]) && isset($_POST["new-password"])){
            if($_POST['new-password'] != $_POST['new-repassword']){
                echo "pin does not match";
                return;
            }
           $isSavedPassword = $helper->changepassword(($_POST["new-password"]));
           if($isSavedPassword)
           {
                echo "true";
           }            
        } else {
            echo "enter pin";
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        echo "true";
    }
}

