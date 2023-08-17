<?php

namespace App\Http\Controllers\API;

use App\Models\Species;
use App\Models\SpeciesFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Imports\SpeciesImport;
use App\Exports\SpeciesExport;
use Validator;
use Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB; 
use Carbon\Carbon;

class SpeciesApiController extends Controller
{

    public function index()
    {
        $species = Species::with('species_files')->get();

        return response()->json(['species' => $species], 200);
    }

    public function save_species($species, $data)
    {   
        $species->species_id = $data['species_id'];
        $species->name = $data['name'];
        $species->kingdom = $data['kingdom'];
        $species->phylum = $data['phylum'];
        $species->shell_class = $data['shell_class'];
        $species->order = $data['order'];
        $species->family = $data['family'];
        $species->genus = $data['genus'];
        $species->species = $data['species'];
        $species->common_name = $data['common_name'];
        $species->local_name = $data['local_name'];
        $species->country = $data['country'];
        $species->environment = $data['environment'];
        $species->general_description = $data['general_description'];
        $species->iucn_status = $data['iucn_status'];
        $species->threats_to_humans = $data['threats_to_humans'];
        $species->economic_value_uses = $data['economic_value_uses'];
        $species->references = $data['references'];
        $species->public = filter_var($data['public'], FILTER_VALIDATE_BOOLEAN);
        $species->save();

        if(isset($data['file']))
        {   
            foreach ($data['file'] as $image) {
                try {
                    $file_extension = $image->getClientOriginalExtension();
                    $file_date = Carbon::now()->format('Y-m-d');
                    $file_name = time().$image->getClientOriginalName();
                    $file_path = '/wysiwyg/species_files/' . $file_date;

                    $tactical_attachment = new SpeciesFile();
                    $tactical_attachment->species_id = $species->id;
                    $tactical_attachment->file_name = $file_name;
                    $tactical_attachment->file_path = $file_path;
                    $tactical_attachment->file_type = $file_extension;
                    $tactical_attachment->title = $file_name;
                    $tactical_attachment->save();

                    $image->move(public_path() . $file_path, $file_name);
                    
                } catch (\Exception $e) {
                
                    return response()->json(['error' => $e->getMessage()], 200);
                }
            }
        }

        if(isset($data['removed_files']))
        {
            foreach ($data['removed_files'] as $value) {
                $file = SpeciesFile::find($value);
                $file->delete();

                $file_path = $file->file_path;

                $path = public_path() . $file_path . "/" . $file->file_name;
                unlink($path);
            }
        }
        
        $species = Species::with('species_files')->find($species->id);

        return $species;
    }

    public function validate_species($data)
    {   

        $validator = Validator::make($data, 
            [
                'species_id' => 'required|integer',
                'name' => 'required',
            ], 
            [
                'species_id.required' => 'Species ID is required',
                'species.integer' => 'Species ID must be an integer',
                'name.required' => 'Species Name is required',
            ]
        );
        
        if(isset($data['file']))
        {   
            foreach ($data['file'] as $image) {
               
                $file_extension = $image->getClientOriginalExtension();
   
                $validator = Validator::make(
                    [
                        'file' => strtolower($file_extension),
                    ],
                    [
                        'file' => 'in:jpeg,jpg,png',
                    ], 
                    [
                        'file.in' => 'File type must be jpeg, jpg, png.',
                    ]
                );  
                
                if($validator->fails())
                {
                    return response()->json(['error' => $validator->errors()], 200);
                } 
            }
        }
        
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 200);
        }

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {   
        
        $error = $this->validate_species($request->all());

        if($error)
        {
            return $error;
        }

        $species = new Species();
        $species = $this->save_species($species, $request->all());

        return response()->json(['success' => 'Record has been added', 'species' => $species], 200);
    }

    public function getToken()
    {
        $clientToken = new Client();

        $body = ['form_params'  =>
                    [
                    'grant_type' => 'password',
                    'username' => 'administrator',
                    'password' => 'qwerty123456',
                    'scope' => 'img'
                    ]
                ];

        $getToken = $clientToken->post('https://api.bintanseashells.com/token', $body);

        $result = json_decode((string) $getToken->getBody(), true);

        return $result;
    }

    public function show(Species $species)
    {


    }

    public function detectImage()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data',
            'Authorization' => 'Bearer '. $this->getToken()['access_token'],
        ];

        if(request()->hasFile('file')){

            $file = request()->file('file');

            $clientDetectImg = new Client([
                'headers' => $headers
            ]);

            $multipart =
                    [
                        'name'     => 'file',
                        'filename' => $file->getClientOriginalName(),
                        'contents' => fopen($file->getPathname(), 'r'),
                    ];


            $responseDetectImg = $clientDetectImg->post('https://api.bintanseashells.com/detect/img', [
                 'multipart' => [$multipart]
            ]);

            $result = json_decode((string) $responseDetectImg->getBody(), true);

            dd($result);

            $data = $this->species((int)$result['Species']);

            $result['data'] = $data;

            return response()->json($result, 200);

        }else{
             $data = ['message' => 'Error: Please select image to continue.', 'status' => 422];

             return response()->json($data, 422);
        }


    }

    public function species($id)
    {
        $species = Species::where('species_id', $id)->first();

        return $species;
    }

    public function edit(Species $species)
    {
        //
    }

    public function update(Request $request, $id)
    {   
        
        $error = $this->validate_species($request->all());

        if($error)
        {
            return $error;
        }

        $species = Species::find($id);
        $species = $this->save_species($species, $request->all());

        return response()->json(['success' => 'Record has been updated', 'species' => $species], 200);
    }

    public function destroy(Species $species)
    {
        //
    }

    public function delete(Request $request)
    {   
        
        if($request->get('multiple_delete'))
        {   
            $id = array_column($request->items, 'id'); 
            $species = DB::table('species')->whereIn('id', $id)->delete();            
        }
        else
        {
            
            $species = Species::find($request->get('id'));

            //if record is empty then display error page
            if(empty($species->id))
            {
                return abort(404, 'Not Found');
            }

            $species->delete();
        }

        return response()->json(['success' => 'Record has been deleted'], 200);
    }

    
    public function import_species(Request $request) 
    {   
      
        try {
            $file_extension = '';
            $path = '';
            if($request->file('file'))
            {   
                $path1 = $request->file('file')->store('temp'); 
                $path=storage_path('app').'/'.$path1;  
                // $path = $request->file('file')->getRealPath();
                $file_extension = $request->file('file')->getClientOriginalExtension();
            }

            $validator = Validator::make(
                [
                    'file' => strtolower($file_extension),
                ],
                [
                    'file' => 'required|in:xlsx,xls,csv,ods',
                ], 
                [
                    'file.required' => 'File is required',
                    'file.in' => 'File type must be xlsx/xls/csv.',
                ]
            );  
            
            if($validator->fails())
            {
                return response()->json($validator->errors(), 200);
            }
    
            if ($request->file('file')) {
                
                $spreadsheet = IOFactory::load($path);
                $sheet = $spreadsheet->getActiveSheet();
                $ctr_collection = $sheet->getHighestDataRow();

                // $array = Excel::toArray(new ProjectsImport, $request->file('file'));
                // $collection = Excel::toCollection(new SpeciesImport(), $request->file('file'))[0];
                // $ctr_collection = count($collection);
                $columns = ["species_name", "species_id",]; 

                $collection_errors = [];
                $fields = [];    

                if($ctr_collection > 1)
                {   
                    for($x=2; $ctr_collection >= $x; $x++)
                    {   
                        foreach ($columns as $key => $field) {
  
                            $fields[$x - 1]['species_name'] = (String)$sheet->getCell( 'A' . $x )->getValue();
                            $fields[$x - 1]['species_id'] = $sheet->getCell( 'R' . $x )->getValue();
                            
                        }
                    } 
                    // return $fields;
                    $rules = [
                        '*.species_id.integer' => 'Species ID must be and integer',
                        '*.species_name.required' => 'Species Name is required',
                    ];
            
                    $valid_fields = ['*.species_id' => 'nullable|integer', '*.species_name' => 'required'];
                    
                    $validator = Validator::make($fields, $valid_fields, $rules);  
            
                    if($validator->fails())
                    {
                        $collection_errors =  $validator->errors();
                    }
                    
                }
                else
                {   
                    // if file has no row data
                    return response()->json(['error_empty' => 'File is Empty'], 200);
                }

                // if row data has errors
                if(count($collection_errors))
                {
                    return response()->json(['error_row_data' => $collection_errors, 'field_values' => $fields], 200);
                }
                else
                {   
                    // import excel file
                    // Excel::import(new SpeciesImport(), $path);

                    for($x=2; $ctr_collection >= $x; $x++)
                    {
                        Species::create([
                            'species_id' =>$sheet->getCell( 'R' . $x )->getValue(),
                            'name' => $sheet->getCell( 'A' . $x )->getValue(),
                            'kingdom' => $sheet->getCell( 'B' . $x )->getValue(),
                            'phylum' => $sheet->getCell( 'C' . $x )->getValue(),
                            'shell_class' => $sheet->getCell( 'D' . $x )->getValue(),
                            'order' => $sheet->getCell( 'E' . $x )->getValue(),
                            'family' =>$sheet->getCell( 'F' . $x )->getValue(),
                            'genus' =>$sheet->getCell( 'G' . $x )->getValue(),
                            'species' =>$sheet->getCell( 'H' . $x )->getValue(),
                            'common_name' =>$sheet->getCell( 'I' . $x )->getValue(),
                            'local_name' =>$sheet->getCell( 'J' . $x )->getValue(),
                            'country' =>$sheet->getCell( 'K' . $x )->getValue(),
                            'environment' =>$sheet->getCell( 'L' . $x )->getValue(),
                            'general_description' =>$sheet->getCell( 'M' . $x )->getValue(),
                            'iucn_status' =>$sheet->getCell( 'N' . $x )->getValue(),
                            'threats_to_humans' =>$sheet->getCell( 'O' . $x )->getValue(),
                            'economic_value_uses' =>$sheet->getCell( 'P' . $x )->getValue(),
                            'references' =>$sheet->getCell( 'Q' . $x )->getValue(),
                            // 'type' =>$sheet->getCell( 'T' . $row )->getValue(),
                            // 'remarks' =>$sheet->getCell( 'U' . $row )->getValue(),
                        ]);
                    }
                }
                    
                return response()->json([ 'success' => 'Record has successfully imported'], 200);
            }
            else
            {
                return response()->json(['error_empty' => 'File is empty'], 200);
            }
          
        } catch (\Exception $e) {
          
            return response()->json(['error' => $e->getMessage()], 200);
        }
        
    }

    public function export_species() 
    { 
        return Excel::download(new SpeciesExport(), 'Shellsinformation.xls');
    }

    public function publish(Request $request) 
    {   
        $id = array_column($request->items, 'id');

        $status = $request->action == 'publish' ? true : false; // if $request->action == 'publish' else if $request->action == 'unpublish'

        Species::whereIn('id', $id)->update(['public' => $status]);

        return response()->json(['success' => 'Record has been ' . $request->action], 200);
    }
}
