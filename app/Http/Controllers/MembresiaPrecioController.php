<?php

namespace App\Http\Controllers;

use App\DataTables\MembresiaPrecioDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMembresiaPrecioRequest;
use App\Http\Requests\UpdateMembresiaPrecioRequest;
use App\Repositories\MembresiaPrecioRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MembresiaPrecioController extends AppBaseController
{
    /** @var  MembresiaPrecioRepository */
    private $membresiaPrecioRepository;

    public function __construct(MembresiaPrecioRepository $membresiaPrecioRepo)
    {
        $this->membresiaPrecioRepository = $membresiaPrecioRepo;
    }

    /**
     * Display a listing of the MembresiaPrecio.
     *
     * @param MembresiaPrecioDataTable $membresiaPrecioDataTable
     * @return Response
     */
    public function index(MembresiaPrecioDataTable $membresiaPrecioDataTable)
    {
        return $membresiaPrecioDataTable->render('membresia_precios.index');
    }

    /**
     * Show the form for creating a new MembresiaPrecio.
     *
     * @return Response
     */
    public function create()
    {
        return view('membresia_precios.create');
    }

    /**
     * Store a newly created MembresiaPrecio in storage.
     *
     * @param CreateMembresiaPrecioRequest $request
     *
     * @return Response
     */
    public function store(CreateMembresiaPrecioRequest $request)
    {
        $input = $request->all();

        $membresiaPrecio = $this->membresiaPrecioRepository->create($input);

        Flash::success('Membresia Precio saved successfully.');

        return redirect(route('membresiaPrecios.index'));
    }

    /**
     * Display the specified MembresiaPrecio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $membresiaPrecio = $this->membresiaPrecioRepository->findWithoutFail($id);

        if (empty($membresiaPrecio)) {
            Flash::error('Membresia Precio not found');

            return redirect(route('membresiaPrecios.index'));
        }

        return view('membresia_precios.show')->with('membresiaPrecio', $membresiaPrecio);
    }

    /**
     * Show the form for editing the specified MembresiaPrecio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $membresiaPrecio = $this->membresiaPrecioRepository->findWithoutFail($id);

        if (empty($membresiaPrecio)) {
            Flash::error('Membresia Precio not found');

            return redirect(route('membresiaPrecios.index'));
        }

        return view('membresia_precios.edit')->with('membresiaPrecio', $membresiaPrecio);
    }

    /**
     * Update the specified MembresiaPrecio in storage.
     *
     * @param  int              $id
     * @param UpdateMembresiaPrecioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMembresiaPrecioRequest $request)
    {
        $membresiaPrecio = $this->membresiaPrecioRepository->findWithoutFail($id);

        if (empty($membresiaPrecio)) {
            Flash::error('Membresia Precio not found');

            return redirect(route('membresiaPrecios.index'));
        }

        $membresiaPrecio = $this->membresiaPrecioRepository->update($request->all(), $id);

        Flash::success('Membresia Precio updated successfully.');

        return redirect(route('membresiaPrecios.index'));
    }

    /**
     * Remove the specified MembresiaPrecio from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $membresiaPrecio = $this->membresiaPrecioRepository->findWithoutFail($id);

        if (empty($membresiaPrecio)) {
            Flash::error('Membresia Precio not found');

            return redirect(route('membresiaPrecios.index'));
        }

        $this->membresiaPrecioRepository->delete($id);

        Flash::success('Membresia Precio deleted successfully.');

        return redirect(route('membresiaPrecios.index'));
    }
}
