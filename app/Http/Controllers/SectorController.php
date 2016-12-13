<?php

namespace App\Http\Controllers;

use App\DataTables\SectorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Repositories\SectorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Sector;

class SectorController extends AppBaseController
{
    /** @var  SectorRepository */
    private $sectorRepository;

    public function __construct(SectorRepository $sectorRepo)
    {
        $this->sectorRepository = $sectorRepo;
    }
	public function listar(){
          $lista= Sector::orderBy('descripcion')->pluck('descripcion', 'id');
			return Response::json([
				  $lista
			], 200);
     }
    /**
     * Display a listing of the Sector.
     *
     * @param SectorDataTable $sectorDataTable
     * @return Response
     */
    public function index(SectorDataTable $sectorDataTable)
    {
        return $sectorDataTable->render('sectors.index');
    }

    /**
     * Show the form for creating a new Sector.
     *
     * @return Response
     */
    public function create()
    {
        return view('sectors.create');
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSectorRequest $request
     *
     * @return Response
     */
    public function store(CreateSectorRequest $request)
    {
        $input = $request->all();

        $sector = $this->sectorRepository->create($input);

        Flash::success('Sector saved successfully.');

        return redirect(route('sectors.index'));
    }

    /**
     * Display the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error('Sector not found');

            return redirect(route('sectors.index'));
        }

        return view('sectors.show')->with('sector', $sector);
    }

    /**
     * Show the form for editing the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error('Sector not found');

            return redirect(route('sectors.index'));
        }

        return view('sectors.edit')->with('sector', $sector);
    }

    /**
     * Update the specified Sector in storage.
     *
     * @param  int              $id
     * @param UpdateSectorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSectorRequest $request)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error('Sector not found');

            return redirect(route('sectors.index'));
        }

        $sector = $this->sectorRepository->update($request->all(), $id);

        Flash::success('Sector updated successfully.');

        return redirect(route('sectors.index'));
    }

    /**
     * Remove the specified Sector from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error('Sector not found');

            return redirect(route('sectors.index'));
        }

        $this->sectorRepository->delete($id);

        Flash::success('Sector deleted successfully.');

        return redirect(route('sectors.index'));
    }
}
