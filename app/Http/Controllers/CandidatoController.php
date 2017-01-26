<?php

namespace App\Http\Controllers;

use App\DataTables\CandidatoDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCandidatoRequest;
use App\Http\Requests\UpdateCandidatoRequest;
use App\Repositories\CandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Candidato;

class CandidatoController extends AppBaseController
{
    /** @var  CandidatoRepository */
    private $candidatoRepository;

    public function __construct(CandidatoRepository $candidatoRepo)
    {
        $this->candidatoRepository = $candidatoRepo;
    }
	
	public function listar(){
		$nom_ ="%";
		$expe_="";
		$genero_="";
		$ciudad_="";
		$fnac_ ="";
		
		$sector_="";
		$idioma_="";
		$crits="";
		$parametros=array();
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->nom)) {
				$nom_ = $requestx->nom."%";
			}
			if (isset($requestx->ciudad)) {
				$ciudad_ = $requestx->ciudad;
				$parametros= array( array("ciudad_id","=", $ciudad_ ) );
			}
			if (isset($requestx->genero)) {
				$genero_ = $requestx->genero;
				$parametros= array( array("genero_id","=", $genero_ ) );
			}
			if (isset($requestx->expe)) {
				$expe_ = $requestx->expe;
				$parametros= array( array("experiencia",">=", $expe_ ) );
			}
			if (isset($requestx->fnac)) {
				$fnac_ = $requestx->fnac;
				$parametros= array( array("fnac",">=", $fnac_ ) );
			}
			if (isset($requestx->sector)) {
				$sector_ = $requestx->sector;
			}
			if (isset($requestx->idioma)) {
				$idioma_ = $requestx->idioma;
			}
		}
		$lista= Candidato::where([ ['nombres', 'like',$nom_  ] ] )
		       ->where($parametros)
		       ->orderBy('rate', 'desc')->get();
		
		if($lista){
			return Response::json(
		       [ 'lista' =>  $lista , 'encontro' =>  true ]
		    );
		}else{
			return Response::json([ 'encontro' => false ]);
		}
		
     }
	 public function getcandidatoa(){ //detalle 
		$id_ ="0";
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
		$item= Candidato::where([ ['id', '=',$id_ ] ] )->first();
		return Response::json(  $item );
     }
	 public function getcandidatodetalle(){ //detalle 
		$id_ ="0";
	    $postdata = file_get_contents("php://input");
		if (isset($postdata)) {
			$requestx = json_decode($postdata);
			if (isset($requestx->id)) {
				$id_ = $requestx->id;
			}
		}	
		//$item= Candidato::where([ ['id', '=',$id_ ]] )->first();
		
		$item = DB::select( DB::raw("SELECT E.id,E.nombres as nombre,E.apellidos as apellido,E.nombres,E.apellidos,  
		          E.fnac,E.genero_id,U.url_imagen,E.telefono,E.correo,E.descripcion,E.descripcion as des,E.experiencia,E.rate as expe,U.id as userid,
				  G.descripcion as des_genero
                  FROM candidatos E,users U,generos G
                  WHERE E.id='". $id_ ."' and E.user_id=U.id and E.genero_id=G.id ") );
		
		return Response::json( $item );
     }


	 
    /**
     * Display a listing of the Candidato.
     *
     * @param CandidatoDataTable $candidatoDataTable
     * @return Response
     */
    public function index(CandidatoDataTable $candidatoDataTable)
    {
        return $candidatoDataTable->render('candidatos.index');
    }

    /**
     * Show the form for creating a new Candidato.
     *
     * @return Response
     */
    public function create()
    {
        return view('candidatos.create');
    }

    /**
     * Store a newly created Candidato in storage.
     *
     * @param CreateCandidatoRequest $request
     *
     * @return Response
     */
    public function store(CreateCandidatoRequest $request)
    {
        $input = $request->all();

        $candidato = $this->candidatoRepository->create($input);

        Flash::success('Candidato saved successfully.');

        return redirect(route('candidatos.index'));
    }

    /**
     * Display the specified Candidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $candidato = $this->candidatoRepository->findWithoutFail($id);

        if (empty($candidato)) {
            Flash::error('Candidato not found');

            return redirect(route('candidatos.index'));
        }

        return view('candidatos.show')->with('candidato', $candidato);
    }

    /**
     * Show the form for editing the specified Candidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $candidato = $this->candidatoRepository->findWithoutFail($id);

        if (empty($candidato)) {
            Flash::error('Candidato not found');

            return redirect(route('candidatos.index'));
        }

        return view('candidatos.edit')->with('candidato', $candidato);
    }

    /**
     * Update the specified Candidato in storage.
     *
     * @param  int              $id
     * @param UpdateCandidatoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCandidatoRequest $request)
    {
        $candidato = $this->candidatoRepository->findWithoutFail($id);

        if (empty($candidato)) {
            Flash::error('Candidato not found');

            return redirect(route('candidatos.index'));
        }

        $candidato = $this->candidatoRepository->update($request->all(), $id);

        Flash::success('Candidato updated successfully.');

        return redirect(route('candidatos.index'));
    }

    /**
     * Remove the specified Candidato from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $candidato = $this->candidatoRepository->findWithoutFail($id);

        if (empty($candidato)) {
            Flash::error('Candidato not found');

            return redirect(route('candidatos.index'));
        }

        $this->candidatoRepository->delete($id);

        Flash::success('Candidato deleted successfully.');

        return redirect(route('candidatos.index'));
    }
}
