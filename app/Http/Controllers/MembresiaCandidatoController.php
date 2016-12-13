<?php

namespace App\Http\Controllers;

use App\DataTables\MembresiaCandidatoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMembresiaCandidatoRequest;
use App\Http\Requests\UpdateMembresiaCandidatoRequest;
use App\Repositories\MembresiaCandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MembresiaCandidatoController extends AppBaseController
{
    /** @var  MembresiaCandidatoRepository */
    private $membresiaCandidatoRepository;

    public function __construct(MembresiaCandidatoRepository $membresiaCandidatoRepo)
    {
        $this->membresiaCandidatoRepository = $membresiaCandidatoRepo;
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
