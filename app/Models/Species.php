<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    protected $fillable = ['species_id', 'name', 'kingdom', 'phylum', 'shell_class', 'order', 'family', 'genus', 'species', 'common_name',
                           'local_name', 'country', 'environment', 'general_description', 'iucn_status', 'threats_to_humans',
                            'economic_values_uses', 'references'];

    public function species_files()
    {   
        return $this->hasMany('App\Models\SpeciesFile', 'species_id', 'id');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model> )
    }
}
