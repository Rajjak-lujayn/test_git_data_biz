<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Web\Auth\Traits\VerificationTrait;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Models\PostType;
use App\Models\Category;
use App\Http\Requests\Admin\PostRequest as StoreRequest;
use App\Http\Requests\Admin\PostRequest as UpdateRequest;

class ListsController extends PanelController
{
	use VerificationTrait;
	
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
	
		/* 
			changes by rajjak
			Changes for hide delete and edit button for admin listing and create same functionality in down
			
			$this->xPanel->setModel('App\Models\Listing');
			//$this->xPanel->with(['pictures', 'user', 'city', 'latestPayment' => function ($builder) { $builder->with(['package']); }]);
			$this->xPanel->setRoute(admin_uri('lists'));
			$this->xPanel->setEntityNameStrings('List', 'Listings');
			$this->xPanel->denyAccess(['create','update','delete']);
			$this->xPanel->removeButton('update');
			$this->xPanel->removeButton('delete');
			$this->xPanel->removeAllButtons();

			end 	
		*/

		/**  changes by rajjak

		 	* changes for delete record and show delete button in admin list and update above cases
		*/ 
			$this->xPanel->setModel('App\Models\Listing');
			$this->xPanel->setRoute(admin_uri('lists'));
			$this->xPanel->setEntityNameStrings('List', 'Listings');
			$this->xPanel->denyAccess(['create','update','delete']);
			$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
			$this->xPanel->addButtonFromModelFunction('line', 'delete', 'deleteBtn', 'end');
			$this->xPanel->removeButton('update');
			$this->xPanel->removeButton('delete');
			// $this->xPanel->removeAllButtons();
		
		//end
		
		// Filters
		// -----------------------
		$this->xPanel->enableSearchBar();
		// -----------------------
		$this->xPanel->addFilter([
			'name'  => 'id',
			'type'  => 'text',
			'label' => 'ID',
		],
			false,
			function ($value) {
				$this->xPanel->addClause('where', 'id', '=', $value);
			});

			$this->xPanel->addFilter([
				'name'  => 'title',
				'type'  => 'text',
				'label' => mb_ucfirst('Title'),
			],
				false,
				function ($value) {
					$this->xPanel->addClause('where', 'Title', 'LIKE', "%$value%");
				});

			/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/

		// COLUMNS
		// changes by rajjak for hide list coloumns
		$all_columns=array(
			'',
			// "FirstName",
			// "LastName",
			// "Title",
			// "CompanyName","Email","Phone1","Phone2","Website",
			// "EmplyoeeSize",
			// "Revenue",
			// "LinkedInPersonal",
			// "LinkedInCompany",
			// "City",
			// "State",
			// "Zip",
			// "Country",
			// "Industry",
			// "SubIndustry",
			// "SIC",
			// "NAICS",
			
		);
		// end
		
		// changes by rajjak and add colomns in admin listing

		if (request()->segment(2) != 'account') {
			// COLUMNS
			$this->xPanel->addColumns(array(''));
			$this->xPanel->addColumn([
				'name'  => 'id',
				'label' => '',
				'type'  => 'checkbox',
				'orderable' => false,
			]);

			
			$this->xPanel->addColumn([
				'name'  => 'FirstName',
				'label' => 'FirstName',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'LastName',
				'label' => 'LastName',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Title',
				'label' => 'Title',
			
			]);
		
			$this->xPanel->addColumn([
				'name'  => 'CompanyName',
				'label' => 'CompanyName',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Email',
				'label' => 'Email',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Phone1',
				'label' => 'Phone1',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Website',
				'label' => 'Website',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'EmplyoeeSize',
				'label' => 'EmplyoeeSize',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Revenue',
				'label' => 'Revenue',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'LinkedInPersonal',
				'label' => 'LinkedInPersonal',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'City',
				'label' => 'City',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'State',
				'label' => 'State',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Zip',
				'label' => 'Zip',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Country',
				'label' => 'Country',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'Industry',
				'label' => 'Industry',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'SubIndustry',
				'label' => 'SubIndustry',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'SIC',
				'label' => 'SIC',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'NAICS',
				'label' => 'NAICS',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'PersonLocation',
				'label' => 'PersonLocation',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'CompanyEmployeeCount',
				'label' => 'CompanyEmployeeCount',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'CompanyFounded',
				'label' => 'CompanyFounded',
			
			]);
			$this->xPanel->addColumn([
				'name'  => 'CompanyHeadquarter',
				'label' => 'CompanyHeadquarter',
			
			]);
			
		}
			
		// end
		
		/*$this->xPanel->addColumn([
			'name'          => 'Title',
			'label'         => 'Title',
			//'type'          => 'model_function',
			//'function_name' => 'getTitleHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'FirstName', // Put unused field column
			'label'         => 'First Name',
			//'type'          => 'model_function',
			//'function_name' => 'getPictureHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'LastName',
			'label'         => 'Last Name',
		//	'type'          => 'model_function',
		//	'function_name' => 'getUserNameHtml',
		]);*/
		
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
	
	public function postType()
	{
		$entries = PostType::query()->get();
		
		$entries = collect($entries)->mapWithKeys(function ($item) {
			return [$item['id'] => $item['name']];
		})->toArray();
		
		return $entries;
	}
}
