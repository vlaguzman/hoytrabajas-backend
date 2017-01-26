<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Postulacion;
use App\Models\Candidato;
use Carbon\Carbon;

class User extends Authenticatable
{
     use Notifiable;
	  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','url_imagen','perfil_id','activo','push_token','origen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	public function routeNotificationForMail()
    {
        return $this->email;
    }
	public function getUsuario(){
		return Usuario::find(Auth::user()->id);
	}
	public function getId_detalle(){
		$p= Usuario::find(Auth::user()->id);
		if(Auth::user()->perfil_id == 0){
			return Auth::user()->id;
		}if(Auth::user()->perfil_id == 1){
			return $p->administradores()->first()->id;
		}if(Auth::user()->perfil_id == 2){
			return $p->empleadores()->first()->id;
        }if(Auth::user()->perfil_id == 3){
		    return $p->candidatos()->first()->id;
		}
	}

	public function getDes_Perfil(){
		$p= Usuario::find(Auth::user()->id);
		return $p->perfil()->first()->descripcion;
	}

  public function postulado($id_){
       $id_usr=Auth::user()->id;
       $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
       if($obj){
          $emp_ =$obj->id;
          $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ] ,['estatus_id', '=','1' ]  ] )->first();
          if (!empty($postulacion)) {
              return true;
          }
       }
       return false;
   }
   public function postulacionaceptado($id_){
      $id_usr=Auth::user()->id;
      $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
      if($obj){
          $emp_ =$obj->id;
          $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ],['estatus_id', '=','2' ]   ] )->first();
          if (!empty($postulacion)) {
              return true;
          }
       }
       return false;
    }
    public function postulacionrechazado($id_){
       $id_usr=Auth::user()->id;
       $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
       if($obj){
           $emp_ =$obj->id;
           $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ],['estatus_id', '=','3' ]   ] )->first();
           if (!empty($postulacion)) {
               return true;
           }
        }
        return false;
     }
  public function fechapostulado($id_){
      $id_usr=Auth::user()->id;
      $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
      if($obj){
          $emp_ =$obj->id;
          $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ],['estatus_id', '=','1' ]  ] )->first();
          if (!empty($postulacion)) {
              return $postulacion->created_at;
          }
      }
      return "";
  }

  public function fechapostuladolim($id_){
      $id_usr=Auth::user()->id;
      $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
      if($obj){
          $emp_ =$obj->id;
          $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ]   ] )->first();
          if (!empty($postulacion)) {
              $carbon = new Carbon($postulacion->created_at, 'America/Bogota');

              return $carbon->addDays(1);
          }
      }
      return "";
    }
    public function fechapostuladoprogreso($id_){
        $id_usr=Auth::user()->id;
        $obj=Candidato::where([ ['user_id', '=',$id_usr] ] )->first();
        if($obj){
            $emp_ =$obj->id;
            $postulacion=Postulacion::where([ ['oferta_id', '=', $id_ ],['candidato_id', '=',$emp_  ]   ] )->first();
            if (!empty($postulacion)) {
                $carbon = new Carbon($postulacion->created_at, 'America/Bogota');
                $carbon1 = $carbon->addDays(1);
                $carbon2 = Carbon::now('America/Bogota');
                $prog = $carbon1->diffInHours($carbon2);
                return $prog;
            }
        }
        return 0;
      }



      public function getFechaVence($fecha){
              $carbon = new Carbon($fecha, 'America/Bogota');
              $carbon1 = $carbon->addDays(1);
              return $carbon1;
      }
      public function getVenceHoras($fecha){
              $carbon = new Carbon($fecha, 'America/Bogota');
              $carbon1 = $carbon->addDays(1);
              $carbon2 = Carbon::now('America/Bogota');
              $prog = $carbon1->diffInHours($carbon2);
              return $prog;
      }



}
