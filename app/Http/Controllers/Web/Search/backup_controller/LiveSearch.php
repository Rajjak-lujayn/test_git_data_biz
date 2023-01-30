<?php


namespace App\Http\Controllers\Web\Search;

use App\Helpers\Search\PostQueries;
use App\Models\ListingView;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Http\Request;

use App\Helpers\Date;
use App\Http\Controllers\Web\Auth\Traits\VerificationTrait;

use App\Http\Requests\Admin\UserRequest as StoreRequest;
use App\Http\Requests\Admin\UserRequest as UpdateRequest;
use App\Models\Gender;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Str;
use Larapen\Admin\app\Http\Controllers\PanelController;
use DB;

class LiveSearch extends BaseController
{
	public $isIndexSearch = true;
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		view()->share('isIndexSearch', $this->isIndexSearch);

        $industries = DB::table('listing')
                    ->select('Industry')
                    ->groupBy('Industry')
                    ->get();

		view()->share('industries', $industries);
		// Search
		$data = (new PostQueries($this->preSearch))->fetch();
		
		$title = $this->getTitle();
		$this->getBreadcrumb();
		$this->getHtmlTitle();
		
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
// 		print_r($request);
		return view('search.livesearch');
		
	}
	
	public function get_countries(Request $request)
	{
		
	

					$data = [];

					if($request->has('q')){
						$search = $request->q;
						$tags=DB::table('country_master')
								->select("country_id",'country_name')
								->where('country_name','LIKE',"%$search%")
								->groupBy('country_name')
								->get();
								$formatted_tags = [];

								foreach ($tags as $tag) {
									$formatted_tags[] = ['id' => $tag->country_name, 'text' => $tag->country_name];
								}
						
					}
					return response()->json($formatted_tags);

		//view()->share('industries', $industries);

		//print_r($get_q);

	}
	public function get_employeesize(Request $request)
	{
		$data = [];
					if($request->has('q')){
						$search = $request->q;
						$tags=DB::table('employeesize_master')
								->select("emp_id",'employeesize')
								->where('employeesize','LIKE',"%$search%")
								->groupBy('employeesize')
								->get();
								$formatted_tags = [];

								foreach ($tags as $tag) {
									$formatted_tags[] = ['id' => $tag->employeesize, 'text' => $tag->employeesize];
								}
						
					}
					return response()->json($formatted_tags);

		//view()->share('industries', $industries);

		//print_r($get_q);

	}
	public function get_industries(Request $request)
	{
		$data = [];
					if($request->has('q')){
						$search = $request->q;
						$tags=DB::table('industries')
								->select("ind_id",'industry_name')
								->where('industry_name','LIKE',"%$search%")
								->groupBy('industry_name')
								->get();
								$formatted_tags = [];

								foreach ($tags as $tag) {
									$formatted_tags[] = ['id' => $tag->industry_name, 'text' => $tag->industry_name];
								}
						
					}
					return response()->json($formatted_tags);

		//view()->share('industries', $industries);

		//print_r($get_q);

	}
	public function getData(Request $request)
	{

		## Read value
		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page
   
		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$order_arr = $request->get('order');
		$search_arr = $request->get('search');
   	
		if(isset($order_arr))
		{
			$columnIndex = $order_arr[0]['column']; // Column index
			$columnName = $columnName_arr[$columnIndex]['data']; // Column name
			$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		}
		$searchValue = $search_arr['value']; // Search value
   
		
		// Fetch records
		$query = DB::table('listing')->whereRaw("1 = 1");
		//$records = ListingView::select('listing.*');
		if(isset($order_arr))
		{
		
			$query->orderBy($columnName,$columnSortOrder);
		}
		//$records->select('listing.*');
		foreach($columnName_arr as $column)
		{
			
			if($column["search"]["value"]!='')
			{

			if( strpos($column["search"]["value"], ",") !== false ) 
			{
				$stringtoSearch=explode(",",$column["search"]["value"]);
				
				if( count($stringtoSearch) == 1)
				{
				   
					for($i=0;$i<count($stringtoSearch);$i++)
					{
						if($i==0)
						{
							// $query->whereRaw(" AND (".$column['data']." LIKE ".$stringtoSearch[$i]."'%'");
							$query->Where($column['data'], 'like', $stringtoSearch[$i].'%');
						
						}
						else
						{	
						// $query->whereRaw(" OR ".$column['data']." LIKE ".$stringtoSearch[$i]."'%')");
				        // 	$query->orWhere($column['data'], 'like', $stringtoSearch[$i].'%');
						}
					}
					
				}
				$feilds = $column['data'];
				if(count($stringtoSearch) > 1){
					    $query->where(function($query) use ($stringtoSearch,$feilds)
                                 {
                                    foreach ($stringtoSearch as $d) {
                                     
                                       $query->orWhere(	$feilds ,'like', $d.'%');
                                }
                         });
				}
				
			}
			else
			{
				$query->Where($column['data'], 'like',$column["search"]["value"].'%');

			}
			}
		}
		$totalRecordswithFilter = $query->count();
		$query->skip($start);
		$query->take($rowperpage);
		$records=$query->get();
   
		// Total records
		$totalRecords = ListingView::select('count(*) as allcount')->count();
		//$totalRecordswithFilter = ListingView::select('count(*) as allcount')->count();

	
		
		//print_r($query->toSql());
		$data_arr = array();
		
		foreach($records as $record){
			$sub_array = array();
			$sub_array = array("id"=> $record->id,
								"FirstName"=>$record->FirstName,
								"LastName"=>$record->LastName,
								"Email"=>$record->Email,
								"CompanyName"=>$record->CompanyName,
								"Title"=>$record->Title,
								"Phone1"=>$record->Phone1,
								"Phone2"=>$record->Phone2,
								"Website"=>$record->Website,
								"EmplyoeeSize"=>$record->EmplyoeeSize,
								"Revenue"=>$record->Revenue,
								"LinkedInPersonal"=>$record->LinkedInPersonal,
								"LinkedInCompany"=>$record->LinkedInCompany,
								"City"=>$record->City,
								"State"=>$record->State,
								"Zip"=>$record->Zip,
								"Country"=>$record->Country,
								"Industry"=>$record->Industry,
								"SubIndustry"=>$record->SubIndustry,
								"SIC"=>$record->SIC,
								"NAICS"=>$record->NAICS,
							);
   
		   $data_arr[] = $sub_array;
		}
   
		$response = array(
		   "draw" => intval($draw),
		   "iTotalRecords" => $totalRecords,
		   "iTotalDisplayRecords" => $totalRecordswithFilter,
		   "aaData" => $data_arr,
		   "row_sql"=>$query->toSql()
		);
   
		echo json_encode($response);
		exit;



	}
}
