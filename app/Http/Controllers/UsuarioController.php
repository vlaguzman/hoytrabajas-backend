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
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Response;
use App\User;
use App\SocialAccount;
use App\Models\Empleador;
use App\Models\Candidato;
use App\Models\Usuario;
use App\Models\Estudio;
use App\Models\SectorCandidato;
use App\Models\IdiomaCandidato;
use App\Models\EstudioCandidato;
			

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
		   $tp_=$usuario->perfil_id;
		   $url_imagen=$usuario->url_imagen;
		   if($tp_=="1"){ //para administradores
			   
		   }else if($tp_=="2"){//para empleadores
			   $obj=Empleador::where([ ['user_id', '=', $id_] ] )->first();
			   $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '", 
				  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $url_imagen . '",
				  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
				  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
				  "rol":"2" }'; 
		   }else if ($tp_=="3"){ //para usuarios
		       $obj=Candidato::where([ ['user_id', '=', $id_] ] )->first();
		       $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","empresa":"N/A", 
				  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $url_imagen . '",
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
	 public function login_byemail(Request $request){
		$usu_="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->usuario)) {
				$usu_ = $requestx->usuario;
			}
		}
		$usuario=Usuario::where([ ['email', '=', $usu_] ] )->first();
		if ($usuario){
		   $RP = '{"login":false}';
		   $id_=$usuario->id;
		   $tp_=$usuario->perfil_id;
		   $url_imagen=$usuario->url_imagen;
		   if($tp_=="0"){ //para registro inicial con redes sociales
			   $RP = '{"login":true,"usuario_id":"'. $id_ . '", 
				  "nombres":"'. $usuario->name . '","imagen":"'. $url_imagen . '",
				  "rol":"0" }'; 
		   }else if($tp_=="1"){ //para administradores
			   
		   }else if($tp_=="2"){//para empleadores
			   $obj=Empleador::where([ ['user_id', '=', $id_] ] )->first();
			   $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '", 
				  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $url_imagen . '",
				  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
				  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
				  "rol":"2" }'; 
		   }else if ($tp_=="3"){ //para usuarios
		       $obj=Candidato::where([ ['user_id', '=', $id_] ] )->first();
		       $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","empresa":"N/A", 
				  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $url_imagen . '",
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
		
    public function registrarrs(Request $request){
		$RP = '{"login":false}';
		$pid_="";
		$prov_="";
		$pavatar_="";
		$usu_="";
		$nombre_ ="";
		$url_imagen_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->pid)) {
				$pid_ = $requestx->pid;
			}
			if (isset($requestx->prov)) {
				$prov_ = $requestx->prov;
			}
			if (isset($requestx->avatar)) {
				$pavatar_ = $requestx->avatar;
			}
			if (isset($requestx->usu)) {
				$usu_ = $requestx->usu;
			}
			if (isset($requestx->nombre)) {
				$nombre_  = $requestx->nombre;
			}
			$user = User::whereEmail( $usu_ )->first();
			if(!$user){
				
				$obj =  User::create([
					'name' => $nombre_,
					'email' => $usu_,
					'password' => '',
					'perfil_id' => 0,
					'activo' =>1,
					'push_token'=>'',
					'origen'=>'mobil',
					'url_imagen' => asset('/images/system_imgs/no-picture.jpg'),
				 ]);
				if($obj){
					$id_usr=$obj->id;
					$account = SocialAccount::whereProvider($prov_)->whereProviderUserId($pid_)->first();
					if (!$account) {
						$account = SocialAccount::create([
							'provider_user_id' => $pid_,
							'provider' => $prov_,
							'user_id'=> $id_usr
						]);
					}
					
					if($prov_=='facebook' )
					   $url_imagen_='https://graph.facebook.com/'. $pid_ .'/picture?type=large';
				    else 
					   $url_imagen_ = preg_replace('/\?sz=[\d]*$/', '', $pavatar_);	
				  
					$url_perfil= $this->guardar_imagen($id_usr,$url_imagen_);
					$user =User::where([ ['id', '=', $id_usr ] ] )->first();  
					if($user){
						$user->url_imagen= $url_perfil;
						$user->save();
					}
				}					
			}else{
				$id_usr=$user->id;
				if($prov_=='facebook' )
				   $url_imagen_='https://graph.facebook.com/'. $pid_ .'/picture?type=large';
				else 
				   $url_imagen_ = preg_replace('/\?sz=[\d]*$/', '', $pavatar_);
			   
				$url_perfil= $this->guardar_imagen($id_usr,$url_imagen_);
				
				$user->url_imagen= $url_perfil;
				$user->save();
			}
			$usuario=Usuario::where([ ['email', '=', $usu_] ] )->first();
			if ($usuario){
				   $id_=$usuario->id;
				   $tp_=$usuario->perfil_id;
				   $url_imagen=$usuario->url_imagen;
				   if($tp_=="0"){ //para registro inicial con redes sociales
					   $RP = '{"login":true,"usuario_id":"'. $id_ . '","usuario":"'. $usu_ . '",
						  "nombres":"'. $usuario->name . '","imagen":"'. $url_imagen . '",
						  "rol":"0" }'; 
				   }else if($tp_=="1"){ //para administradores
					   
				   }else if($tp_=="2"){//para empleadores
					   $obj=Empleador::where([ ['user_id', '=', $id_] ] )->first();
					   $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id .'","usuario":"'. $usu_ . '",
						  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $url_imagen . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
						  "rol":"2" }'; 
				   }else if ($tp_=="3"){ //para usuarios
					   $obj=Candidato::where([ ['user_id', '=', $id_] ] )->first();
					   $RP = '{"login":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","empresa":"N/A","usuario":"'. $usu_ . '",
						  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $url_imagen . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '","fnac":"'. $obj->fnac . '",
						  "experiencia":"'. $obj->experiencia . '","genero_id":"'. $obj->genero_id . '","calificacion":"'. $obj->rate .'",
						  "rol": "3" }'; 
				   } 
				   return $RP;
            }
		}
		return $RP;
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
			if(!$user){
				$obj =  User::create([
					'name' => $nombre_,
					'email' => $usu_,
					'password' => bcrypt($psw_),
					'perfil_id' => 2,
					'activo' =>1,
					'push_token'=>'',
					'origen'=>'mobil',
					'url_imagen' => asset('/images/system_imgs/no-picture.jpg'),
				 ]);
				$id_usr=$obj->id;
				$obj = Empleador::create([
							'contacto' => $nombre_,
							'empresa' => $empresa_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'ciudad_id' => intval($ciudad_id_),
							'user_id' => intval($id_usr),
				]);
				if($obj){
					$url_perfil= $this->guardar_imagen($id_usr,$url_imagen_);
				    $user =User::where([ ['id', '=', $id_usr ] ] )->first();
					if($user){
						$user->url_imagen= $url_perfil;
                        $user->save();
						//Mail::to($user->email)->send(new WelcomeMail($user));
					}
					//$obj=Empleador::where([ ['user_id', '=', $id_] ] )->first();
					//$RP = '{"registro":true,"msg" : "Empresa '. $empresa_ .', registrada exitosamente!" }';
					$RP = '{"registro":true,"usuario_id":"'. $id_usr . '","obj_id":"'. $obj->id . '", 
						  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $url_perfil . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
						  "rol":"2","msg" : "Empresa '. $empresa_ .', registrada exitosamente!" }'; 
					
					
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
	
	public function registrar2rs(Request $request){
		$id_="";
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
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
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
			
			$usuario=Usuario::where([ ['id', '=', $id_] ] )->first();
			if ($usuario){
				$usuario->password=bcrypt($psw_);
				$usuario->perfil_id=2;
				$usuario->save();
				$obj = Empleador::create([
							'contacto' => $nombre_,
							'empresa' => $empresa_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'ciudad_id' => intval($ciudad_id_),
							'user_id' => intval($id_),
				]);
				if($obj){
				    $user =User::where([ ['id', '=', $id_ ] ] )->first();
					if($user){
					   //Mail::to($user->email)->send(new WelcomeMail($user));
					}
					$RP = '{"registro":true,"usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","usuario":"'. $usuario->email  . '",  
						  "nombres":"'. $obj->contacto . '","empresa":"'. $obj->empresa . '","imagen":"'. $usuario->url_imagen . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '",
						  "rol":"2","msg" : "Empresa '. $empresa_ .', confirmada exitosamente!" }'; 
					//$RP = '{"registro":true,"msg" : "Empresa '. $empresa_ .', confirmada exitosamente!" }';
					return $RP;
				}else{
					$RP = '{"registro":false,"msg" : "No se pudo procesar el registro, intente mas tarde" }';
					return $RP;
				}
			}
		}
		$RP = '{"registro":false,"msg" : "No se ha podido registrar" }';
		return $RP;
	}
	
	
	public function registrar3(Request $request){
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
			$ciudad_id_ = "1";
			if(!$user){
				$obj =  User::create([
					'name' => $nombre_,
					'email' => $usu_,
					'password' => bcrypt($psw_),
					'activo' =>1,
					'push_token'=>'',
					'perfil_id' => 3,
					'origen'=>'mobil',
					'url_imagen' => asset('/images/system_imgs/no-picture.jpg'),
				 ]);
				$id_usr=$obj->id;
				$obj = Candidato::create([
							'nombres' => $nombre_,
							'apellidos' => $apellido_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'fnac' => date("Y-m-d", strtotime( $fnac_  )),
							'experiencia' => intval($expe_),
							'rate' => intval($rate_),
							'ciudad_id' => intval($ciudad_id_),
							'genero_id' => intval($genero_),
							'user_id' => intval($id_usr),
				]);
				
				if($obj){
					$id_candidato=$obj->id;
					/*foreach( $sectores_ as $selected_id ){
						  SectorCandidato::create([
							   'candidato_id' => $id_candidato,
							   'sector_id' => $selected_id,
						  ]);
                    }
					foreach( $idiomas_ as $selected_id){
                      IdiomaCandidato::create([
                           'candidato_id' => $id_candidato,
                           'idioma_id' => $selected_id,
                      ]);
                    }*/
				    $estudio_nv=$estudios_;
					$obj_e  = Estudio::where([ ['descripcion', '=', $estudio_nv ] ] )->first();
					$id_estu="0";
					if($obj_e ){
						  $id_estu=$obj_e->id;
					}else{
						  $obj_e= Estudio::create([
							   'descripcion' => $estudio_nv
						   ]);
						  $id_estu=$obj_e->id;
					}
					EstudioCandidato::create([
						'candidato_id' => $id_candidato,
						'estudio_id' => $id_estu,
					]);
					//if($url_imagen_!=""){
						$url_perfil= $this->guardar_imagen($id_usr,$url_imagen_);
						$user =User::where([ ['id', '=', $id_usr ] ] )->first();
						if($user){
							 $user->url_imagen= $url_perfil;
                             $user->save();
							// Mail::to($user->email)->send(new WelcomeMail($user));
						}
					//}
					$obj=Candidato::where([ ['id', '=', $id_candidato] ] )->first();
					$RP = '{"registro":true,"id" : "'. $id_candidato .'","msg" : "Usuario '. $nombre_ .', registrada exitosamente!",
					      "usuario_id":"'. $id_usr . '","obj_id":"'. $obj->id . '","empresa":"N/A","usuario":"'. $usu_ .'", 
						  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $url_perfil . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '","fnac":"'. $obj->fnac . '",
						  "experiencia":"'. $obj->experiencia . '","genero_id":"'. $obj->genero_id . '","calificacion":"'. $obj->rate .'",
						  "rol": "3" }'; 
					//$RP = '{"registro":true, "id" : "'. $id_candidato .'" ,"msg" : "Usuario '. $nombre_ .', registrada exitosamente!" }';
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
    
	public function registrar3rs(Request $request){
		$id_="";
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
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
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
			$ciudad_id_ = "1";
			$usuario=Usuario::where([ ['id', '=', $id_] ] )->first();
			if ($usuario){
				$usuario->password=bcrypt($psw_);
				$usuario->perfil_id=3;
				$usuario->save();
				$obj = Candidato::create([
							'nombres' => $nombre_,
							'apellidos' => $apellido_,
							'telefono' => $telefono_,
							'correo' => $usu_,
							'descripcion' => $descripcion_ ,
							'direccion' => $direccion_,
							'fnac' => date("Y-m-d", strtotime( $fnac_  )),
							'experiencia' => intval($expe_),
							'rate' => intval($rate_),
							'ciudad_id' => intval($ciudad_id_),
							'genero_id' => intval($genero_),
							'user_id' => intval($id_),
				]);
				
				if($obj){
					$id_candidato=$obj->id;
					/*foreach( $sectores_ as $selected_id ){
						  SectorCandidato::create([
							   'candidato_id' => $id_candidato,
							   'sector_id' => $selected_id,
						  ]);
                    }
					foreach( $idiomas_ as $selected_id){
                      IdiomaCandidato::create([
                           'candidato_id' => $id_candidato,
                           'idioma_id' => $selected_id,
                      ]);
                    }*/
				    $estudio_nv=$estudios_;
					$obj_e  = Estudio::where([ ['descripcion', '=', $estudio_nv ] ] )->first();
					$id_estu="0";
					if($obj_e ){
						  $id_estu=$obj_e->id;
					}else{
						  $obj_e= Estudio::create([
							   'descripcion' => $estudio_nv
						   ]);
						  $id_estu=$obj_e->id;
					}
					EstudioCandidato::create([
						'candidato_id' => $id_candidato,
						'estudio_id' => $id_estu,
					]);

					$user =User::where([ ['id', '=', $id_ ] ] )->first();
					if($user){
					   // Mail::to($user->email)->send(new WelcomeMail($user));
					}
					$obj=Candidato::where([ ['id', '=', $id_candidato] ] )->first();
					$RP = '{"registro":true,"id" : "'. $id_candidato .'","msg" : "Usuario '. $nombre_ .', confirmado exitosamente!",
					      "usuario_id":"'. $id_ . '","obj_id":"'. $obj->id . '","empresa":"N/A","usuario":"'. $usuario->email .'", 
						  "nombres":"'. $obj->nombres . '","apellidos":"'. $obj->apellidos . '","imagen":"'. $usuario->url_imagen . '",
						  "telefono":"'. $obj->telefono . '","correo":"'. $obj->correo . '","descripcion":"'. $obj->descripcion . '",
						  "direccion":"'. $obj->direccion . '","ciudad_id":"'. $obj->ciudad_id . '","fnac":"'. $obj->fnac . '",
						  "experiencia":"'. $obj->experiencia . '","genero_id":"'. $obj->genero_id . '","calificacion":"'. $obj->rate .'",
						  "rol": "3" }'; 
					//$RP = '{"registro":true, "id" : "'. $id_candidato .'" ,"msg" : "Usuario '. $nombre_ .', registrada exitosamente!" }';
					return $RP;
				}else{
					$RP = '{"registro":false,"msg" : "No se pudo procesar el registro, intente mas tarde" }';
					return $RP;
				}
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
