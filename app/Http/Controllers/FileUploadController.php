<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FileUploadController extends Controller
{
    public function ImportCsv(Request $request)
    {
        $filename = "test_data3.csv";
        $csv = array_map('str_getcsv', file(public_path($filename)));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

         //dd($csv[13]);
        foreach($csv as $vals){
            $utfEncodedArray = array_map("utf8_encode", $vals );
            Species::create($utfEncodedArray);
        }

        return ['message' => 'success'];
    }

    public function ImportExcel()
    {
        $filename = "shellsinformation.xlsx";
        $spreadsheet = IOFactory::load(public_path($filename));
        $sheet        = $spreadsheet->getActiveSheet();
        $row_limit    = $sheet->getHighestDataRow();
        // $column_limit = $sheet->getHighestDataColumn();
        $row_range    = range( 2, $row_limit );
        // $column_range = range( 'F', $column_limit );
        $startcount = 2;

        $data = [];
        foreach ( $row_range as $row ) {
            $data[] = [
                'species_id' =>$sheet->getCell( 'R' . $row )->getValue(),
                'name' => $sheet->getCell( 'A' . $row )->getValue(),
                'kingdom' => $sheet->getCell( 'B' . $row )->getValue(),
                'phylum' => $sheet->getCell( 'C' . $row )->getValue(),
                'shell_class' => $sheet->getCell( 'D' . $row )->getValue(),
                'order' => $sheet->getCell( 'E' . $row )->getValue(),
                'family' =>$sheet->getCell( 'F' . $row )->getValue(),
                'genus' =>$sheet->getCell( 'G' . $row )->getValue(),
                'species' =>$sheet->getCell( 'H' . $row )->getValue(),
                'common_name' =>$sheet->getCell( 'I' . $row )->getValue(),
                'local_name' =>$sheet->getCell( 'J' . $row )->getValue(),
                'country' =>$sheet->getCell( 'K' . $row )->getValue(),
                'environment' =>$sheet->getCell( 'L' . $row )->getValue(),
                'general_description' =>$sheet->getCell( 'M' . $row )->getValue(),
                'iucn_status' =>$sheet->getCell( 'N' . $row )->getValue(),
                'threats_to_humans' =>$sheet->getCell( 'O' . $row )->getValue(),
                'economic_value_uses' =>$sheet->getCell( 'P' . $row )->getValue(),
                'references' =>$sheet->getCell( 'Q' . $row )->getValue(),
                // 'type' =>$sheet->getCell( 'T' . $row )->getValue(),
                // 'remarks' =>$sheet->getCell( 'U' . $row )->getValue(),
            ];
            $startcount++;
        }

        foreach($data as $vals){
            Species::create($vals);
        }

        return ['message' =>'success'];

    }

}
