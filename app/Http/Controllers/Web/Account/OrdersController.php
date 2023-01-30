<?php


namespace App\Http\Controllers\Web\Account;



use App\Models\Order;
use Illuminate\Http\Request;

use Torann\LaravelMetaTags\Facades\MetaTag;

class OrdersController extends AccountBaseController
{
	private $perPage = 10;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
	}
	
	/**
	 * List Transactions
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
    {
		
        $orders = Order::where('customer_id', auth()->user()->id)->get();
	//	print_r($orders);
	view()->share('pagePath', 'orders');
        return view('account.orders', compact('orders'));
    }
}
