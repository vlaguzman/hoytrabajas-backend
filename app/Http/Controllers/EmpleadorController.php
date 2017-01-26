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

class EmpleadorController extends AppBaseController
{
    /** @var  EmpleadorRepository */
    private $empleadorRepository;

    public function __construct(EmpleadorRepository $empleadorRepo)
    {
        $this->empleadorRepository = $empleadorRepo;
    }
	
	public function getempleador(){ 
		$id_ ="3";
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
	 
	 public function getdetalle(){ //detalle 
		$id_ ="3";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)){
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
		}	
		$item = DB::select( DB::raw("SELECT E.id,E.contacto,E.empresa,E.telefono,E.correo,E.ciudad_id,
                  U.url_imagen,E.descripcion,E.direccion,U.id as userid,C.descripcion as des_ciudad
                  FROM empleadores E,users U,ciudades C
                  WHERE E.id='". $id_ ."' and E.user_id=U.id and E.ciudad_id=C.id ") );
				  
		if(count($item)==0){
			 return Response::json( null );
		}else{
			$a1= json_decode(json_encode($item[0]), true); 
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
