<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DataTables\MensajesDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateMensajesRequest;
use App\Http\Requests\UpdateMensajesRequest;
use App\Repositories\MensajesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Mensajes;


class MensajesController extends AppBaseController
{
    /** @var  MensajesRepository */
    private $mensajesRepository;

    public function __construct(MensajesRepository $mensajesRepo)
    {
        $this->mensajesRepository = $mensajesRepo;
    }
	public function listar(){
		$de_ ="";
		$para_ ="";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->de)) {
				$de_  = $requestx->de;
			}
			if (isset($requestx->para)) {
				$para_  = $requestx->para;
			}
		}
		/*date_default_timezone_set('America/Bogota');
	    $fecha_ = date("Y-m-d", time());
		$hora_=  date("H:i:s", time());
		$validar=$fecha_.$hora_;*/
		$lista="";
		$lista = DB::select( DB::raw("SELECT M.id as _id,M.mensaje as text,M.deuser_id as user_id,M.created_at as date,
					M.leido as readww,M.updated_at as readDate
					FROM mensajes M
		            WHERE M.parauser_id='". $para_  ."' and M.deuser_id='". $de_  ."'  ") );	
			
        $RP = '{ "messages" : '. json_encode($lista)  .',"unread":0 }';	
		return 	$RP;
     }
	 public function registrar(Request $request){
		$de_ ="";
		$para_ ="";
		$msg_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->de)) {
				$de_ = $requestx->de;
			}
			if (isset($requestx->para)) {
				$para_  = $requestx->para;
			}
			if (isset($requestx->msg)) {
				$msg_  = $requestx->msg;
			}
			$obj = Mensajes::create([
						'deuser_id' => intval($de_),
						'parauser_id' => intval($para_),
						'mensaje' => $msg_,
						'recivido'=> 0,
						'leido'=> 0,
			       ]);
			if($obj){
				$RP = '{"registro":true }';
				return $RP;
			}else{
				$RP = '{"registro":false }';
				return $RP;
			}
		}	
	 }	

    /**
     * Display a listing of the Mensajes.
     * 
     * @param MensajesDataTable $mensajesDataTable
     * @return Response
     */
    public function index(MensajesDataTable $mensajesDataTable)
    {
        return $mensajesDataTable->render('mensajes.index');
    }

    /**
     * Show the form for creating a new Mensajes.
     *
     * @return Response
     */
    public function create()
    {
        return view('mensajes.create');
    }

    /**
     * Store a newly created Mensajes in storage.
     *
     * @param CreateMensajesRequest $request
     *
     * @return Response
     */
    public function store(CreateMensajesRequest $request)
    {
        $input = $request->all();

        $mensajes = $this->mensajesRepository->create($input);

        Flash::success('Mensajes saved successfully.');

        return redirect(route('mensajes.index'));
    }

    /**
     * Display the specified Mensajes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        return view('mensajes.show')->with('mensajes', $mensajes);
    }

    /**
     * Show the form for editing the specified Mensajes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        return view('mensajes.edit')->with('mensajes', $mensajes);
    }

    /**
     * Update the specified Mensajes in storage.
     *
     * @param  int              $id
     * @param UpdateMensajesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMensajesRequest $request)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        $mensajes = $this->mensajesRepository->update($request->all(), $id);

        Flash::success('Mensajes updated successfully.');

        return redirect(route('mensajes.index'));
    }

    /**
     * Remove the specified Mensajes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        $this->mensajesRepository->delete($id);

        Flash::success('Mensajes deleted successfully.');

        return redirect(route('mensajes.index'));
    }
}
