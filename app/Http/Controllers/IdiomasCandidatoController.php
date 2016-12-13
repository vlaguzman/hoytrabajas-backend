<?php

namespace App\Http\Controllers;

use App\DataTables\IdiomasCandidatoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateIdiomasCandidatoRequest;
use App\Http\Requests\UpdateIdiomasCandidatoRequest;
use App\Repositories\IdiomasCandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class IdiomasCandidatoController extends AppBaseController
{
    /** @var  IdiomasCandidatoRepository */
    private $idiomasCandidatoRepository;

    public function __construct(IdiomasCandidatoRepository $idiomasCandidatoRepo)
    {
        $this->idiomasCandidatoRepository = $idiomasCandidatoRepo;
    }

    /**
     * Display a listing of the IdiomasCandidato.
     *
     * @param IdiomasCandidatoDataTable $idiomasCandidatoDataTable
     * @return Response
     */
    public function index(IdiomasCandidatoDataTable $idiomasCandidatoDataTable)
    {
        return $idiomasCandidatoDataTable->render('idiomas_candidatos.index');
    }

    /**
     * Show the form for creating a new IdiomasCandidato.
     *
     * @return Response
     */
    public function create()
    {
        return view('idiomas_candidatos.create');
    }

    /**
     * Store a newly created IdiomasCandidato in storage.
     *
     * @param CreateIdiomasCandidatoRequest $request
     *
     * @return Response
     */
    public function store(CreateIdiomasCandidatoRequest $request)
    {
        $input = $request->all();

        $idiomasCandidato = $this->idiomasCandidatoRepository->create($input);

        Flash::success('Idiomas Candidato saved successfully.');

        return redirect(route('idiomasCandidatos.index'));
    }

    /**
     * Display the specified IdiomasCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $idiomasCandidato = $this->idiomasCandidatoRepository->findWithoutFail($id);

        if (empty($idiomasCandidato)) {
            Flash::error('Idiomas Candidato not found');

            return redirect(route('idiomasCandidatos.index'));
        }

        return view('idiomas_candidatos.show')->with('idiomasCandidato', $idiomasCandidato);
    }

    /**
     * Show the form for editing the specified IdiomasCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $idiomasCandidato = $this->idiomasCandidatoRepository->findWithoutFail($id);

        if (empty($idiomasCandidato)) {
            Flash::error('Idiomas Candidato not found');

            return redirect(route('idiomasCandidatos.index'));
        }

        return view('idiomas_candidatos.edit')->with('idiomasCandidato', $idiomasCandidato);
    }

    /**
     * Update the specified IdiomasCandidato in storage.
     *
     * @param  int              $id
     * @param UpdateIdiomasCandidatoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIdiomasCandidatoRequest $request)
    {
        $idiomasCandidato = $this->idiomasCandidatoRepository->findWithoutFail($id);

        if (empty($idiomasCandidato)) {
            Flash::error('Idiomas Candidato not found');

            return redirect(route('idiomasCandidatos.index'));
        }

        $idiomasCandidato = $this->idiomasCandidatoRepository->update($request->all(), $id);

        Flash::success('Idiomas Candidato updated successfully.');

        return redirect(route('idiomasCandidatos.index'));
    }

    /**
     * Remove the specified IdiomasCandidato from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $idiomasCandidato = $this->idiomasCandidatoRepository->findWithoutFail($id);

        if (empty($idiomasCandidato)) {
            Flash::error('Idiomas Candidato not found');

            return redirect(route('idiomasCandidatos.index'));
        }

        $this->idiomasCandidatoRepository->delete($id);

        Flash::success('Idiomas Candidato deleted successfully.');

        return redirect(route('idiomasCandidatos.index'));
    }
}
