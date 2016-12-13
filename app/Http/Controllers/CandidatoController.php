<?php

namespace App\Http\Controllers;

use App\DataTables\CandidatoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCandidatoRequest;
use App\Http\Requests\UpdateCandidatoRequest;
use App\Repositories\CandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CandidatoController extends AppBaseController
{
    /** @var  CandidatoRepository */
    private $candidatoRepository;

    public function __construct(CandidatoRepository $candidatoRepo)
    {
        $this->candidatoRepository = $candidatoRepo;
    }
	
	public function listar(){
		   $lista = $this->candidatoRepository->all();
			return Response::json([
				  $lista
			], 200);
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
