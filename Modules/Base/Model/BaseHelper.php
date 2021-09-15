<?php
namespace  Modules\Base\Model;

class BaseHelper
{

    public function getBills($conn)
    {
        $sql = "SELECT 2000s, 1000s, 500s, 200s, 100s, 50s, 20s, 10s, 5s FROM bills ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        $bills=array();

        foreach($result as $key => $value) {
            if(intval($value)<=0){
                continue;
            }
            $bills[intval(substr($key, 0, -1))] = intval($value);
        }
        return $bills;
    }

    public function updateBills($bills,$conn)
    {
        $lastKey = array_key_last($bills);
        $lastvalue = $bills[$lastKey];
        array_pop($bills);
        $bills[$lastKey."s"]=$lastvalue;
                
        $updateQuery =  sprintf(
			"INSERT INTO bills (%s) VALUES ('%s')",
			implode('s,',array_keys($bills)),
			implode("','",array_values($bills))
        );
        
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt->execute()){
            echo $conn->error;
        }
    }
}
?>