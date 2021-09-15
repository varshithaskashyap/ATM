<?php
namespace Modules\Accounts; 
class Index 
{
    public function router($request,$rootpath) {
        $accountsController = new Controller\Submit\Accounts();
        switch ($request)
        {      
            case "$rootpath/":
            case "$rootpath/accounts/login":
                $baseController = new \Modules\Base\Controller\Base();
                $baseController->render();
                break;

            case "$rootpath/accounts/submit/login":
                $accountsController->login();
                break;
            
            case "$rootpath/accounts/submit/changepin":
                $accountsController->changepin();
                break;
            
            case "$rootpath/accounts/logout":   
                $accountsController->logout();
                break;
        }
    }
}