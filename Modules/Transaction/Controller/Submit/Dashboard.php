<?php
namespace  Modules\Transaction\Controller\Submit;

class Dashboard
{
    public function __construct(){
        session_start();
        $helper = new  \Modules\Transaction\Model\Helper();
        if (isset($_POST) && isset($_POST["amount"])) {
            $isValidTransaction = $helper->withdrawAmt(($_POST["amount"]));
            if($isValidTransaction['status'] == true)
            {
                echo json_encode($isValidTransaction);
                $helper->download('receipt');
            }
            else
            {
                echo json_encode($isValidTransaction);
            }
        }

    }
}
