<?php

namespace App\Http\Controllers;

use App\DataTables\EmpleadorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEmpleadorRequest;
use App\Http\Requests\UpdateEmpleadorRequest;
use App\Repositories\EmpleadorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EmpleadorController extends AppBaseController
{
    /** @var  EmpleadorRepository */
    private $empleadorRepository;

    public function __construct(EmpleadorRepository $empleadorRepo)
    {
        $this->empleadorRepository = $empleadorRepo;
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
