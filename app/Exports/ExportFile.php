<?php
/*
namespace App\Exports;

use App\Models\Listing_file_name;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;



class ExportFile implements FromCollection
{
    
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        
        $download = DB::table('listing')->where('file_id', $this->id)->get();
        return $download;
    }
}
*/
?>