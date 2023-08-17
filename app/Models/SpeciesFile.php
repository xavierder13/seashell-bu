<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeciesFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'species_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function species()
    {   
        return $this->belongsTo('App\Models\Species', 'id','species_id');
        //                 ( <Model>, <id_of_specified_Model>, <id_of_this_model>  )
    }
}
