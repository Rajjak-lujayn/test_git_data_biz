<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing_file_name;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportFile;




class listingFileName extends Controller
{
   

    public function fileDelete($id)
    {
        Listing_file_name::find($id)->delete();
        // Listing::where('file_id', $id)->delete();
        DB::table('listing')->where('file_id', $id)->delete();
        DB::table('new_listing')->where('file_id', $id)->delete();
        // dd($test123);
        return redirect()->route('file_data')->with('success', 'Record Deleted Successfully');
    }

    
    public function download($id)
    {
        $Listing_file_name = DB::table('new_listing')->where('file_id', $id)->get()->toArray();

        $header_args = array('FirstName','LastName','Title','CompanyName','Email','Phone1','Phone2','Website','EmplyoeeSize', 'Revenue','LinkedInPersonal','LinkedInCompany','Add1','Add2','City', 'State','Zip','Country','Industry','SubIndustry','SIC','NAICS','PersonLocation','CompanyEmployeeCount','CompanyFounded','CompanyHeadquarter');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_file_listing.csv');
        $output = fopen('php://output', 'w');
        ob_end_clean();
        fputcsv($output, $header_args);

        foreach ($Listing_file_name as $listing_data) {
            $row['FirstName']  = $listing_data->FirstName;
            $row['LastName']    = $listing_data->LastName;
            $row['Title']    = $listing_data->Title;
            $row['CompanyName']  = $listing_data->CompanyName;
            $row['Email']  = $listing_data->Email;
            $row['Phone1']  = $listing_data->Phone1;
            $row['Phone2']  = $listing_data->Phone2;
            $row['Website']  = $listing_data->Website;
            $row['EmplyoeeSize']  = $listing_data->EmplyoeeSize;
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
            fputcsv($output, $row);
        }

        fclose($output);
    }
}
