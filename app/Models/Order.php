<?php

namespace App\Models;

use App\Helpers\Date;
use App\Helpers\UrlGen;
use App\Models\Scopes\LocalizedScope;
use App\Models\Scopes\StrictActiveScope;
use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Larapen\Admin\app\Models\Traits\Crud;

class Order extends BaseModel
{
	use Crud, HasFactory;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	//protected $appends = ['created_at_formatted'];
	
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	// public $timestamps = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['order_id'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['order_id','customer_id', 'customer_payment_method_id','pacakge_id', 'order_status', 'order_total','created_at'];
	

	public function package()
    {
        return $this->belongsTo(Package::class,'package_id','id');
    }
	public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'customer_payment_method_id','id');
    }
	public function customer_name()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }

	
	public function getPackageNameHtml()
	{
		
		$out = $this->package_id;
		
		if (!empty($this->package)) {
			$packageUrl = admin_url('packages/' . $this->package_id . '/edit');
			
			$out = '';
			$out .= '<a href="' . $packageUrl . '">';
			$out .= $this->package->name;
			$out .= '</a>';
			$out .= ' (' . $this->package->price . ' ' . $this->package->currency_code .'  Credit ' . $this->package->pictures_limit.')';
		}
		
		return $out;
	}

	public function getCustomerNameHtml()
	{
		
		$out ="";
		
		if (!empty($this->customer_name)) {
			
			$out .= $this->customer_name->name;
		}
		
		return $out;
	}
	
	public function getPaymentMethodNameHtml()
	{
		$out = '$this->paymentMethod->name--';
		
		if (!empty($this->payment_method)) {
			$paymentMethodUrl = admin_url('payment_methods/' . $this->customer_payment_method_id . '/edit');
			
			$out = '';
			$out .= '<a href="' . $paymentMethodUrl . '">';
			if ($this->payment_method->name == 'offlinepayment') {
				$out .= trans('offlinepayment::messages.Offline Payment');
			} else {
				$out .= $this->payment_method->display_name;
			}
			$out .= '</a>';
		}
		
		return $out;
	}
	

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
