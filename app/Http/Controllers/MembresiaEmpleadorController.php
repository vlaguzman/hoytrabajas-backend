<?php

namespace App\Http\Controllers;

use App\DataTables\MembresiaEmpleadorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMembresiaEmpleadorRequest;
use App\Http\Requests\UpdateMembresiaEmpleadorRequest;
use App\Repositories\MembresiaEmpleadorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MembresiaEmpleadorController extends AppBaseController
{
    /** @var  MembresiaEmpleadorRepository */
    private $membresiaEmpleadorRepository;

    public function __construct(MembresiaEmpleadorRepository $membresiaEmpleadorRepo)
    {
        $this->membresiaEmpleadorRepository = $membresiaEmpleadorRepo;
    }

    /**
     * Display a listing of the MembresiaEmpleador.
     *
     * @param MembresiaEmpleadorDataTable $membresiaEmpleadorDataTable
     * @return Response
     */
    public function index(MembresiaEmpleadorDataTable $membresiaEmpleadorDataTable)
    {
        return $membresiaEmpleadorDataTable->render('membresia_empleadors.index');
    }

    /**
     * Show the form for creating a new MembresiaEmpleador.
     *
     * @return Response
     */
    public function create()
    {
        return view('membresia_empleadors.create');
    }

    /**
     * Store a newly created MembresiaEmpleador in storage.
     *
     * @param CreateMembresiaEmpleadorRequest $request
     *
     * @return Response
     */
    public function store(CreateMembresiaEmpleadorRequest $request)
    {
        $input = $request->all();

        $membresiaEmpleador = $this->membresiaEmpleadorRepository->create($input);

        Flash::success('Membresia Empleador saved successfully.');

        return redirect(route('membresiaEmpleadors.index'));
    }

    /**
     * Display the specified MembresiaEmpleador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $membresiaEmpleador = $this->membresiaEmpleadorRepository->findWithoutFail($id);

        if (empty($membresiaEmpleador)) {
            Flash::error('Membresia Empleador not found');

            return redirect(route('membresiaEmpleadors.index'));
        }

        return view('membresia_empleadors.show')->with('membresiaEmpleador', $membresiaEmpleador);
    }

    /**
     * Show the form for editing the specified MembresiaEmpleador.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $membresiaEmpleador = $this->membresiaEmpleadorRepository->findWithoutFail($id);

        if (empty($membresiaEmpleador)) {
            Flash::error('Membresia Empleador not found');

            return redirect(route('membresiaEmpleadors.index'));
        }

        return view('membresia_empleadors.edit')->with('membresiaEmpleador', $membresiaEmpleador);
    }

    /**
     * Update the specified MembresiaEmpleador in storage.
     *
     * @param  int              $id
     * @param UpdateMembresiaEmpleadorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMembresiaEmpleadorRequest $request)
    {
        $membresiaEmpleador = $this->membresiaEmpleadorRepository->findWithoutFail($id);

        if (empty($membresiaEmpleador)) {
            Flash::error('Membresia Empleador not found');

            return redirect(route('membresiaEmpleadors.index'));
        }

        $membresiaEmpleador = $this->membresiaEmpleadorRepository->update($request->all(), $id);

        Flash::success('Membresia Empleador updated successfully.');

        return redirect(route('membresiaEmpleadors.index'));
    }

    /**
     * Remove the specified MembresiaEmpleador from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $membresiaEmpleador = $this->membresiaEmpleadorRepository->findWithoutFail($id);

        if (empty($membresiaEmpleador)) {
            Flash::error('Membresia Empleador not found');

            return redirect(route('membresiaEmpleadors.index'));
        }

        $this->membresiaEmpleadorRepository->delete($id);

        Flash::success('Membresia Empleador deleted successfully.');

        return redirect(route('membresiaEmpleadors.index'));
    }
}
