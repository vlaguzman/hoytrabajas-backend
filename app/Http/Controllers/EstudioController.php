<?php

namespace App\Http\Controllers;

use App\DataTables\EstudioDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEstudioRequest;
use App\Http\Requests\UpdateEstudioRequest;
use App\Repositories\EstudioRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Estudio;

class EstudioController extends AppBaseController
{
    /** @var  EstudioRepository */
    private $estudioRepository;

    public function __construct(EstudioRepository $estudioRepo)
    {
        $this->estudioRepository = $estudioRepo;
    }
	public function listar(){
          $lista= Estudio::orderBy('descripcion')->pluck('descripcion', 'id');
			return Response::json([
				  $lista
			], 200);
     }
    /**
     * Display a listing of the Estudio.
     *
     * @param EstudioDataTable $estudioDataTable
     * @return Response
     */
    public function index(EstudioDataTable $estudioDataTable)
    {
        return $estudioDataTable->render('estudios.index');
    }

    /**
     * Show the form for creating a new Estudio.
     *
     * @return Response
     */
    public function create()
    {
        return view('estudios.create');
    }

    /**
     * Store a newly created Estudio in storage.
     *
     * @param CreateEstudioRequest $request
     *
     * @return Response
     */
    public function store(CreateEstudioRequest $request)
    {
        $input = $request->all();

        $estudio = $this->estudioRepository->create($input);

        Flash::success('Estudio saved successfully.');

        return redirect(route('estudios.index'));
    }

    /**
     * Display the specified Estudio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estudio = $this->estudioRepository->findWithoutFail($id);

        if (empty($estudio)) {
            Flash::error('Estudio not found');

            return redirect(route('estudios.index'));
        }

        return view('estudios.show')->with('estudio', $estudio);
    }

    /**
     * Show the form for editing the specified Estudio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estudio = $this->estudioRepository->findWithoutFail($id);

        if (empty($estudio)) {
            Flash::error('Estudio not found');

            return redirect(route('estudios.index'));
        }

        return view('estudios.edit')->with('estudio', $estudio);
    }

    /**
     * Update the specified Estudio in storage.
     *
     * @param  int              $id
     * @param UpdateEstudioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstudioRequest $request)
    {
        $estudio = $this->estudioRepository->findWithoutFail($id);

        if (empty($estudio)) {
            Flash::error('Estudio not found');

            return redirect(route('estudios.index'));
        }

        $estudio = $this->estudioRepository->update($request->all(), $id);

        Flash::success('Estudio updated successfully.');

        return redirect(route('estudios.index'));
    }

    /**
     * Remove the specified Estudio from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estudio = $this->estudioRepository->findWithoutFail($id);

        if (empty($estudio)) {
            Flash::error('Estudio not found');

            return redirect(route('estudios.index'));
        }

        $this->estudioRepository->delete($id);

        Flash::success('Estudio deleted successfully.');

        return redirect(route('estudios.index'));
    }
}
