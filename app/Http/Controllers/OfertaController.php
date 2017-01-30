<?php

namespace App\Http\Controllers;

use App\DataTables\OfertaDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;


use App\Http\Requests\CreateOfertaRequest;
use App\Http\Requests\UpdateOfertaRequest;
use App\Repositories\OfertaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Oferta;


class OfertaController extends AppBaseController
{
    /** @var  OfertaRepository */
    private $ofertaRepository;

    public function __construct(OfertaRepository $ofertaRepo)
    {
        $this->ofertaRepository = $ofertaRepo;
    }
	
	public function listara(){//ofertas activas
		$prop_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->propietario)) {
				$prop_ = $requestx->propietario;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		if($prop_ !=""){
			$lista= Oferta::where([ ['empleador_id', '=',$prop_ ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )
		      ->orderBy('created_at', 'desc')->get();
		}else{
			$lista= Oferta::where([ ['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )
		      ->orderBy('created_at', 'desc')->get();
		}
		return Response::json(
		    [ 'posts' =>  $lista ]
		);
     }
	 public function listarb(){ //ofertas vencidas
	    $prop_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->propietario)) {
				$prop_ = $requestx->propietario;
			}
		}
		date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time())  ;
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;
		$lista="";
		if($prop_ !=""){
			$lista= Oferta::where([ ['empleador_id', '=',$prop_ ], ['hasta', '<=',$validar ] ] )
				->orderBy('created_at', 'desc')->get();
		}else{
			$lista= Oferta::where([ ['hasta', '<=',$validar ] ] )
				->orderBy('created_at', 'desc')->get();
		}		
		return Response::json([ 'posts' =>  $lista ]);
     }
	 public function getofertaa(){ //detalle oferta
		$id_ ="23";
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
		$item= Oferta::where([ ['id', '=',$id_ ] ] )->first();
		
		return Response::json([ 'post' =>  $item ]);
     }
	 
	 public function registrar(Request $request){
		$emp_ ="";
		$nom_ ="";
		$des_ ="";
		$apag_  ="0";
		$descripcion_ ="";
		$direccion_ ="";
		$ciudad_id_ ="1";
		$sector_ ="1";
		$url_imagen_ ="";
		$lat_="0";
		$lng_="0";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->empleador)) {
				$emp_ = $requestx->empleador;
			}
			if (isset($requestx->nom)) {
				$nom_ = $requestx->nom;
			}
			if (isset($requestx->des)) {
				$des_ = $requestx->des;
			}
			if (isset($requestx->apagar)) {
				$apag_ = $requestx->apagar;
			}
			if (isset($requestx->ciudad_id)) {
				$ciudad_id_  = $requestx->ciudad_id;
			}
			if (isset($requestx->sector)) {
				$sector_ = $requestx->sector;
			}
			if (isset($requestx->dire)) {
				$direccion_ = $requestx->dire;
			}
			if (isset($requestx->imagen)) {
				$url_imagen_ = $requestx->imagen;
			}
			date_default_timezone_set('America/Bogota');
			$hora_=  date("H:i:s", time());
			$desde_ = date("Y-m-d", time())." ".$hora_;
			$fecha = date('Y-m-j')." ".$hora_ ;
			$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
			$hasta_ = date ( 'Y-m-j' , $nuevafecha )." ".$hora_;
			
			$obj = Oferta::create([
						'desde' => date("Y-m-d H:i:s", strtotime( $desde_ )),
						'hasta' => date("Y-m-d H:i:s", strtotime( $hasta_ )),
						'nombre' => $nom_,
						'descripcion' => $des_ ,
						'paga' => $apag_,
						'direccion' => $direccion_,
						'lat' => $lat_,
						'lng' => $lng_,
						'url_imagen' => asset('/images/system_imgs/ofertadef.png'),
						'sector_id' => intval($sector_),
						'ciudad_id' => intval($ciudad_id_),
						'empleador_id' => intval($emp_),
			    ]);
			if($obj){
			    $id_=$obj->id;
				$obj->url_imagen=$this->guardar_imagen($id_,$url_imagen_);
				$obj->save();
				$RP = '{"registro":true,"msg" : "Oferta registrada exitosamente!" }';
				return $RP;
			}else{
				$RP = '{"registro":false,"msg" : "No se pudo procesar el registro, intente mas tarde" }';
				return $RP;
			}
		}	
	 }	
	
		
	private function guardar_imagen($id,$url){
		$file=asset('/images/system_imgs/ofertadef.png');
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
			$img_local='/images/system_imgs/ofertas/ioferta_' . $id .'.jpg';
			$file =public_path().$img_local;
			file_put_contents($file, $img);
			$file =asset($img_local);
		}
		return $file;
	}
	
    /**
     * Display a listing of the Oferta.
     *
     * @param OfertaDataTable $ofertaDataTable
     * @return Response
     */
    public function index(OfertaDataTable $ofertaDataTable)
    {
        return $ofertaDataTable->render('ofertas.index');
    }

    /**
     * Show the form for creating a new Oferta.
     *
     * @return Response
     */
    public function create()
    {
        return view('ofertas.create');
    }

    /**
     * Store a newly created Oferta in storage.
     *
     * @param CreateOfertaRequest $request
     *
     * @return Response
     */
    public function store(CreateOfertaRequest $request)
    {
        $input = $request->all();

        $oferta = $this->ofertaRepository->create($input);

        Flash::success('Oferta saved successfully.');

        return redirect(route('ofertas.index'));
    }

    /**
     * Display the specified Oferta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $oferta = $this->ofertaRepository->findWithoutFail($id);

        if (empty($oferta)) {
            Flash::error('Oferta not found');

            return redirect(route('ofertas.index'));
        }

        return view('ofertas.show')->with('oferta', $oferta);
    }

    /**
     * Show the form for editing the specified Oferta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $oferta = $this->ofertaRepository->findWithoutFail($id);

        if (empty($oferta)) {
            Flash::error('Oferta not found');

            return redirect(route('ofertas.index'));
        }

        return view('ofertas.edit')->with('oferta', $oferta);
    }

    /**
     * Update the specified Oferta in storage.
     *
     * @param  int              $id
     * @param UpdateOfertaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOfertaRequest $request)
    {
        $oferta = $this->ofertaRepository->findWithoutFail($id);

        if (empty($oferta)) {
            Flash::error('Oferta not found');

            return redirect(route('ofertas.index'));
        }

        $oferta = $this->ofertaRepository->update($request->all(), $id);

        Flash::success('Oferta updated successfully.');

        return redirect(route('ofertas.index'));
    }

    /**
     * Remove the specified Oferta from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $oferta = $this->ofertaRepository->findWithoutFail($id);

        if (empty($oferta)) {
            Flash::error('Oferta not found');

            return redirect(route('ofertas.index'));
        }

        $this->ofertaRepository->delete($id);

        Flash::success('Oferta deleted successfully.');

        return redirect(route('ofertas.index'));
    }
}
