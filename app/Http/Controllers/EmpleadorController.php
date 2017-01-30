<?php

namespace App\Http\Controllers;

use App\DataTables\EmpleadorDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Requests\CreateEmpleadorRequest;
use App\Http\Requests\UpdateEmpleadorRequest;
use App\Repositories\EmpleadorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Empleador;
use App\Models\Oferta;
use App\User;

class EmpleadorController extends AppBaseController
{
    /** @var  EmpleadorRepository */
    private $empleadorRepository;

    public function __construct(EmpleadorRepository $empleadorRepo)
    {
        $this->empleadorRepository = $empleadorRepo;
    }
	
	public function getempleador(){ 
		$id_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;	
		$item= Empleador::where([ ['id', '=',$id_ ] ] )->first();
		return Response::json(  $item );
    }
	public function actualizar(){ 
		$id_ ="";
		$contacto_ ="";
		$correo_ ="";
		$empresa_ ="";
		$telefono_ ="";
		$direccion_ ="";
		$descripcion_ ="";
		$ciudad_id_ ="";
		$url_imagen_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			if (isset($requestx->contacto)) {
				$contacto_  = $requestx->contacto;
			}
			if (isset($requestx->correo)) {
				$correo_  = $requestx->correo;
			}
			if (isset($requestx->empresa)) {
				$empresa_ = $requestx->empresa;
			}
			if (isset($requestx->telefono)) {
				$telefono_ = $requestx->telefono;
			}
			if (isset($requestx->direccion)) {
				$direccion_ = $requestx->direccion;
			}
			if (isset($requestx->descripcion)) {
				$descripcion_ = $requestx->descripcion;
			}
			if (isset($requestx->ciudad_id)) {
				$ciudad_id_ = $requestx->ciudad_id;
			}
			if (isset($requestx->url_imagen)) {
				$url_imagen_ = $requestx->url_imagen;
			}
		}	
		$emp= Empleador::where([ ['id', '=',$id_ ] ] )->first();
		if($emp){
			 $id_usr=$emp->user_id;
			 $emp->contacto=$contacto_;
			 $emp->correo=$correo_;
			 $emp->empresa=$empresa_;
			 $emp->telefono=$telefono_;
			 $emp->direccion=$direccion_;
			 $emp->descripcion=$descripcion_;
			 $emp->ciudad_id=$ciudad_id_;
			 if( $emp->save() ){
				if($url_imagen_!=''){
				   $url_perfil= $this->guardar_imagen($id_usr,$url_imagen_);
				   $user =User::where([ ['id', '=', $id_usr ] ] )->first();
				   if($user){
						$user->url_imagen= $url_perfil;
						$user->save();
				   }	 
				}
				$RP = '{"hecho":true,"msg" : "Perfil actualizado" }';
			    return $RP;
			}
		}
		$RP = '{"hecho":false }';
		return $RP;
     }
	 
	 public function getdetalle(){ //detalle 
		$id_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)){
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
				$id_  = strip_tags($id_); 
			}
		}	
		/*$item = DB::select( DB::raw("SELECT E.id,E.contacto,E.empresa,E.telefono,E.correo,E.ciudad_id,
                  U.url_imagen,E.descripcion,E.direccion,U.id as userid,C.descripcion as des_ciudad
                  FROM empleadores E,users U,ciudades C
                  WHERE E.id='". $id_ ."' and E.user_id=U.id and E.ciudad_id=C.id ") );*/
		$item  = Empleador::select('empleadores.id','empleadores.empresa','empleadores.contacto','empleadores.telefono',
		     'empleadores.correo','empleadores.descripcion','empleadores.direccion','users.id as iduser','users.url_imagen',
			 'users.email as usuario','ciudades.descripcion as des_ciudad')
			->where('empleadores.id', '=', $id_)
            ->join('users','empleadores.user_id','=','users.id')
            ->join('ciudades','empleadores.ciudad_id','=','ciudades.id')
		    ->first();		
		if(count($item)==0){
			 return Response::json( null );
		}else{
			$a1= json_decode(json_encode($item), true); 
			date_default_timezone_set('America/Bogota');
			$fecha_ = date("Y-m-d", time());
			$hora_=  date("H:i:s", time());
			$validar=$fecha_.$hora_;	
			$tt_ofertas = Oferta::where([ ['empleador_id', '=',$id_ ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )->count();
			$a2= array('publicaciones' => $tt_ofertas) ;
			$rpx= array_merge($a1,$a2);
			return Response::json($rpx);  
		}
		
     }	
	
	
	private function guardar_imagen($id,$url){
		$file=asset('/images/system_imgs/no-picture.jpg');
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
	    );
		$img ="";
		$img_local="";
		if($url!=""){
			$img = @file_get_contents($url, false, stream_context_create($arrContextOptions));
			 if($img==false){
				 return $file;
			  }
		}
		if($img!=""){
			$img_local='/images/system_imgs/usuarios/puser_' . $id .'.jpg';
			$file =public_path().$img_local;
			file_put_contents($file, $img);
			$file =asset($img_local);
		}
		return $file;
	}
	
	
		
    /**
     * Display a listing of the Empleador.
     *
     * @param EmpleadorDataTable $empleadorDataTable
     * @return Response
     */
    public function index(EmpleadorDataTable $empleadorDataTable)
    {
        return $empleadorDataTable->render('empleadors.index');
    }

    /**
     * Show the form for creating a new Empleador.
     *
     * @return Response
     */
    public function create()
    {
        return view('empleadors.create');
    }

    /**
     * Store a newly created Empleador in storage.
     *
     * @param CreateEmpleadorRequest $request
     *
     * @return Response
     */
    public function store(CreateEmpleadorRequest $request)
    {
        $input = $request->all();

        $empleador = $this->empleadorRepository->create($input);

        Flash::success('Empleador saved successfully.');

        return redirect(route('empleadors.index'));
    }

    /**
     * Display the specified Empleador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $empleador = $this->empleadorRepository->findWithoutFail($id);

        if (empty($empleador)) {
            Flash::error('Empleador not found');

            return redirect(route('empleadors.index'));
        }

        return view('empleadors.show')->with('empleador', $empleador);
    }

    /**
     * Show the form for editing the specified Empleador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $empleador = $this->empleadorRepository->findWithoutFail($id);

        if (empty($empleador)) {
            Flash::error('Empleador not found');

            return redirect(route('empleadors.index'));
        }

        return view('empleadors.edit')->with('empleador', $empleador);
    }

    /**
     * Update the specified Empleador in storage.
     *
     * @param  int              $id
     * @param UpdateEmpleadorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmpleadorRequest $request)
    {
        $empleador = $this->empleadorRepository->findWithoutFail($id);

        if (empty($empleador)) {
            Flash::error('Empleador not found');

            return redirect(route('empleadors.index'));
        }

        $empleador = $this->empleadorRepository->update($request->all(), $id);

        Flash::success('Empleador updated successfully.');

        return redirect(route('empleadors.index'));
    }

    /**
     * Remove the specified Empleador from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $empleador = $this->empleadorRepository->findWithoutFail($id);

        if (empty($empleador)) {
            Flash::error('Empleador not found');

            return redirect(route('empleadors.index'));
        }

        $this->empleadorRepository->delete($id);

        Flash::success('Empleador deleted successfully.');

        return redirect(route('empleadors.index'));
    }
}
