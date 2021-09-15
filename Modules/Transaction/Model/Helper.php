<?php
namespace Modules\Transaction\Model;
use Modules\Base\Model\BaseHelper as BaseHelper;

class Helper extends BaseHelper
{

    public function getBalence($name=null)
    {

        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper::getInstance();

        $accNo = $_SESSION['acc_number'];
        $sql = "SELECT * FROM transaction where acc_number= ? ORDER BY created_at DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $accNo); 
        $stmt->execute();
        if ($result = $stmt->get_result())
        {
            if($name == 'statement'){
                $table = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($table,$row);
                }
                return $table;
            }else if($name == 'receipt'){
                $table = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($table,$row);
                    break;
                }
                return $table;

            } else{
                $row = $result->fetch_assoc();
                $balence = $row['current_balence'];
                return $balence;
            }  
        }
    }

    
    public function processBills($output,$conn,$withdrawAmt)
    {
        $message = '';

        $bills = $this->getBills($conn);
        $totalAtmCash = 0;
        $dinominations = array_keys($bills);

        foreach($bills as $k=>$v){
            $totalAtmCash += ($k * $v);
        }

        $payment = $withdrawAmt;

        if($payment <= $totalAtmCash){
            rsort($dinominations);
            $itemsOfEach = array();
        
            foreach ($dinominations as $unit){
                $result = intval($payment / $unit);
                if($bills[$unit] >= $result)
                {
                    $itemsOfEach[$unit] = $result;
                    $payment %= $unit;
                }
                else
                {
                    $itemsOfEach[$unit] = $bills[$unit];
                    $payment -= ($bills[$unit] * $unit);
                }
            }
        
            if($payment > 0)
            {
                $message = "Correct currency note are not available.";
                $output['status'] = false;
                $output['message'] = $message;
                return $output;
            }
            else
            {
                $message .="The ATM Dispensed\n";
                foreach($itemsOfEach as $key=>$value)
                {	
                    $bills[$key] = $bills[$key] - $value; 
                    if($value!=0){
                        $message .= "\n$".$key." bills : ".$value." notes";
                    }
                }
                $totalAtmCash = $totalAtmCash-$withdrawAmt;
            }
        }
        else
        {
            $output['status'] = false;
            $output['message'] = "Not enough currency in ATM.";
            return $output;
        } 

        $this->updateBills($bills,$conn);
        $output['status'] = true;
        $output['message'] = $message;
        return $output;
    }
    
    
    
    public function withdrawAmt($withdrawAmt)
    {   
        $accNo = $_SESSION['acc_number'];
        $output = array();

        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper::getInstance();
        
        $prevBalence = $this->getBalence();
        $withdrawAmt = (int)$withdrawAmt;
        $currentBalence = $prevBalence - $withdrawAmt;

        if($currentBalence<0){
            $output['status'] = false;
            $output['message'] ="Insufficient balence in your account";
            return $output;
        }

        $output = $this->processBills($output,$conn,$withdrawAmt);
        if($output['status'] === false){
            return $output;
        }


        $sql = "INSERT INTO transaction(acc_number,initail_balence,transaction_amt,current_balence,transaction_statement) values (?,?,?,?,'Withdraw')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $accNo,$prevBalence,$withdrawAmt,$currentBalence);

        if ($stmt->execute()===true)
        {            
            return $output;
        }
        else
        {
            $output['status'] = false;
            $output['message'] = 'query didnt execute!Something went wrong';
            return $output;        
        }
    }


    public function download($name)
    {
        $table = $this->getBalence($name);
        $accNo = $_SESSION['acc_number'];
        $accHolderName = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $file = $_SERVER['DOCUMENT_ROOT']  ."/app/downloads/".$name.".txt";
        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, "Account Number = ".$accNo."\n");
        fwrite($txt, "Account Name = ".$accHolderName."\n");
        foreach($table as $row) {
            fwrite($txt,"\n\n\n");
            foreach($row as $key=>$value){
                fwrite($txt,$key. "\t\t". $value ."\n"); 
            }
        }
        fclose($txt);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        readfile($file);
        exit();  
    }


}
?>