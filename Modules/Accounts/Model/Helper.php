<?php
namespace Modules\Accounts\Model;
class Helper
{
    public function verifyUser($accNo, $psw)
    {
        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper::getInstance();
        $sql = "SELECT * FROM user where acc_number= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $accNo); 
        $stmt->execute();
        $result = $stmt->get_result();
        $content = $result->fetch_assoc();
        $password_encrypted = $content['pin'];
        if (password_verify($psw, $password_encrypted)){
                session_start();
                $_SESSION["acc_number"] = $_POST["acc-number"];
                $_SESSION["first_name"] = $content['first_name'];
                $_SESSION["last_name"] = $content['last_name'];
                return true;
        } else {
            return false;
        }
    }
    
    public function changepassword($newpassword)
    {
        $accNo = $_SESSION['acc_number'];
        $password_encrypted = password_hash($newpassword, PASSWORD_BCRYPT);
        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper::getInstance();
        $sql = "UPDATE user SET pin = ? WHERE acc_number= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $password_encrypted, $accNo);
        if ($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
}
?>