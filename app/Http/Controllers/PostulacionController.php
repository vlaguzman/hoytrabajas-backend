<?php

namespace App\Http\Controllers;

use App\DataTables\PostulacionDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostulacionRequest;
use App\Http\Requests\UpdatePostulacionRequest;
use App\Repositories\PostulacionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Postulacion;
use App\Models\Oferta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostulacionController extends AppBaseController
{
    /** @var  PostulacionRepository */
    private $postulacionRepository;

    public function __construct(PostulacionRepository $postulacionRepo)
    {
        $this->postulacionRepository = $postulacionRepo;
    }
	
	public function listar(){
		$prop_ ="";
		$est_  ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->propietario)) {
				$prop_ = $requestx->propietario;
			}
			if (isset($requestx->estatus)) {
				$est_ = $requestx->estatus;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT O.* FROM ofertas O,postulaciones P 
		        WHERE P.oferta_id=O.id and P.estatus_id='". $est_ ."' and P.candidato_id='". $prop_  ."'  ") );	
		return Response::json(
		    [ 'posts' =>  $lista ]
		);
     }
	 
	 public function empleadores(){
		$prop_ ="1";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$prop_ = $requestx->id;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT DISTINCT U.id,E.contacto as name,E.empresa,E.telefono,
		        E.created_at as ago,P.estatus_id,U.url_imagen as face 
		        FROM ofertas O,postulaciones P,empleadores E,users U 
		        WHERE P.candidato_id='". $prop_  ."' and P.estatus_id in ('1','2') and P.oferta_id=O.id 
				   and O.empleador_id=E.id and E.user_id=U.id ") );
		return Response::json(
		     $lista 
		);
     }	
	 public function usuarios(){
		$prop_ ="1";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$prop_ = $requestx->id;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT DISTINCT U.id,E.nombres as name,E.apellidos as empresa,E.telefono,
		        E.created_at as ago,U.url_imagen as face 
				FROM ofertas O,postulaciones P,candidatos E,users U 
		        WHERE P.estatus_id in ('1','2') and P.oferta_id=O.id and O.empleador_id='". $prop_  ."'
				   and P.candidato_id=E.id and E.user_id=U.id ") );
		return Response::json(
		     $lista 
		);
     }	
	 
	public function upendientes(){
		$prop_ ="";
		$oferta_ ="24";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)){
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$prop_ = $requestx->id;
			}
			if (isset($requestx->oferta)) {
				$oferta_ = $requestx->oferta;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT DISTINCT P.id as pid,E.id,E.nombres,E.apellidos,
		        E.created_at as ago,U.id as userid,U.url_imagen,E.telefono,E.correo,E.descripcion,E.experiencia,E.rate
				FROM ofertas O,postulaciones P,candidatos E,users U 
		        WHERE O.id='". $oferta_ ."' and P.estatus_id ='1' and P.oferta_id=O.id AND P.candidato_id=E.id and E.user_id=U.id ") );
		return Response::json(
		     $lista 
		);
     }	
	 public function uaceptadas(){
		$prop_ ="";
		$oferta_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)){
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$prop_ = $requestx->id;
			}
			if (isset($requestx->oferta)) {
				$oferta_ = $requestx->oferta;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT DISTINCT E.id,E.nombres ,E.apellidos,
		        E.created_at as ago,U.id as userid,U.url_imagen,E.telefono,E.correo,E.descripcion,E.experiencia,E.rate
		        FROM ofertas O,postulaciones P,candidatos E,users U 
		        WHERE O.id='". $oferta_ ."'  and P.estatus_id ='2' and P.oferta_id=O.id 
				and P.candidato_id=E.id and E.user_id=U.id ") );
		return Response::json(
		     $lista 
		);
     }		
     public function urechazadas(){
		$prop_ ="";
		$oferta_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)){
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$prop_ = $requestx->id;
			}
			if (isset($requestx->oferta)) {
				$oferta_ = $requestx->oferta;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		$lista = DB::select( DB::raw("SELECT DISTINCT E.id,E.nombres,E.apellidos,
		        E.created_at as ago,U.id as userid,U.url_imagen,E.telefono,E.correo,E.descripcion,E.experiencia,E.rate
		        FROM ofertas O,postulaciones P,candidatos E,users U 
		        WHERE O.id='". $oferta_ ."'  and P.estatus_id ='3' and P.oferta_id=O.id and P.candidato_id=E.id and E.user_id=U.id ") );
		return Response::json(
		     $lista 
		);
     }			
			
	public function verificar(Request $request){
		$id_oferta ="";
		$id_empleado ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->oferta)) {
				$id_oferta = $requestx->oferta;
			}
			if (isset($requestx->empleado)) {
				$id_empleado = $requestx->empleado;
			}
			$postulacion=Postulacion::where([ ['oferta_id', '=', $id_oferta],['candidato_id', '=', $id_empleado] ] )->first();
		    if (empty($postulacion)) {
				$RP = '{"postulado":false }';
				return $RP;
			}else{
				$carbon = new Carbon($postulacion->created_at, 'America/Bogota');
                $nv_fecha= $carbon->addDays(1);
				$fa = Carbon::now('America/Bogota');
                $prog = $fa->diffInHours($nv_fecha);
				$RP = '{"postulado":true, "estatus": "'. $postulacion->estatus_id .'",
				"desde": "'. $fa .'","vence": "'. $nv_fecha .'","horas": "'. $prog .'"  }';
				return $RP;
			}
		}	
	 }		
	public function registrar(Request $request){
		$id_ ="";
		$emp_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			if (isset($requestx->postulante)) {
				$emp_  = $requestx->postulante;
			}
			$postulacion=Postulacion::where([ ['oferta_id', '=', $id_],['candidato_id', '=', $emp_]   ] )->first();
		    if ($postulacion) {
				$RP = '{"registro":false,"msg" : "Ya tienes una postulacion pendiente a esta oferta" }';
				return $RP;
			}	
			$obj = Postulacion::create([
						'estatus_id' => 1,
						'oferta_id' => intval($id_),
						'candidato_id' => intval($emp_),
			       ]);
			if($obj){
				$RP = '{"registro":true,"msg" : "Postulado exitosamente!" }';
				return $RP;
			}else{
				$RP = '{"registro":false,"msg" : "No se pudo procesar la postulacion, intente mas tarde" }';
				return $RP;
			}
		}	
	 }	
	public function aprobar(Request $request){
		$id_ ="";
		$emp_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			$postulacion=Postulacion::find($id_);
		    if (!empty($postulacion)) {
				$postulacion->estatus_id=2;
				if($postulacion->save()){
				    $RP = '{"registro":true,"msg" : "Empleado Aceptado!" }';
				   return $RP;
				}
			}
			$RP = '{"registro":false,"msg" : "No se pudo procesar, intente mas tarde" }';
			return $RP;
		}	
	}	
	public function rechazar(Request $request){
		$id_ ="";
		$emp_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			$postulacion=Postulacion::find($id_);
		    if (!empty($postulacion)) {
				$postulacion->estatus_id=3;
				if($postulacion->save()){
				    $RP = '{"registro":true,"msg" : "Empleado rechazado!" }';
				   return $RP;
				}
			}
			$RP = '{"registro":false,"msg" : "No se pudo procesar, intente mas tarde" }';
			return $RP;
		}	
	 }
	 
    /**
     * Display a listing of the Postulacion.
     *
     * @param PostulacionDataTable $postulacionDataTable
     * @return Response
     */
    public function index(PostulacionDataTable $postulacionDataTable)
    {
        return $postulacionDataTable->render('postulacions.index');
    }

    /**
     * Show the form for creating a new Postulacion.
     *
     * @return Response
     */
    public function create()
    {
        return view('postulacions.create');
    }

    /**
     * Store a newly created Postulacion in storage.
     *
     * @param CreatePostulacionRequest $request
     *
     * @return Response
     */
    public function store(CreatePostulacionRequest $request)
    {
        $input = $request->all();

        $postulacion = $this->postulacionRepository->create($input);

        Flash::success('Postulacion saved successfully.');

        return redirect(route('postulacions.index'));
    }

    /**
     * Display the specified Postulacion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $postulacion = $this->postulacionRepository->findWithoutFail($id);

        if (empty($postulacion)) {
            Flash::error('Postulacion not found');

            return redirect(route('postulacions.index'));
        }

        return view('postulacions.show')->with('postulacion', $postulacion);
    }

    /**
     * Show the form for editing the specified Postulacion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $postulacion = $this->postulacionRepository->findWithoutFail($id);

        if (empty($postulacion)) {
            Flash::error('Postulacion not found');

            return redirect(route('postulacions.index'));
        }

        return view('postulacions.edit')->with('postulacion', $postulacion);
    }

    /**
     * Update the specified Postulacion in storage.
     *
     * @param  int              $id
     * @param UpdatePostulacionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostulacionRequest $request)
    {
        $postulacion = $this->postulacionRepository->findWithoutFail($id);

        if (empty($postulacion)) {
            Flash::error('Postulacion not found');

            return redirect(route('postulacions.index'));
        }

        $postulacion = $this->postulacionRepository->update($request->all(), $id);

        Flash::success('Postulacion updated successfully.');

        return redirect(route('postulacions.index'));
    }

    /**
     * Remove the specified Postulacion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $postulacion = $this->postulacionRepository->findWithoutFail($id);

        if (empty($postulacion)) {
            Flash::error('Postulacion not found');

            return redirect(route('postulacions.index'));
        }

        $this->postulacionRepository->delete($id);

        Flash::success('Postulacion deleted successfully.');

        return redirect(route('postulacions.index'));
    }
}
