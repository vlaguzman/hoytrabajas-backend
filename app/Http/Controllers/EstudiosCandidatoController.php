<?php

namespace App\Http\Controllers;

use App\DataTables\EstudiosCandidatoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEstudiosCandidatoRequest;
use App\Http\Requests\UpdateEstudiosCandidatoRequest;
use App\Repositories\EstudiosCandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EstudiosCandidatoController extends AppBaseController
{
    /** @var  EstudiosCandidatoRepository */
    private $estudiosCandidatoRepository;

    public function __construct(EstudiosCandidatoRepository $estudiosCandidatoRepo)
    {
        $this->estudiosCandidatoRepository = $estudiosCandidatoRepo;
    }

    /**
     * Display a listing of the EstudiosCandidato.
     *
     * @param EstudiosCandidatoDataTable $estudiosCandidatoDataTable
     * @return Response
     */
    public function index(EstudiosCandidatoDataTable $estudiosCandidatoDataTable)
    {
        return $estudiosCandidatoDataTable->render('estudios_candidatos.index');
    }

    /**
     * Show the form for creating a new EstudiosCandidato.
     *
     * @return Response
     */
    public function create()
    {
        return view('estudios_candidatos.create');
    }

    /**
     * Store a newly created EstudiosCandidato in storage.
     *
     * @param CreateEstudiosCandidatoRequest $request
     *
     * @return Response
     */
    public function store(CreateEstudiosCandidatoRequest $request)
    {
        $input = $request->all();

        $estudiosCandidato = $this->estudiosCandidatoRepository->create($input);

        Flash::success('Estudios Candidato saved successfully.');

        return redirect(route('estudiosCandidatos.index'));
    }

    /**
     * Display the specified EstudiosCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estudiosCandidato = $this->estudiosCandidatoRepository->findWithoutFail($id);

        if (empty($estudiosCandidato)) {
            Flash::error('Estudios Candidato not found');

            return redirect(route('estudiosCandidatos.index'));
        }

        return view('estudios_candidatos.show')->with('estudiosCandidato', $estudiosCandidato);
    }

    /**
     * Show the form for editing the specified EstudiosCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estudiosCandidato = $this->estudiosCandidatoRepository->findWithoutFail($id);

        if (empty($estudiosCandidato)) {
            Flash::error('Estudios Candidato not found');

            return redirect(route('estudiosCandidatos.index'));
        }

        return view('estudios_candidatos.edit')->with('estudiosCandidato', $estudiosCandidato);
    }

    /**
     * Update the specified EstudiosCandidato in storage.
     *
     * @param  int              $id
     * @param UpdateEstudiosCandidatoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstudiosCandidatoRequest $request)
    {
        $estudiosCandidato = $this->estudiosCandidatoRepository->findWithoutFail($id);

        if (empty($estudiosCandidato)) {
            Flash::error('Estudios Candidato not found');

            return redirect(route('estudiosCandidatos.index'));
        }

        $estudiosCandidato = $this->estudiosCandidatoRepository->update($request->all(), $id);

        Flash::success('Estudios Candidato updated successfully.');

        return redirect(route('estudiosCandidatos.index'));
    }

    /**
     * Remove the specified EstudiosCandidato from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estudiosCandidato = $this->estudiosCandidatoRepository->findWithoutFail($id);

        if (empty($estudiosCandidato)) {
            Flash::error('Estudios Candidato not found');

            return redirect(route('estudiosCandidatos.index'));
        }

        $this->estudiosCandidatoRepository->delete($id);

        Flash::success('Estudios Candidato deleted successfully.');

        return redirect(route('estudiosCandidatos.index'));
    }
}
