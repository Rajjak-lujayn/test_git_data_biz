<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Services\PayUService\Exception;

use App\Mail\PlansPurchase;

class EmailSent extends BaseController
{
    public function sent($customerDetails){

        // dd($data['customer_id']);

        // $customerId = $data['customer_id'];

        if($customerDetails['customer_email']){
            \Mail::to($customerDetails['customer_email'])->send(new \App\Mail\PlansPurchase($customerDetails));
        }
                
        return;

        // return 'Email sent Successfully';
        // dd($req);
    }

    public function sentAdmin($customerDetails){

        \Mail::to(getenv('ADMIN_EMAIL'))->send(new \App\Mail\PlansPurchase($customerDetails));
        
        return;
    }
}
