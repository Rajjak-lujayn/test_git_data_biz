<?php


namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\User;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;

class OrderController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Order');
	//	$this->xPanel->with(['paymentMethod']);
		$this->xPanel->setRoute(admin_uri('orders'));
		$this->xPanel->setEntityNameStrings('Orders', 'Orders');
		$this->xPanel->denyAccess(['create', 'update', 'delete']);
		$this->xPanel->removeAllButtons(); // Remove also: 'create' & 'reorder' buttons
		if (!request()->input('order')) {
			$this->xPanel->orderBy('created_at', 'DESC');
		}
		
		// Filters
		// -----------------------
		$this->xPanel->disableSearchBar();
		// -----------------------
	/*	$this->xPanel->addFilter([
			'name'  => 'id',
			'type'  => 'text',
			'label' => 'ID',
		],
		false,
		function ($value) {
			$this->xPanel->addClause('where', 'id', '=', $value);
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'from_to',
			'type'  => 'date_range',
			'label' => trans('admin.Date range'),
		],
		false,
		function ($value) {
			$dates = json_decode($value);
			$this->xPanel->addClause('where', 'created_at', '>=', $dates->from);
			$this->xPanel->addClause('where', 'created_at', '<=', $dates->to);
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'        => 'country',
			'type'        => 'select2',
			'label'       => mb_ucfirst(trans('admin.country')),
			'placeholder' => trans('admin.select'),
		],
		getCountries(),
		function ($value) {
			$this->xPanel->addClause('whereHas', 'post', function($query) use ($value) {
				$query->where('country_code', '=', $value);
			});
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'post_id',
			'type'  => 'text',
			'label' => trans('admin.Ad'),
		],
		false,
		function ($value) {
			if (is_numeric($value)) {
				$this->xPanel->addClause('where', 'post_id', '=', $value);
			} else {
				$this->xPanel->addClause('whereHas', 'post', function ($query) use ($value) {
					$query->where('title', 'LIKE', $value . '%');
				});
			}
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'package',
			'type'  => 'dropdown',
			'label' => trans('admin.Package'),
		],
		$this->getPackages(),
		function ($value) {
			$this->xPanel->addClause('where', 'package_id', '=', $value);
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'payment_method',
			'type'  => 'dropdown',
			'label' => trans('admin.Payment Method'),
		],
		$this->getPaymentMethods(),
		function ($value) {
			$this->xPanel->addClause('where', 'payment_method_id', '=', $value);
		});
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'status',
			'type'  => 'dropdown',
			'label' => trans('admin.Status'),
		], [
			1 => trans('admin.Unapproved'),
			2 => trans('admin.Approved'),
		], function ($value) {
			if ($value == 1) {
				$this->xPanel->addClause('where', function ($query) {
					$query->where(function ($query) {
						$query->where('active', '!=', 1)->orWhereNull('active');
					});
				});
			}
			if ($value == 2) {
				$this->xPanel->addClause('where', 'active', '=', 1);
			}
		});
		
		*/
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'order_id',
			'label' => "ID",
		]);
		$this->xPanel->addColumn([
			'name'  => 'created_at',
			'label' => trans('admin.Date'),
		]);
		$this->xPanel->addColumn([
			'name'          => 'customer_id',
			'label'         => "Customer Name",
			'type'          => 'model_function',
			'function_name' => 'getCustomerNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'pacakge_id',
			'label'         => trans('admin.Package'),
			'type'          => 'model_function',
			'function_name' => 'getPackageNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'customer_payment_method_id',
			'label'         => trans('admin.Payment Method'),
			'type'          => 'model_function',
			'function_name' => 'getPaymentMethodNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'order_status',
			'label'         =>"Status",
			//'type'          => 'model_function',
			//'function_name' => 'getActiveHtml',
		]); 
		
		// FIELDS
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
	
	public function getPackages()
	{
		$entries = Package::where('price', '>', 0)->orderBy('currency_code', 'asc')->orderBy('lft', 'asc')->get();
		
		$arr = [];
		if ($entries->count() > 0) {
			foreach ($entries as $entry) {
				$arr[$entry->id] = $entry->name . ' (' . $entry->price . ' ' . $entry->currency_code . ')';
			}
		}
		
		return $arr;
	}
	
	public function getPaymentMethods()
	{
		$entries = PaymentMethod::orderBy('lft', 'asc')->get();
		
		$arr = [];
		if ($entries->count() > 0) {
			foreach ($entries as $entry) {
				$arr[$entry->id] = $entry->display_name;
			}
		}
		
		return $arr;
	}
}
