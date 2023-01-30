<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Larapen\Admin\app\Http\Controllers\Controller;
use League\Flysystem\Adapter\Local;
use App\Http\Requests\Admin\CsvImportRequest;
use App\Http\Requests\Admin\Request;
use Illuminate\Support\Facades\Schema;
use App\CsvData;
// change by rajjak
use App\Models\Listing_file_name;
//end

class ImportListController extends Controller
{
	/** 
	 *changes by rajjak
	 *changes for show file data
	*/ 
	public function fileData()
	{
		$listingFileNameData = Listing_file_name::all();
		// return view('admin/listingFileName', compact('listingFileNameData'));
		return view('admin::listingFileData', compact('listingFileNameData'));
	}
	// end

	public function __construct()
	{
		parent::__construct();

		$this->middleware('demo.restriction')->except(['index']);
	}

	public function index()
	{
		return view('admin::import');
	}

	public function parseImport(CsvImportRequest $request)
	{
		$path = $request->file('csv_file')->getRealPath();
		$data = array_map('str_getcsv', file($path));

		/** 
		 * changes by rajjak
		 * changes for show file data name count and current date and time	
		*/ 

			date_default_timezone_set('Asia/Kolkata');

			$listing_file = new Listing_file_name;
			$listing_file->file_name = $request->file('csv_file')->getClientOriginalName();
			$listing_file->count =  count($data) - 1;
			$listing_file->created_at = date("h:i:s");

			$listing_file->save();
		
		// end

		/*$csv_data_file = CsvData::create([
			'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
			'csv_header' => $request->has('header'),
			'csv_data' => json_encode($data)
		]);*/

		if ($data) {
			$header = $data[0];
			if ($header) {
				foreach ($header as $key => $hed) {
					if (!Schema::hasColumn('new_listing',  trim($hed))) {
						DB::statement("ALTER TABLE `lr_new_listing` ADD `$hed` VARCHAR(255) NOT NULL AFTER `id`;");
						DB::statement("ALTER TABLE `lr_listing` ADD `$hed` VARCHAR(255) NOT NULL AFTER `id`;");
					}
				}
			}
		}

		$file = $path;

		/*	$customerArr = $this->csvToArray($file);
		$mydata = [];
		for ($i = 0; $i < count($customerArr); $i++)
		{	
		
			$data= [
				'FirstName' => $customerArr[$i]['first name'],
				'LastName' =>  $customerArr[$i]['last name'],
				'Title' => $customerArr[$i]['title'],
				'CompanyName' => $customerArr[$i]['company name'],
				'Email' => $customerArr[$i]['Email'],
				'Phone1' => $customerArr[$i]['Phone 1'],
				'Phone2' => $customerArr[$i]['Phone 2'],
				'Website' => $customerArr[$i]['Website'],
				'EmplyoeeSize' => $customerArr[$i]['Employee Size'],
				'Revenue' => $customerArr[$i]['Revenue'],
				'LinkedInPersonal' => $customerArr[$i]['Linkedin personal'],
				'LinkedInCompany' => $customerArr[$i]['Linkedin company'],
				'Add1' => $customerArr[$i]['Add 1'],
				'Add2' => $customerArr[$i]['Add 2'],
				'City' => $customerArr[$i]['City'],
				'State' => $customerArr[$i]['State'],
				'Zip' => $customerArr[$i]['Zip'],
				'Country' => $customerArr[$i]['Country'],
				'Industry' => $customerArr[$i]['Industry'],
				'SubIndustry' => $customerArr[$i]['Sub industry'],
				'SIC' => $customerArr[$i]['SIC'],
				'NAICS' => $customerArr[$i]['NAICS'],
	
			];
			print_r($data);
		exit;
			$get_data=DB::table('listing')->where('Email', $customerArr[$i]['Email'])->get();
  	    if($get_data->count() == 0){
			
				DB::table('listing')->insert($data);
			}
			
		}
		*/
		/**  
		 	* changes by rajjak
			*changes for add file id
		*/	

		// $query_1 = "LOAD DATA LOCAL INFILE '".$path."' IGNORE INTO TABLE lr_new_listing FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'  IGNORE 1 LINES";

		$query_1 = "LOAD DATA LOCAL INFILE '" . $path . "' IGNORE INTO TABLE lr_new_listing FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'  IGNORE 1 LINES set file_id='" . $listing_file->id . "'";

		// end

		DB::connection()->getpdo()->exec($query_1);

		return view('admin::import_success');


		//$csv_data = array_slice($data, 0, 2);
		//return view('admin::import_fields', compact('csv_data'));
		//return view('admin::import_fields', compact('csv_data'));
	}

	public function csvToArray($filename = '', $delimiter = ',')
	{
		if (!file_exists($filename) || !is_readable($filename))
			return false;

		$header = null;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== false) {
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
				if (!$header) {
					$header = $row;
				} else {
					$header = array_filter(array_map('trim', $header));
					
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}

		return $data;
	}
	public function processImport(Request $request)
	{

		$data = CsvData::find($request->csv_data_file_id);
		$csv_data = json_decode($data->csv_data, true);
		print_r($request);
		/*foreach ($csv_data as $row) {
			$contact = new Contact();
			foreach (config('app.db_fields') as $index => $field) {
				$contact->$field = $row[$request->fields[$index]];
			}
			$contact->save();
		}

		return view('import_success'); */
	}
}
