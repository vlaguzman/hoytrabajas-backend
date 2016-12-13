<?php

namespace App\Http\Controllers;

use App\DataTables\CiudadDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCiudadRequest;
use App\Http\Requests\UpdateCiudadRequest;
use App\Repositories\CiudadRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Ciudad;
class CiudadController extends AppBaseController
{
    /** @var  CiudadRepository */
    private $ciudadRepository;

    public function __construct(CiudadRepository $ciudadRepo)
    {
        $this->ciudadRepository = $ciudadRepo;
    }
	public function listar(){
		  $lista= Ciudad::orderBy('descripcion')->pluck('descripcion', 'id');
			return Response::json([
				  $lista
			], 200);
     }
    /**
     * Display a listing of the Ciudad.
     *
     * @param CiudadDataTable $ciudadDataTable
     * @return Response
     */
    public function index(CiudadDataTable $ciudadDataTable)
    {
        return $ciudadDataTable->render('ciudads.index');
    }

    /**
     * Show the form for creating a new Ciudad.
     *
     * @return Response
     */
    public function create()
    {
        return view('ciudads.create');
    }

    /**
     * Store a newly created Ciudad in storage.
     *
     * @param CreateCiudadRequest $request
     *
     * @return Response
     */
    public function store(CreateCiudadRequest $request)
    {
        $input = $request->all();

        $ciudad = $this->ciudadRepository->create($input);

        Flash::success('Ciudad saved successfully.');

        return redirect(route('ciudads.index'));
    }

    /**
     * Display the specified Ciudad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ciudad = $this->ciudadRepository->findWithoutFail($id);

        if (empty($ciudad)) {
            Flash::error('Ciudad not found');

            return redirect(route('ciudads.index'));
        }

        return view('ciudads.show')->with('ciudad', $ciudad);
    }

    /**
     * Show the form for editing the specified Ciudad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ciudad = $this->ciudadRepository->findWithoutFail($id);

        if (empty($ciudad)) {
            Flash::error('Ciudad not found');

            return redirect(route('ciudads.index'));
        }

        return view('ciudads.edit')->with('ciudad', $ciudad);
    }

    /**
     * Update the specified Ciudad in storage.
     *
     * @param  int              $id
     * @param UpdateCiudadRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCiudadRequest $request)
    {
        $ciudad = $this->ciudadRepository->findWithoutFail($id);

        if (empty($ciudad)) {
            Flash::error('Ciudad not found');

            return redirect(route('ciudads.index'));
        }

        $ciudad = $this->ciudadRepository->update($request->all(), $id);

        Flash::success('Ciudad updated successfully.');

        return redirect(route('ciudads.index'));
    }

    /**
     * Remove the specified Ciudad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ciudad = $this->ciudadRepository->findWithoutFail($id);

        if (empty($ciudad)) {
            Flash::error('Ciudad not found');

            return redirect(route('ciudads.index'));
        }

        $this->ciudadRepository->delete($id);

        Flash::success('Ciudad deleted successfully.');

        return redirect(route('ciudads.index'));
    }
}