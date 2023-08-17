<?php

namespace App\Exports;

use App\Models\Species;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class SpeciesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Species::select( 
            'name',
            'kingdom',
            'phylum',
            'shell_class',
            'order',
            'family',
            'genus',
            'species',
            'common_name',
            'local_name',
            'country',
            'environment',
            'general_description',
            'iucn_status',
            'threats_to_humans',
            'economic_value_uses',
            'references',
            'species_id',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Species Name', 	
            'Kingdom Phylum',
            'Class',	
            'Order',	
            'Family',	
            'Genus',
            'Species',	
            'Common Name',	
            'Local Name',	
            'Country',	
            'Environment',	
            'General Description',	
            'IUCN Status',	
            'Threats to humans',	
            'Economic Value/ Uses',	
            'References',	
            'Class sequence',	
            'Code',	
            // 'UNIQUE/ DUPLICATE',	
            // 'Remarks',																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
        ];
    }
}
