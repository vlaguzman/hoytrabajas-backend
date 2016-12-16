<?php

namespace App\Http\Controllers;

use App\DataTables\UsuarioDataTable;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Repositories\UsuarioRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use App\User;
use App\Models\Empleador;
use App\Models\Candidato;
use App\Models\Usuario;
use App\Models\SectorCandidato;
use App\Models\IdiomasCandidato;
use App\Models\EstudiosCandidato;
			

class UsuarioController extends AppBaseController
{
    /** @var  UsuarioRepository */
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepo)
    {
        $this->usuarioRepository = $usuarioRepo;
    }
	
	public function login(Request $request){
		/*if (!is_array($request->all())) {
            return ['error' => 'array requerido'];
        }
		$usu_=$request->usuario;
		$psw_=$request->clave;*/
		$usu_="";
		$psw_="";
		$tp_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->usuario)) {
				$usu_ = $requestx->usuario;
			}
			if (isset($requestx->clave)) {
				$psw_ = $requestx->clave;
			}
			if (isset($requestx->tp)) {
				$tp_ = $requestx->tp;
			}
		}
		$okp=Auth::attempt(['email' => $usu_, 'password' => $psw_]);
		$usuario=Usuario::where([ ['email', '=', $usu_] ] )->first();
		if ($okp  && $usuario ){
		   $RP = '{"login":false}';
		   $id_=$usuario->id;
		   $tp_=$usuario->tipo;
		   if($tp_=="1"){ //para administradores
			   
		   }else if($tp_=="2"){//para empleadores
			   $obj=Empleador::where([ ['user_id', '=', $id_] ] )->first();
			   $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '", 
				  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $obj->url_imagen . '",
				  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
				  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
				  "rol":"2" }'; 
		   }else if ($tp_=="3"){ //para usuarios
		       $obj=Candidato::where([ ['user_id', '=', $id_] ] )->first();
		       $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","empresa":"N/A", 
				  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $obj->url_imagen . '",
				  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
				  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '","fnac":"'. $obj->fnac . '",
				  "experiencia":"'. $obj->experiencia . '","genero_id":"'. $obj->genero_id . '","calificacion":"'. $obj->rate .'",
				  "rol": "3" }'; 
		   } 
           return $RP;
        }else{
			$RP = '{"login":false,"msg" : "Credenciales invalidas" }';
			return $RP ;
		}
	 }	
		
	public function registrar2(Request $request){
		$usu_="";
		$psw_="";
		$nombre_ ="";
		$empresa_ ="";
		$telefono_ ="";
		$descripcion_ ="";
		$direccion_ ="";
		$ciudad_id_ ="";
		$url_imagen_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->usu)) {
				$usu_ = $requestx->usu;
			}
			if (isset($requestx->clave)) {
				$psw_ = $requestx->clave;
			}
			if (isset($requestx->nombre)) {
				$nombre_  = $requestx->nombre;
			}
			if (isset($requestx->empresa)) {
				$empresa_ = $requestx->empresa;
			}
			if (isset($requestx->telefono)) {
				$telefono_ = $requestx->telefono;
			}
			if (isset($requestx->des)) {
				$descripcion_ = $requestx->des;
			}
			if (isset($requestx->dire)) {
				$direccion_ = $requestx->dire;
			}
			if (isset($requestx->ciudad_id)) {
				$ciudad_id_ = $requestx->ciudad_id;
			}
			if (isset($requestx->imagen)) {
				$url_imagen_ = $requestx->imagen;
			}
			$user = User::whereEmail( $usu_ )->first();
			$url_imagen_ ="img/no-photo.jpg";
			if(!$user){
				$obj =  User::create([
					'name' => $nombre_,
					'email' => $usu_,
					'tipo' => 2,
					'url_imagen' => $url_imagen_,
					'password' => bcrypt($psw_),
				 ]);
				$id_usr=$obj->id;
				$obj = Empleador::create([
							'contacto' => $nombre_,
							'empresa' => $empresa_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'url_imagen' => $url_imagen_,
							'ciudad_id' => intval($ciudad_id_),
							'user_id' => intval($id_usr),
				]);
				if($obj){
					$RP = '{"registro":true,"msg" : "Empresa '. $empresa_ .', registrada exitosamente!" }';
					return $RP;
				}else{
					$RP = '{"registro":false,"msg" : "No se pudo procesar el registro, intente mas tarde" }';
					return $RP;
				}
			}else{
				$RP = '{"registro":false,"msg" : "Usuario '. $usu_  .' , ya esta registrado, ingrese uno distinto" }';
				return $RP;
			}
		}
		$RP = '{"registro":false,"msg" : "No se ha podido registrar" }';
		return $RP;
	}	
	public function registrar3(Request $request){
		/*if (!is_array($request->all())) {
            return ['error' => 'array requerido'];
        }*/
		$usu_="";
		$psw_="";
		$nombre_ ="";
		$apellido_ ="";
		$telefono_ ="";
		$descripcion_ ="";
		$direccion_ ="";
		$ciudad_id_ ="1";
		$genero_ ="";
		$url_imagen_ ="";
		$fnac_ = "01-01-2000";
		$rate_ = "0";
		$expe_ = "0";
		$sectores_ ="";
		$idiomas_ = "";
		$estudios_ = "";
		
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->usu)) {
				$usu_ = $requestx->usu;
			}
			if (isset($requestx->clave)) {
				$psw_ = $requestx->clave;
			}
			if (isset($requestx->nombre)) {
				$nombre_  = $requestx->nombre;
			}
			if (isset($requestx->apellido)) {
				$apellido_ = $requestx->apellido;
			}
			if (isset($requestx->telefono)) {
				$telefono_ = $requestx->telefono;
			}
			if (isset($requestx->fnac)) {
				$fnac_ = $requestx->fnac;
			}
			if (isset($requestx->des)) {
				$descripcion_ = $requestx->des;
			}
			if (isset($requestx->dire)) {
				$direccion_ = $requestx->dire;
			}
			if (isset($requestx->ciudad_id)) {
				$ciudad_id_ = $requestx->ciudad_id;
			}
			if (isset($requestx->imagen)) {
				$url_imagen_ = $requestx->imagen;
			}
			if (isset($requestx->expe)) {
				$expe_ = $requestx->expe;
			}
			if (isset($requestx->rate)) {
				$rate_ = $requestx->rate;
			}
			if (isset($requestx->genero)) {
				$genero_ = $requestx->genero;
			}
			if (isset($requestx->estudios)) {
				$estudios_ = $requestx->estudios;
			}
			if (isset($requestx->idiomas)) {
				$idiomas_ = $requestx->idiomas;
			}
			if (isset($requestx->sectores)) {
				$sectores_ = $requestx->sectores;
			}
			
			$user = User::whereEmail( $usu_ )->first();
			$url_imagen_ ="img/no-photo.jpg";
			$ciudad_id_ = "1";
			if(!$user){
				$obj =  User::create([
					'name' => $nombre_,
					'email' => $usu_,
					'tipo' => 3,
					'url_imagen' => $url_imagen_,
					'password' => bcrypt($psw_),
				 ]);
				$id_usr=$obj->id;
				$obj = Candidato::create([
							'nombres' => $nombre_,
							'apellidos' => $apellido_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'url_imagen' => $url_imagen_,
							'fnac' => date("Y-m-d", strtotime( $fnac_  )),
							'experiencia' => intval($expe_),
							'rate' => intval($rate_),
							'ciudad_id' => intval($ciudad_id_),
							'genero_id' => intval($genero_),
							'user_id' => intval($id_usr),
				]);
				if($obj){
					$id_=$obj->id;
					SectorCandidato::create([
								'candidato_id' => $id_,
								'sector_id' => intval($sectores_),
					]);
					IdiomasCandidato::create([
								'candidato_id' => $id_,
								'idioma_id' => intval($idiomas_),
					]);
					EstudiosCandidato::create([
								'candidato_id' => $id_,
								'estudio_id' => intval($estudios_),
					]);
					$RP = '{"registro":true, "id" : "'. $id_ .'" ,"msg" : "Usuario '. $nombre_ .', registrada exitosamente!" }';
					return $RP;
				}else{
					$RP = '{"registro":false,"msg" : "No se pudo procesar el registro, intente mas tarde" }';
					return $RP;
				}
			}else{
				$RP = '{"registro":false,"msg" : "Usuario '. $usu_  .' , ya esta registrado, ingrese uno distinto" }';
				return $RP;
			}
		}
		
		$RP = '{"registro":false,"msg" : "No se ha podido registrar" }';
		return $RP;
	}	
	public function detallesuario(Request $request){
		$id_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			$obj= Usuario::where([ ['id', '=',$id_ ] ] )->first();
			if (!empty($obj)) {
				$RP = '{"encontrado":true,"id" : "'. $obj->id .'","usuario" : "'. $obj->email .'",
						"nombre" : "'. $obj->name .'","url_imagen" :  "'. $obj->url_imagen .'",
						"tipo" :  "'. $obj->tipo .'" }';
				return $RP;
			}else{
				$RP = '{"encontrado":false }';
				return $RP;
			}	
		}	
	 }		
	
    /**
     * Display a listing of the Usuario.
     *
     * @param UsuarioDataTable $usuarioDataTable
     * @return Response
     */
    public function index(UsuarioDataTable $usuarioDataTable)
    {
        return $usuarioDataTable->render('usuarios.index');
    }

    /**
     * Show the form for creating a new Usuario.
     *
     * @return Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created Usuario in storage.
     *
     * @param CreateUsuarioRequest $request
     *
     * @return Response
     */
    public function store(CreateUsuarioRequest $request)
    {
        $input = $request->all();

        $usuario = $this->usuarioRepository->create($input);

        Flash::success('Usuario saved successfully.');

        return redirect(route('usuarios.index'));
    }

    /**
     * Display the specified Usuario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usuario = $this->usuarioRepository->findWithoutFail($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('usuarios.index'));
        }

        return view('usuarios.show')->with('usuario', $usuario);
    }

    /**
     * Show the form for editing the specified Usuario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usuario = $this->usuarioRepository->findWithoutFail($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('usuarios.index'));
        }

        return view('usuarios.edit')->with('usuario', $usuario);
    }

    /**
     * Update the specified Usuario in storage.
     *
     * @param  int              $id
     * @param UpdateUsuarioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsuarioRequest $request)
    {
        $usuario = $this->usuarioRepository->findWithoutFail($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('usuarios.index'));
        }

        $usuario = $this->usuarioRepository->update($request->all(), $id);

        Flash::success('Usuario updated successfully.');

        return redirect(route('usuarios.index'));
    }

    /**
     * Remove the specified Usuario from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usuario = $this->usuarioRepository->findWithoutFail($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('usuarios.index'));
        }

        $this->usuarioRepository->delete($id);

        Flash::success('Usuario deleted successfully.');

        return redirect(route('usuarios.index'));
    }
}
