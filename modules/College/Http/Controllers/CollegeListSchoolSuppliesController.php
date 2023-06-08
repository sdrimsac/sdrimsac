<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Http\Resources\CollegeStudentCollection;
use Modules\College\Models\CollegeBrandSuppli;
use Modules\College\Models\CollegeSchoolSupplies;
use Modules\College\Models\CollegeStudent;
use Modules\College\Models\CollegeTeachers;
use Modules\College\Models\CollegeListSupplies;
use Modules\College\Models\CollegeKardexSuppliesMov;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class CollegeListSchoolSuppliesController extends Controller
{

    public function index()
    {
        $branchSupplies = CollegeBrandSuppli::all();
        $salones = $this->listadoSalones();
        
        return view('college::listSchoolSupplies')->with('branchSupplies', $branchSupplies)->with('salones', $salones) ;
    }

    public function saveNewBranch(Request $request){
        $duplicado = CollegeBrandSuppli::where('brnd_supp_name', 'like' ,'%'.$request->nombre.'%')->get();
        
        if(count($duplicado) > 0 ){
            
            return response()->json(['error' => 'No puede estar Duplicada La marca Que se Ingresa'], 400);
        
        }else{

            try{
           
                DB::beginTransaction();
                
                CollegeBrandSuppli::create(['brnd_supp_name'=> $request->nombre]);
                $listbranch = CollegeBrandSuppli::all();
                DB::commit();
                
                
            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }
            
        }
        return $listbranch ; 
        
    }
    public function saveSupplie(Request $request){
        $inputName = $request->inputName;
        $codigo = $request->codigo;
        $brandId = $request->item_id;
        $status= 1 ; 

        

        $duplicadoCodigo = CollegeSchoolSupplies::where('s_supp_codigo', $codigo)->get();
        if(count($duplicadoCodigo) > 0  ) {
            
            return response()->json(['error' => 'El Codigo que ingresa No puede estar Duplicado'], 400);
        }else{
            try{
                DB::beginTransaction();
                CollegeSchoolSupplies::create(['s_supp_name' => $inputName,
                                            's_supp_brand' => $brandId,
                                            's_supp_status' => $status,
                                            's_supp_codigo' => $codigo]);
                
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
       
        return 'devolviendo el info de saveSupplie';
    }

    public  function searchnameSupplies(Request $request){
        
        $busqueda = CollegeSchoolSupplies::where('s_supp_name','like' ,'%'.$request->input.'%')->limit(2)->get();
        
        return response()->json(['resultado' => $busqueda]);
    }
    public  function searchCodeSupplies(Request $request){
        
        $busqueda = CollegeSchoolSupplies::where('s_supp_codigo','like' ,'%'.$request->input.'%')->limit(2)->get();
        
        return response()->json(['resultado' => $busqueda]);
    }
    public function searchRemoteUtilIng(Request $request){
        
        $busqueda = CollegeSchoolSupplies::where('s_supp_name','like' ,'%'.$request->input.'%')->get();
        return response()->json(['resultado' => $busqueda]);
    }
    public function searchRemotealumno(Request $request){
        
        $alumno =  CollegeStudent::select('college_students.id as college_students_id','college_students.*', 'persons.*')
        ->join('persons', 'college_students.student_id','=', 'persons.id')
        ->where('persons.name', 'like','%'.$request->input.'%'  )
        ->where('college_students.active', '=', 1)
        ->get();
        
        return response()->json(['resultado' => $alumno]);

    }
    public function searchRemoteProf(Request $request){
        $Profesor =  CollegeTeachers::where('persons.name', 'like','%'.$request->input.'%'  )
        ->join('persons', 'college_teachers.teach_pers_id','=', 'persons.id')
        ->where('college_teachers.active', '=' , 1 )->get();
        
        return response()->json(['resultado' => $Profesor]);

    }

    public function saveIntoAlmacenUtil(Request $request){
        
        $alumno = $request->alumn ; 
        $cantidadStock  = $request->cantidad;
        $newcantidadStock = $cantidadStock ; 
        $idSupplies =  $request->util;
        $observacion = '';
        $conslta = CollegeStudent::where('id', '=',$alumno )->get() ;
        $salonid  = 0 ;
        foreach($conslta as $student ){
           $salonid =  $student->classroom_id;
            
        }

        //VALIDAR SI EL PRODUCTO SE ENCUETRA REPETIDO DENTRO DE LA TABLA , SI YA ESTA NO ES UN INSERT SI NO UNA ACTUALIZACION 
        // Se entiende que el id del alumno debe de ser unico por salon 
        $registro = CollegeListSupplies::where('list_supp_s_supp_id', '=' , $idSupplies )
            ->where('list_supp_classroom_id', '=', $salonid)->count();
            
        if($registro > 0 ){//encuentra registro, suma al que encontro 
            $data = CollegeListSupplies::where('list_supp_s_supp_id', '=' , $idSupplies )->where('list_supp_classroom_id', '=', $salonid)->first()->toArray();
            $newcantidadStock += $data['list_supp_cantidad'];
            try{
           
                DB::beginTransaction();
               
                DB::select('update college_list_supplies set list_supp_cantidad = ? where list_supp_id = ?  ', [$newcantidadStock,$data['list_supp_id'] ]);
            
                CollegeKardexSuppliesMov::create([
                    'k_supp_id_list' => $data['list_supp_id'] ,
                    'k_supp_id_alum' => $alumno ,
                    'k_supp_id_profe' =>  null,
                    'k_supp_id_type_event' => 1, /// 
                    
                    'k_supp_cantidad'=> $cantidadStock,
                    'k_supp_DescMovimiento'=> $observacion ]);
                
    
                DB::commit();
                
                
            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }

            


           // CollegeListSupplies::update('list_supp_cantidad',$cantidadStock  )->where('list_supp_id', '=', $data);
            
            //CollegeListSupplies::update();
        }else{//no encuentra crea un nuevo registro 
            try{
           
                DB::beginTransaction();
               
             $insert =   CollegeListSupplies::create([
                'list_supp_s_supp_id' => $idSupplies ,
                'list_supp_classroom_id' => $salonid,
                'list_supp_cantidad' => $cantidadStock


             ] );
            
                CollegeKardexSuppliesMov::create([
                    'k_supp_id_list' => $insert->id ,
                    'k_supp_id_alum' => $alumno ,
                    'k_supp_id_profe' =>  null,
                    'k_supp_id_type_event' => 1, /// 
                    
                    'k_supp_cantidad'=> $cantidadStock,
                    'k_supp_DescMovimiento'=> $observacion ]);
                
    
                DB::commit();
                
                
            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }

        //insert dentro de la tabla college_list_supplies

        return 'devolviendo items guardados';
    }

    public function datosTablaAlmacen(Request $request){
        $inputnameItem = $request->inputnameItem;
        $salon = $request->salon;
        if($salon == null ){
            $salon = 'campoVacio';
        }
      
        if($salon == 'campoVacio' && isNull($salon)|| $salon == 'campoVacio' && $salon == 'campoVacio'){
            $records =  CollegeListSupplies::select('college_list_supplies.list_supp_id',
            'college_school_supplies.s_supp_name',
            'college_list_supplies.list_supp_cantidad',
            'college_degrees.description as grade_desc',
            'college_levels.description as nivel_desc',
            'college_sections.description as sections_desc','college_school_supplies.s_supp_codigo' )
            ->join('college_classrooms', 'list_supp_classroom_id','=','college_classrooms.id')
            ->join('college_school_supplies', 'list_supp_s_supp_id','=','s_supp_id')
            ->join('college_degrees', 'degree_id','=','college_degrees.id')
            ->join('college_levels', 'level_id','=','college_levels.id')
            ->join('college_sections', 'section_id','=','college_sections.id');
            if($inputnameItem != 'campoVacio' ){
                $records =   $records->whereRaw('college_school_supplies.s_supp_name like "%'.$inputnameItem.'%"');
            }
            if($inputnameItem != 'campoVacio' ){
                $records =   $records->whereRaw('college_school_supplies.s_supp_name like "%'.$inputnameItem.'%"');
            }
            
            $records = $records->paginate(20);
        }else{
            $records =  CollegeListSupplies::select('college_list_supplies.list_supp_id',
            'college_school_supplies.s_supp_name',
            'college_list_supplies.list_supp_cantidad',
            'college_degrees.description as grade_desc',
            'college_levels.description as nivel_desc',
            'college_sections.description as sections_desc','college_school_supplies.s_supp_codigo' )
            ->join('college_classrooms', 'list_supp_classroom_id','=','college_classrooms.id')
            ->join('college_school_supplies', 'list_supp_s_supp_id','=','s_supp_id')
            ->join('college_degrees', 'degree_id','=','college_degrees.id')
            ->join('college_levels', 'level_id','=','college_levels.id')
            ->join('college_sections', 'section_id','=','college_sections.id')
            ->whereRaw('college_list_supplies.list_supp_classroom_id = '.$salon.'');
            if($inputnameItem != 'campoVacio'){
                $records =   $records->whereRaw('college_school_supplies.s_supp_name like "%'.$inputnameItem.'%"');
            }
            $records = $records->paginate(20);
        }

       
       
        return $records;
    }

    public function getDetailSupplies(Request $request){
        //obtener el id del salon , buscar en el kardex los ingresos de los alumnos pretenecientes a ese salon y a ese item 

        
         $data= CollegeListSupplies::select('college_school_supplies.s_supp_name',
         'college_school_supplies.s_supp_id',
         'college_kardex_supplies_mov.k_supp_cantidad',
         'college_list_supplies.*',
         'persons.name',
         'college_kardex_supplies_mov.k_supp_id',
         'college_kardex_supplies_mov.k_supp_id_profe',
         'college_kardex_supplies_mov.k_supp_id_alum',
         'college_kardex_supplies_mov.k_supp_id_type_event',
         'college_kardex_supplies_mov.k_supp_DescMovimiento',
         'event_kardex.even_desc', 'college_kardex_supplies_mov.created_at AS crate_at_mov_kardex')
            ->join('college_kardex_supplies_mov', 'college_list_supplies.list_supp_id','=', 'college_kardex_supplies_mov.k_supp_id_list')
            ->leftJoin('college_students', 'college_kardex_supplies_mov.k_supp_id_alum','=', 'college_students.id')
            ->leftJoin('college_school_supplies', 'college_list_supplies.list_supp_s_supp_id','=', 'college_school_supplies.s_supp_id')
            ->leftJoin('college_teachers', 'college_kardex_supplies_mov.k_supp_id_profe','=', 'college_teachers.teach_id')
            //->leftJoin('persons',function($join){ $join->on ('college_students.student_id','=', 'persons.id')->orWhere('persons.id','=', 'college_teachers.teach_pers_id'); })
            //->join(DB::raw('persons ON college_students.student_id = persons.id OR persons.id = college_teachers.teach_pers_id '))
            ->leftJoin('persons', function($join) {
                $join->on('college_students.student_id', '=', 'persons.id');
                $join->orOn('college_teachers.teach_pers_id', '=', 'persons.id');
            })
            ->leftJoin('event_kardex', 'college_kardex_supplies_mov.k_supp_id_type_event','=', 'event_kardex.id')
            ->where('list_supp_id', '=',  $request->idListSupplies)
            ->paginate(10);
            
        return $data ; 
    }
    public function listadoSalones(){
        $salones = DB::select('SELECT
                college_classrooms.id,
                college_degrees.description AS degres_desc,
                college_levels.description AS lvl_desc,
                college_turns.description AS turn_desc,
                college_sections.description AS sect_desc 
            FROM
                college_classrooms
                INNER JOIN college_degrees ON college_classrooms.degree_id = college_degrees.id
                INNER JOIN college_levels ON college_classrooms.level_id = college_levels.id
                INNER JOIN college_sections ON college_classrooms.section_id = college_sections.id
                INNER JOIN college_turns ON college_classrooms.turn_id = college_turns.id'
        );
        $dataProfesores = DB::select('SELECT        *     FROM        college_teachers        INNER JOIN persons ON college_teachers.teach_pers_id = persons.id'); 

        return response()->json(['salones' => $salones , 'dataProfesores'=> $dataProfesores  ]);
    }
    public function utilesPorSalonDeClases(Request $request){
        $data = DB::select('SELECT
                college_classrooms.id classrooms_id,
                college_degrees.description AS degres_desc,
                college_levels.description AS lvl_desc,
                college_turns.description AS turn_desc,
                college_sections.description AS sect_desc,
                college_school_supplies.s_supp_name,
                
                college_list_supplies.*
            FROM
                college_classrooms
                INNER JOIN college_degrees ON college_classrooms.degree_id = college_degrees.id
                INNER JOIN college_levels ON college_classrooms.level_id = college_levels.id
                INNER JOIN college_sections ON college_classrooms.section_id = college_sections.id
                INNER JOIN college_turns ON college_classrooms.turn_id = college_turns.id
                INNER JOIN college_list_supplies ON college_classrooms.id = college_list_supplies.list_supp_classroom_id
                INNER JOIN college_school_supplies ON college_list_supplies.list_supp_s_supp_id = college_school_supplies.s_supp_id where college_classrooms.id =  ?',[$request->item]);

        
        return $data;
    }
    public function SacarUtilsave(Request $request){
        $respuesta = $request->all();
       
        $cantidadStock = $respuesta['stock'] ; 
        $newcantidadStock = $respuesta['stock'];
        $observacion = '' ;

        try {
            $data = CollegeListSupplies::where('list_supp_id', '=' , $respuesta['util'] )->where('list_supp_cantidad','=', $newcantidadStock)->firstOrFail()->toArray();
            $newcantidadStock -= $respuesta['cantidadRetirar'];
        } catch (\Exception $e) {
            return response()->json(['error' => 'Los datos que indica no Coinciden, ha habido una actualizacion de Stock que no tiene reflejada'], 400);
        }
        
            try{
           
                DB::beginTransaction();
               
                DB::select('update college_list_supplies set list_supp_cantidad = ? where list_supp_id = ?  ', [$newcantidadStock,$data['list_supp_id'] ]);
            
                CollegeKardexSuppliesMov::create([
                    'k_supp_id_list' => $data['list_supp_id'] ,
                    'k_supp_id_alum' => null ,
                    'k_supp_id_profe' =>  $respuesta['profesor'],
                    'k_supp_id_type_event' => 2, /// 
                 
                    'k_supp_cantidad'=> $respuesta['cantidadRetirar'],
                    'k_supp_DescMovimiento'=> $respuesta['observacion'] ]);
                
    
                DB::commit();
                
                
            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 400);
            }

        return $data;
    }

    
}
