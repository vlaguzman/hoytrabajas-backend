<?php

namespace App\Http\Controllers;

use App\DataTables\MembresiaCandidatoDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateMembresiaCandidatoRequest;
use App\Http\Requests\UpdateMembresiaCandidatoRequest;
use App\Repositories\MembresiaCandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Membresia;
use App\Models\MembresiaCandidato;
use App\Models\MembresiaPrecio;

class MembresiaCandidatoController extends AppBaseController
{
    /** @var  MembresiaCandidatoRepository */
    private $membresiaCandidatoRepository;

    public function __construct(MembresiaCandidatoRepository $membresiaCandidatoRepo)
    {
        $this->membresiaCandidatoRepository = $membresiaCandidatoRepo;
    }
	
	public function verificar(Request $request){
		$id_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			date_default_timezone_set('America/Bogota');
			$fecha_ = date("Y-m-d", time());
			$hora_=  date("H:i:s", time());
			$validar=$fecha_.$hora_;	
			$item= MembresiaCandidato::where([ ['candidato_id', '=',$id_ ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )->first();
			if (!empty($item)) {
				$segundos=strtotime($item->hasta) - strtotime('now');
                $vigencia=intval($segundos/60/60/24);
				$RP = '{"afiliado":true,"msg" : "'. $vigencia .'" }';
				return $RP;
			}else{
				$membresia=Membresia::where([ ['candidato', '=', 1] ] )->first();
			    $id_membresia=$membresia->id;
			    $item= MembresiaPrecio::where([ ['membresia_id', '=',$id_membresia ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )->first();
				$RP = '{"afiliado":false,"msg" : "'. $item->precio .'" }';
				return $RP;
			}	
		}	
	 }	
		
	public function registrar(Request $request){
		$id_ ="";
		$postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
			date_default_timezone_set('America/Bogota');
			$fecha_ = date("Y-m-d", time());
			$hora_=  date("H:i:s", time());
			$validar=$fecha_.$hora_;	
			$item= MembresiaCandidato::where([ ['candidato_id', '=',$id_ ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )->first();
			if (!empty($item)) {
				$segundos=strtotime($item->hasta) - strtotime('now');
                $vigencia=intval($segundos/60/60/24);
				$RP = '{"registro":false,"msg" : "Faltan "'. $vigencia .'" dias para vencer tu membresia" }';
				return $RP;
			}	
			$membresia=Membresia::where([ ['candidato', '=', 1] ]   )->first();
			$id_membresia=$membresia->id;
			$item= MembresiaPrecio::where([ ['membresia_id', '=',$id_membresia ],['desde', '<=',$validar ],['hasta', '>=',$validar ] ] )->first();
			$hora_=  date("H:i:s", time());
			$desde_ = date("Y-m-d", time())." ".$hora_;
			$fecha = date('Y-m-j')." ".$hora_ ;
			$nuevafecha = strtotime ( '+'. $item->duracion .' day' , strtotime ( $fecha ) ) ;
			$hasta_ = date ( 'Y-m-j' , $nuevafecha )." ".$hora_;
			$obj = MembresiaCandidato::create([
						'pagado' => $item->precio,
						'candidato_id' => intval($id_),
						'membresia_id' => intval($id_membresia),
						'desde' => $desde_,
						'hasta' => $hasta_,
			       ]);
			if(!empty($obj) ){
				$RP = '{"registro":true,"msg" : "Membresia registrada exitosamente!" }';
				return $RP;
			}else{
				$RP = '{"registro":false,"msg" : "No se pudo procesar la transaccion, intente mas tarde" }';
				return $RP;
			}
		}	
	 }	
		
    /**
     * Display a listing of the MembresiaCandidato.
     *
     * @param MembresiaCandidatoDataTable $membresiaCandidatoDataTable
     * @return Response
     */
    public function index(MembresiaCandidatoDataTable $membresiaCandidatoDataTable)
    {
        return $membresiaCandidatoDataTable->render('membresia_candidatos.index');
    }

    /**
     * Show the form for creating a new MembresiaCandidato.
     *
     * @return Response
     */
    public function create()
    {
        return view('membresia_candidatos.create');
    }

    /**
     * Store a newly created MembresiaCandidato in storage.
     *
     * @param CreateMembresiaCandidatoRequest $request
     *
     * @return Response
     */
    public function store(CreateMembresiaCandidatoRequest $request)
    {
        $input = $request->all();

        $membresiaCandidato = $this->membresiaCandidatoRepository->create($input);

        Flash::success('Membresia Candidato saved successfully.');

        return redirect(route('membresiaCandidatos.index'));
    }

    /**
     * Display the specified MembresiaCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $membresiaCandidato = $this->membresiaCandidatoRepository->findWithoutFail($id);

        if (empty($membresiaCandidato)) {
            Flash::error('Membresia Candidato not found');

            return redirect(route('membresiaCandidatos.index'));
        }

        return view('membresia_candidatos.show')->with('membresiaCandidato', $membresiaCandidato);
    }

    /**
     * Show the form for editing the specified MembresiaCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $membresiaCandidato = $this->membresiaCandidatoRepository->findWithoutFail($id);

        if (empty($membresiaCandidato)) {
            Flash::error('Membresia Candidato not found');

            return redirect(route('membresiaCandidatos.index'));
        }

        return view('membresia_candidatos.edit')->with('membresiaCandidato', $membresiaCandidato);
    }

    /**
     * Update the specified MembresiaCandidato in storage.
     *
     * @param  int              $id
     * @param UpdateMembresiaCandidatoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMembresiaCandidatoRequest $request)
    {
        $membresiaCandidato = $this->membresiaCandidatoRepository->findWithoutFail($id);

        if (empty($membresiaCandidato)) {
            Flash::error('Membresia Candidato not found');

            return redirect(route('membresiaCandidatos.index'));
        }

        $membresiaCandidato = $this->membresiaCandidatoRepository->update($request->all(), $id);

        Flash::success('Membresia Candidato updated successfully.');

        return redirect(route('membresiaCandidatos.index'));
    }

    /**
     * Remove the specified MembresiaCandidato from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $membresiaCandidato = $this->membresiaCandidatoRepository->findWithoutFail($id);

        if (empty($membresiaCandidato)) {
            Flash::error('Membresia Candidato not found');

            return redirect(route('membresiaCandidatos.index'));
        }

        $this->membresiaCandidatoRepository->delete($id);

        Flash::success('Membresia Candidato deleted successfully.');

        return redirect(route('membresiaCandidatos.index'));
    }
}
