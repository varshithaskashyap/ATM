<?php
namespace Modules\Transaction; 

class Index 
{
    public function router($request,$rootpath) {
        $dashboardController = new Controller\Dashboard();
        switch ($request)
        {      
            case "$rootpath/transaction/submit/dashboard":
                $dashboardController = new Controller\Submit\Dashboard();
                break;

            case "$rootpath/transaction/download?name=statement":
            case "$rootpath/transaction/download?name=receipt":
                    $dashboardController->getReceipt();
                    break;

            case "$rootpath/transaction/getbalence":
                $dashboardController->Balence();
                break;
        }
    }
}