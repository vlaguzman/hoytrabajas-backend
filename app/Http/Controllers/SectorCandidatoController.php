<?php

namespace App\Http\Controllers;

use App\DataTables\SectorCandidatoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSectorCandidatoRequest;
use App\Http\Requests\UpdateSectorCandidatoRequest;
use App\Repositories\SectorCandidatoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SectorCandidatoController extends AppBaseController
{
    /** @var  SectorCandidatoRepository */
    private $sectorCandidatoRepository;

    public function __construct(SectorCandidatoRepository $sectorCandidatoRepo)
    {
        $this->sectorCandidatoRepository = $sectorCandidatoRepo;
    }

    /**
     * Display a listing of the SectorCandidato.
     *
     * @param SectorCandidatoDataTable $sectorCandidatoDataTable
     * @return Response
     */
    public function index(SectorCandidatoDataTable $sectorCandidatoDataTable)
    {
        return $sectorCandidatoDataTable->render('sector_candidatos.index');
    }

    /**
     * Show the form for creating a new SectorCandidato.
     *
     * @return Response
     */
    public function create()
    {
        return view('sector_candidatos.create');
    }

    /**
     * Store a newly created SectorCandidato in storage.
     *
     * @param CreateSectorCandidatoRequest $request
     *
     * @return Response
     */
    public function store(CreateSectorCandidatoRequest $request)
    {
        $input = $request->all();

        $sectorCandidato = $this->sectorCandidatoRepository->create($input);

        Flash::success('Sector Candidato saved successfully.');

        return redirect(route('sectorCandidatos.index'));
    }

    /**
     * Display the specified SectorCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sectorCandidato = $this->sectorCandidatoRepository->findWithoutFail($id);

        if (empty($sectorCandidato)) {
            Flash::error('Sector Candidato not found');

            return redirect(route('sectorCandidatos.index'));
        }

        return view('sector_candidatos.show')->with('sectorCandidato', $sectorCandidato);
    }

    /**
     * Show the form for editing the specified SectorCandidato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sectorCandidato = $this->sectorCandidatoRepository->findWithoutFail($id);

        if (empty($sectorCandidato)) {
            Flash::error('Sector Candidato not found');

            return redirect(route('sectorCandidatos.index'));
        }

        return view('sector_candidatos.edit')->with('sectorCandidato', $sectorCandidato);
    }

    /**
     * Update the specified SectorCandidato in storage.
     *
     * @param  int              $id
     * @param UpdateSectorCandidatoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSectorCandidatoRequest $request)
    {
        $sectorCandidato = $this->sectorCandidatoRepository->findWithoutFail($id);

        if (empty($sectorCandidato)) {
            Flash::error('Sector Candidato not found');

            return redirect(route('sectorCandidatos.index'));
        }

        $sectorCandidato = $this->sectorCandidatoRepository->update($request->all(), $id);

        Flash::success('Sector Candidato updated successfully.');

        return redirect(route('sectorCandidatos.index'));
    }

    /**
     * Remove the specified SectorCandidato from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sectorCandidato = $this->sectorCandidatoRepository->findWithoutFail($id);

        if (empty($sectorCandidato)) {
            Flash::error('Sector Candidato not found');

            return redirect(route('sectorCandidatos.index'));
        }

        $this->sectorCandidatoRepository->delete($id);

        Flash::success('Sector Candidato deleted successfully.');

        return redirect(route('sectorCandidatos.index'));
    }
}
