<?php

namespace App\Imports;

use App\Models\Species;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class SpeciesImport implements ToModel
{   

    private $rows = 0;

    use Importable;  


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
  
        if($this->rows > 0)
        {
            return new Species([
                'species_id' => @$row[17],
                'name' => @$row[0],
                'kingdom' => @$row[1],
                'phylum' => @$row[2],
                'shell_class' => @$row[3],
                'order' => @$row[4],
                'family' => @$row[5],
                'genus' => @$row[6],
                'species' => @$row[7],
                'common_name' => @$row[8],
                'local_name' => @$row[9],
                'country' => @$row[10],
                'environment' => @$row[11],
                'general_description' => @$row[12],
                'iucn_status' => @$row[13],
                'threats_to_humans' => @$row[14],
                'economic_value_uses' => @$row[15],
                'references' => @$row[16],
            ]);
        }

        ++$this->rows;
        
    }
}
