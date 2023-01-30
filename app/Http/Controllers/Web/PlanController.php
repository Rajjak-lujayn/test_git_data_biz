<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Helpers\UrlGen;
use App\Http\Controllers\Web\Traits\Sluggable\PageBySlug;
use App\Http\Requests\ContactRequest;
use App\Models\User;
use App\Models\Package;
use App\Models\Order;
use App\Models\Payment;
use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Http\Controllers\Web\EmailSent;

use Session;
use Stripe;
use DB;

class PlanController extends FrontController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $data = [];
       

        $cacheId = 'packages.with.currency.' . config('app.locale');
		$packages = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$packages = Package::applyCurrency()->with('currency')->orderBy('lft')->get();
			
			return $packages;
		});
		$data['packages'] = $packages;

        // Save Search
		$savedSearch = SavedSearch::currentCountry()
        ->where('user_id', auth()->user()->id)
        ->orderByDesc('id');
    view()->share('countSavedSearch', $savedSearch->count());
    

        view()->share('pagePath', 'plans');

       // return view('plans.index', compact('data'));
        return appView('plans.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function checkout($plan_id)
    {
        
        $plan = Plan::findOrFail($plan_id);
        view()->share('pagePath', 'plans');
        return view('plans.checkout', compact('plan'));
    }

    public function stripePost(Request $request)
    {

        $user = Auth::user();
        $plan = Plan::findOrFail($request->input('package_id'));
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        try {
            
            $charge=Stripe\Charge::create ([
                "amount" => $plan->price * 100,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Payment From BizB2b Credit Purchase."
            ]);
            
            
            $new_limit=$user->credit_limit+$plan->pictures_limit;
            $credit_upadate = DB::table('users')
            ->where('id', $user->id)
            ->update(['credit_limit' => $new_limit]);

            $insert_data=DB::table('orders')->insert(
                array(
                    'customer_id'   =>$request->input('user_id'),
                    'customer_payment_method_id'=>'2',
                    'package_id'=>$plan->id,
                    'order_status'=>$charge->status,
                    'order_total'=>$plan->price,
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => now()
                    )
                );	
        // Changes By Akram Shekh

        $EmailSent = new EmailSent;
        $packageDetails =  Package::where('id',$plan->id)->first();

        try {

            $EmailSent->sent(array(
                'customer_id'   =>$request->input('user_id'),
                'customer_email' => $user->email,
                'customer_name' => $user->name,
                'package_name' => $packageDetails->name,
                'customer_payment_method_id'=>'2',
                'package_id'=>$plan->id,
                'order_status'=>$charge->status,
                'order_total'=>$plan->price,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => now()
            ));
    
            $EmailSent->sentAdmin(array(
                'isAdmin'   => true,
                'customer_id'   =>$request->input('user_id'),
                'customer_email' => $user->email,
                'customer_name' => $user->name,
                'package_name' => $packageDetails->name,
                'customer_payment_method_id'=>'2',
                'package_id'=>$plan->id,
                'order_status'=>$charge->status,
                'order_total'=>$plan->price,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => now()
            ));
          
        } catch (\Exception $e) {
        
            // return $e->getMessage();
        }


        // Session::flash('success', 'Payment successful!');
        return redirect()->route('orders')->withSuccess('Payment successful!');
       // return back();
    }
    catch (\Exception $e) {
        Session::flash('error', 'Payment is Failed!');
        // return back();
    }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
