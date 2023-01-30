<?php

namespace App\Http\Controllers\Web\Search;

use App\Helpers\Search\PostQueries;
use App\Models\ListingView;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Date;
use App\Http\Controllers\Web\Auth\Traits\VerificationTrait;
use App\Http\Requests\Admin\UserRequest as StoreRequest;
use App\Http\Requests\Admin\UserRequest as UpdateRequest;
use App\Models\Gender;
use App\Models\SavedPost;
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

		$revenue = DB::table('revenue_master')
			->select('revenue')
			->get();

		view()->share('revenue', $revenue);

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

	//get all the countries values list in search
	public function get_countries(Request $request)
	{


		$data = [];

		if ($request->has('q')) {
			$search = $request->q;

			$countries =	DB::table('countrymaster')
				->select("Country", 'Country_Name')
				->where('Country_Name', 'LIKE', "$search%")
				->get();
			$formatted_tags = [];

			foreach ($countries as $tag) {
				//$cname=json_decode($tag->name);
				$formatted_tags[] = ['id' => $tag->Country, 'text' => $tag->Country_Name];
			}
		}
		return response()->json($formatted_tags);

		//view()->share('industries', $industries);

		//print_r($get_q);

	}
	//get all the employeesize values list in search
	public function get_employeesize(Request $request)
	{
		$data = [];
		if ($request->has('q')) {
			$search = $request->q;
			$tags = DB::table('employeesize_master')
				->select("emp_id", 'employeesize')
				->where('employeesize', 'LIKE', "%$search%")
				->groupBy('employeesize')
				->get();
			$formatted_tags = [];

			foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->employeesize, 'text' => $tag->employeesize];
			}
		}
		return response()->json($formatted_tags);
	}
	//get all the industries values list in search
	public function get_industries(Request $request)
	{
		$data = [];
		if ($request->has('q')) {
			$search = $request->q;
			$tags = DB::table('listing')
				->select("id", 'Industry')
				->where('Industry', 'LIKE', "%$search%")
				->groupBy('Industry')
				->get();
			$formatted_tags = [];

			foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->Industry, 'text' => $tag->Industry];
			}
		}
		return response()->json($formatted_tags);

		//view()->share('industries', $industries);

		//print_r($get_q);

	}

	// changes by rajjak 12 and 13 for get all the title list

	public function get_title(Request $request)
	{
		$data = [];
		if ($request->has('q')) {
			$search = $request->q;

			$tags = DB::table('listing')
				->select("id", 'Title')
				->where('Title', 'LIKE', "$search%")
				// ->orderBy('Title', 'desc')
				->groupBy('Title')->limit(50)
				->get();

			$formatted_tags = [];
			foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->Title, 'text' => $tag->Title];
			}
		}
		return response()->json($formatted_tags);
		
	}
		// get all the company  list in search
	public function get_company(Request $request)
	{
		$data = [];
		if ($request->has('q')) {
			$search = $request->q;

			$tags = DB::table('listing')
				->select("id", 'CompanyName')
				->where('CompanyName', 'LIKE', "$search%")
				->groupBy('CompanyName')->limit(50)
				->get();

			$formatted_tags = [];
			foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->CompanyName, 'text' => $tag->CompanyName];
			}
		}
		return response()->json($formatted_tags);

	}
	//get all the website values list in search
	public function get_website(Request $request)
	{
		$data = [];
		if ($request->has('q')) {
			$search = $request->q;

			$tags = DB::table('listing')
				->select("id", 'Website')
				->where('Website', 'LIKE', "$search%")
				->groupBy('Website')->limit(50)
				->get();

			$formatted_tags = [];
			foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->Website, 'text' => $tag->Website];
			}
		}
		return response()->json($formatted_tags);

	}
	//end

	public function checkArr($x, $array)
	{
		$arr = array_values($array);
		$arrlength = count($arr);
		$z = strtolower($x);

		for ($i = 0; $i < $arrlength; $i++) {
			if ($z == strtolower($arr[$i])) {
				return true;
			}
		}
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

		if (isset($order_arr)) {
			$columnIndex = $order_arr[0]['column']; // Column index
			$columnName = $columnName_arr[$columnIndex]['data']; // Column name
			$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		}
		$searchValue = $search_arr['value']; // Search value


		// Fetch records
		$query = DB::table('listing')->whereRaw("1");
		//$records = ListingView::select('listing.*');
		if (isset($order_arr)) {

			$query->orderBy($columnName, $columnSortOrder);
		}
		//$records->select('listing.*');
		foreach ($columnName_arr as $column) {
			//echo $column['data']."=".$column["search"]["value"]."<br/>";
			if ($column["search"]["value"] != '' && $column["search"]["value"] != 'null'  && !is_null($column["search"]["value"])) {
				
				if (strpos($column["search"]["value"], ",") !== false) {
					$stringtoSearch = explode(",", $column["search"]["value"]);
				

					
					if (count($stringtoSearch) == 1) {

						for ($i = 0; $i < count($stringtoSearch); $i++) {
							if ($i == 0) {
								// $query->whereRaw(" AND (".$column['data']." LIKE ".$stringtoSearch[$i]."'%'");
								$query->Where($column['data'], 'like', $stringtoSearch[$i] . '%');
							} else {
								// $query->whereRaw(" OR ".$column['data']." LIKE ".$stringtoSearch[$i]."'%')");
								// 	$query->orWhere($column['data'], 'like', $stringtoSearch[$i].'%');
							}
						}
					}
					$feilds = $column['data'];
					if (count($stringtoSearch) > 1) {
						$query->where(function ($query) use ($stringtoSearch, $feilds) {
							foreach ($stringtoSearch as $d) {
								// changes by rajjak for get 1000M+ values in revenue search list
								if($d != 1000000001){
								$query->orWhere($feilds, 'like', $d . '%');
								}
								// changes by rajjak for multiple select values in revenue also get between data search values
								$xplode = explode("-", $d);
								$val=$xplode[0];
								if(isset($xplode[1])){
									$val1=$xplode[1];
									
									$query->orWhere('Revenue', '>=' ,(int) $val )
										->Where('Revenue', '<' ,(int)$val1 );
								}else{
									$query->orWhere('Revenue', '>' ,(int) $val );
								}
								// end
								/*if($d == 1000000001){
									$query->orWhere($feilds, '>', 1000000001);
								}
								//end
								// changes by amir/rajjak
								if($feilds == 'Revenue'){
									
									$query = $this->filterRevenueValue($d,$query);
								}*/
								
								//end
							}
						});
					}
					// changes by rajjak jan 23, 2023 for filter CompanyHeadquarter
					if($column['data'] == 'CompanyHeadquarter'){
						$query->Where($column['data'], 'like', $column["search"]["value"] . '%');
					}	
					// end
					
					
					// changes by rajjak jan 23, 2023 for multiple filter Title, website and company
					if($column['data'] == 'Title' || $column['data'] == 'WebSite' || $column['data'] == 'CompanyName'){
						if($column['data'] == 'CompanyName'){
							foreach(array_filter($stringtoSearch) as $key => $complany){
								if($complany){

									$stringtoSearch[$key] = str_replace("@",",",$complany);
								}
							}
						}
						else{
							$stringtoSearch = $stringtoSearch;
						}
						$query->WhereIn($column['data'], array_filter($stringtoSearch));
					}	
					// end
					
					// changes by rajjak jan 23, 2023 for Industry multiple
					if($column['data'] == 'Industry'){
						$query->Where($column['data'], 'like', $column["search"]["value"] . '%');
					}
					// end
				} else {
					if ($column['data'] == 'Title') {


						$default_terms[] = array("CEO", "Chief Executive Officer", "Chief Executive", "Executive Officer");
						$default_terms[] = array("CFO", "Chief Financial Officer", "Chief Finance Officer", "Finance Officer", "Financial Officer");
						$default_terms[] = array("COO", "Chief Operating Officer", "Chief Operations Officer", "Operations Officer");
						$default_terms[] = array("CMO", "Chief Marketing Officer", "Marketing Officer");
						$default_terms[] = array("CIO", "Chief Information Officer", "Information Officer");
						$default_terms[] = array("CHRO", "Chief Human Resources Officer", "Human Resources Officer");
						$default_terms[] = array("GC", "General Counsel");
						$default_terms[] = array("CDO", "Chief Data Officer", "Data Officer");
						$default_terms[] = array("CTO", "Chief Technologies Officer", "Chief Talent Officer", 'Chief Technical Officer');
						$default_terms[] = array("CPO", "Chief Product Officer");
						$default_terms[] = array("CAO", "Chief Analytics Officer");
						$default_terms[] = array("CDO", "Chief Design Officer");
						$default_terms[] = array("CXO", "Chief Experience Officer");
						$default_terms[] = array("CSO", "Chief Sustainability Officer");
						$default_terms[] = array("CCO", "Chief Complaince Officer");
						$default_terms[] = array("CPO", "Chief Operations Officer");
						$default_terms[] = array("CRO", "Chief Revenue Officer");
						$default_terms[] = array("CISO", "Chief Information Security Officer", "Information Security Officer");
						$default_terms[] = array("CLO", "Chief Legal Officer");
						$default_terms[] = array("CRO", "Chief Risk Officer");
						$default_terms[] = array("CAO", "Chief Accounting Officer");
						$default_terms[] = array("CAO", "Chief Administrative Officer");
						$default_terms[] = array("CSO", "Chief Sales Officer");
						$default_terms[] = array("CCO", "Chief Compliance Officer");
						$default_terms[] = array("CKO", "Chief Knowledge Officer");
						$default_terms[] = array("CCO", "Chief Communications Officer");
						$default_terms[] = array("CPO", "Chief Procurement Officer");
						$default_terms[] = array("CIO", "Chief Investment Officer");
						$default_terms[] = array("CSO", "Chief Strategy Officer");
						$default_terms[] = array("CBO", "Chief Business Officer");
						$default_terms[] = array("CMO", "Chief Medical Officer");
						$default_terms[] = array("CIO", "Chief Investment Officer");
						$default_terms[] = array("VP", "Vice President", "AVP ", "EVP ", "SVP ", "Assistant Vice President", "Senior Vice President", "Executive Vice President Founder ", "Co- Founder", "President");
						$default_terms[] = array("Owner", "Co- Owner");
						$default_terms[] = array("Managing Director", "MD");

						//print_r($default_terms);
						$search_dt_terms = array();
						$searched_term = $column["search"]["value"];
						foreach ($default_terms as $default_term) {
							if ($this->checkArr($searched_term, $default_term)) {
								$search_dt_terms = $default_term;
							}
						}
						$title_field = $column['data'];
						if (count($search_dt_terms) > 0) {
							$query->where(function ($query) use ($search_dt_terms, $title_field) {
								foreach ($search_dt_terms as $array_vals) {

									$query->orWhere($title_field, $array_vals );
								}
							});
						} else {
							$query->Where($column['data'], $column["search"]["value"] );
						}
					}
					// changes by rajjak for revenue filter and get between data
					elseif ($column['data'] == 'Revenue') {
						$revenuesearch = $column["search"]["value"];
						$xplode = explode("-", $revenuesearch);
						$val=$xplode[0];
						if(isset($xplode[1])){
							$val1=$xplode[1];
							
							$query->where('Revenue', '>=' ,(int) $val )
								->Where('Revenue', '<' ,(int)$val1 );
						}else{
							$query->where('Revenue', '>' ,(int) $val );
						}
						/*if
						// changes by rajjak jan 19, 2023
						($revenuesearch == 1000000001){
							$query->where('Revenue', '>' ,1000000000 );
							
						} else {
							// end
							$query->where('Revenue',$revenuesearch);
							$query = $this->filterRevenueValue($revenuesearch,$query);
							//  $query->whereBetween(DB::raw('Revenue'), [(int)$rev_array[0], (int)$rev_array[1]]);
						}*/
					}
					else {
						$query->Where($column['data'], 'like', $column["search"]["value"] . '%');
					}
				}
			}
		}
		$totalRecordswithFilter = $query->count();
		$query->skip($start);
		$query->take($rowperpage);
		// DB::enableQueryLog();
		$records = $query->get();
		// dd(DB::getQueryLog());
		// Total records
		$totalRecords = ListingView::select('count(*) as allcount')->count();
		//$totalRecordswithFilter = ListingView::select('count(*) as allcount')->count();



		//print_r($query->toSql());
		$data_arr = array();

		foreach ($records as $record) {
			$sub_array = array();
			$sub_array = array(
				"id" => $record->id,
				"FirstName" => $record->FirstName,
				"LastName" => $record->LastName,
				"Email" => $this->partiallyHideEmail($record->Email),
				"OEmail" => $record->Email,
				"CompanyName" => $record->CompanyName,
				"Title" => $record->Title,
				"Phone1" => $record->Phone1,
				"Phone2" => $record->Phone2,
				"Website" => $record->Website,
				"EmplyoeeSize" => $record->EmplyoeeSize,
				"Revenue" => $record->Revenue,
				"LinkedInPersonal" => $record->LinkedInPersonal,
				"LinkedInCompany" => $record->LinkedInCompany,
				"City" => $record->City,
				"State" => $record->State,
				"Zip" => $record->Zip,
				"Country" => $record->Country,
				"Industry" => $record->Industry,
				"SubIndustry" => $record->SubIndustry,
				"SIC" => $record->SIC,
				"NAICS" => $record->NAICS,
				// changes by rajjak jan 17, 2023 for add field show permission
				"CompanyHeadquarter" => $record->CompanyHeadquarter,
				//end
			);

			$data_arr[] = $sub_array;
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr,
			"row_sql" => $query->toSql()
		);

		echo json_encode($response);
		exit;
	}
	/* changes by amir
	public function filterRevenueValue($value, $query)
	{
		$cases = $this->revenueCase();
		if(isset($cases[$value]) ) // $value == '2500000-5000000'
		{
			foreach($cases[$value] as $case ){
				$query->orWhere('Revenue',$case);
			}
		}		
		return $query;
	}
	function revenueCase(){
		$case =[
			'2500000-5000000' =>[
				'2500000-4000000',
				'2500000-3000000'
			],
			'50000000-100000000' =>[
				'82500000'
			],
		];
		return $case;
	} */

	public function partiallyHideEmail($email)
	{
		// use FILTER_VALIDATE_EMAIL filter to validates an email address
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// split an email by "@"
			list($first, $last) = explode('@', $email);

			// get half the length of the first part
			$firstLen = floor(strlen($first) / 2);

			// partially hide a first part
			$first = str_replace(substr($first, $firstLen), str_repeat('*', strlen($first) - $firstLen), $first);


			// get the starting position of the "."
			$lastIndex = strpos($last, ".");

			// divide last part in two different strings
			$last1 = substr($last, 0, $lastIndex);
			$last2 = substr($last, $lastIndex);

			// get half the length of the "$last1"
			$lastLen  = floor(strlen($last1) / 2);

			// partially hide a string by "*"
			$last1 = str_replace(substr($last1, $lastLen), str_repeat('*', strlen($last1) - $lastLen), $last1);

			// combine all parts together and return partially hide email
			$partiallyHideEmail = $first . '@' . $last1 . '' . $last2;

			return $partiallyHideEmail;
		}
	}

	public function exportCsv(Request $request)
	{
		
		$user = Auth::user();
		
		/* Check User Credits */
		$credit_bal = $this->check_user_credit($user->id);


		/* Track User Downloaded Data  Start Here */
		$data_ids = explode(",", $request->data_ids);
		$saved_dataids = DB::table('saved_posts')
			->select("user_id", 'data_ids')
			->where('user_id', '=', $user->id)
			->first();

		if (isset($saved_dataids->user_id)) {
			$user_data_ids = unserialize($saved_dataids->data_ids);
			$array_check = array_diff($data_ids, $user_data_ids);
			if (count($array_check) > 0 && $credit_bal >= count($array_check)) {
				$new_limit = $user->credit_limit - count($array_check);
				$affected = DB::table('users')
					->where('id', $user->id)
					->update(['credit_limit' => $new_limit]);
				$update_data_ids = array_merge($user_data_ids, $array_check);
				$update_data = DB::table('saved_posts')
					->where('user_id', $user->id)
					->update(
						array(
							'data_ids' => serialize($update_data_ids)
						)
					);
			} else if (count($array_check) == 0) {
			} else {

				echo "0";
				exit;
			}
		} else {
			if ($credit_bal > count($data_ids)) {
				$new_limit = $user->credit_limit - count($data_ids); //cut the points when user export data
				$affected = DB::table('users')
					->where('id', $user->id)
					->update(['credit_limit' => $new_limit]);

				$insert_data = DB::table('saved_posts')->insert(
					array(
						'user_id'   => $user->id,
						'post_id' => '',
						'data_ids' => serialize($data_ids)

					)
				);
			} else {
				echo "0";
				exit;
			}
		}
		
		
		/* Track User Downloaded Data End Here */


		$filename = "listingData.csv";
		$headers = array(
			'Content-Type' => 'text/csv',
			"Content-Disposition" => "attachment; filename=$filename",
			"Pragma"              => "no-cache",
			"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			"Expires"             => "0"
		);
		
		$listing_datas = DB::table('listing')->whereIn('id', explode(",", $request->data_ids))->get();
		$callback = function () use ($filename, $listing_datas) {
			$handle = fopen('php://output', 'w');
			fputcsv($handle, array('FirstName', 'LastName', 'Title', 'CompanyName', 'Email', 'Phone1', 'Phone2', 'Website', 'EmployeeSize', 'Revenue', 'LinkedInPersonal', 'LinkedInCompany', 'Add1', 'Add2', 'City', 'State', 'Zip', 'Country', 'Industry', 'SubIndustry', 'SIC', 'NAICS','PersonLocation', 'CompanyEmployeeCount', 'CompanyFounded', 'CompanyHeadquarter'));
			
			foreach ($listing_datas as $listing_data) {
				$row['FirstName']  = $listing_data->FirstName;
				$row['LastName']    = $listing_data->LastName;
				$row['Title']    = $listing_data->Title;
				$row['CompanyName']  = $listing_data->CompanyName;
				$row['Email']  = $listing_data->Email;
				$row['Phone1']  = $listing_data->Phone1;
				$row['Phone2']  = $listing_data->Phone2;
				$row['Website']  = $listing_data->Website;
				$row['EmployeeSize']  = $listing_data->EmployeeSize;
				$row['Revenue']  = $listing_data->Revenue;
				$row['LinkedInPersonal']  = $listing_data->LinkedInPersonal;
				$row['LinkedInCompany']  = $listing_data->LinkedInCompany;
				$row['Add1']  = $listing_data->Add1;
				$row['Add2']  = $listing_data->Add2;
				$row['City']  = $listing_data->City;
				$row['State']  = $listing_data->State;
				$row['Zip']  = $listing_data->Zip;
				$row['Country']  = $listing_data->Country;
				$row['Industry']  = $listing_data->Industry;
				$row['SubIndustry']  = $listing_data->SubIndustry;
				$row['SIC']  = $listing_data->SIC;
				$row['NAICS']  = $listing_data->NAICS;
				$row['PersonLocation']  = $listing_data->PersonLocation;
				$row['CompanyEmployeeCount']  = $listing_data->CompanyEmployeeCount;
				$row['CompanyFounded']  = $listing_data->CompanyFounded;
				$row['CompanyHeadquarter']  = $listing_data->CompanyHeadquarter;

				fputcsv($handle, array($row['FirstName'], $row['LastName'], $row['Title'], $row['CompanyName'], $row['Email'], $row['Phone1'], $row['Phone2'], $row['Website'], $row['EmployeeSize'], $row['Revenue'], $row['LinkedInPersonal'], $row['LinkedInCompany'], $row['Add1'], $row['Add2'], $row['City'], $row['State'], $row['Zip'], $row['Country'], $row['Industry'], $row['SubIndustry'], $row['SIC'], $row['NAICS'], $row['PersonLocation'], $row['CompanyEmployeeCount'], $row['CompanyFounded'], $row['CompanyHeadquarter']));
			}

			fclose($handle);
		};


		return response()->stream($callback, 200, $headers);
	}

	
	public function check_user_credit($user_id)
	{

		$check_user_credit = DB::table('users')
			->select("credit_limit")
			->where('id', $user_id)
			->first();
		return $check_user_credit->credit_limit;
	}
	public function update_record(Request $request)
	{

		$user = Auth::user();
		/* Check User Credits */
		$credit_bal = $this->check_user_credit($user->id);

		$data_ids = explode(",", $request->data_ids);


		$saved_dataids = DB::table('saved_posts')
			->select("user_id", 'data_ids')
			->where('user_id', '=', $user->id)
			->first();

		if (isset($saved_dataids->user_id)) {
			$user_data_ids = unserialize($saved_dataids->data_ids);
			$array_check = array_diff($data_ids, $user_data_ids);
			if (count($array_check) > 0 && $credit_bal >= count($array_check)) {
				$new_limit = $user->credit_limit - count($array_check);
				$affected = DB::table('users')
					->where('id', $user->id)
					->update(['credit_limit' => $new_limit]);
				$update_data_ids = array_merge($user_data_ids, $array_check);
				$update_data = DB::table('saved_posts')
					->where('user_id', $user->id)
					->update(
						array(
							'data_ids' => serialize($update_data_ids)
						)
					);
				echo $new_limit;
			} else if (count($array_check) == 0) {

				echo $credit_bal;
			} else {

				echo "0";
				exit;
			}
		} else {
			if ($credit_bal > count($data_ids)) {
				$new_limit = $user->credit_limit - count($data_ids);
				$affected = DB::table('users')
					->where('id', $user->id)
					->update(['credit_limit' => $new_limit]);

				$insert_data = DB::table('saved_posts')->insert(
					array(
						'user_id'   => $user->id,
						'post_id' => '',
						'data_ids' => serialize($data_ids)

					)
				);

				echo $new_limit;
			} else {
				echo "0";
				exit;
			}
		}
	}

	// Save Search Query By Akram
	public function saveSearchQuery(Request $request)
	{

		$keyword =  array_values($request->data_for_save)[0];

		$query_string = $request->query_string;

		$query_string = strrchr($query_string, '?');

		// print_r($request->params);

		$params = $request->params;

		// $params = $request->params;

		$user = Auth::user();
		DB::table('saved_search')->insert(
			array(
				'user_id'   => $user->id,
				'country_code' => 'in',
				'keyword'     => $keyword,
				'params' => serialize($params),
				'query' => $query_string,
				'count' => count($request->data_for_save)
			)
		);

		return $request;
	}

	public function getSavedSearchQuery(Request $request)
	{

		$res = DB::table('saved_search')->select()->where('id', $request->saved_query_id)->get();

		$res = json_decode($res, true);

		return unserialize($res[0]['params']);
	}
}