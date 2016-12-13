<?php

namespace App\Http\Controllers;

use App\DataTables\MensajesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMensajesRequest;
use App\Http\Requests\UpdateMensajesRequest;
use App\Repositories\MensajesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MensajesController extends AppBaseController
{
    /** @var  MensajesRepository */
    private $mensajesRepository;

    public function __construct(MensajesRepository $mensajesRepo)
    {
        $this->mensajesRepository = $mensajesRepo;
    }

    /**
     * Display a listing of the Mensajes.
     *
     * @param MensajesDataTable $mensajesDataTable
     * @return Response
     */
    public function index(MensajesDataTable $mensajesDataTable)
    {
        return $mensajesDataTable->render('mensajes.index');
    }

    /**
     * Show the form for creating a new Mensajes.
     *
     * @return Response
     */
    public function create()
    {
        return view('mensajes.create');
    }

    /**
     * Store a newly created Mensajes in storage.
     *
     * @param CreateMensajesRequest $request
     *
     * @return Response
     */
    public function store(CreateMensajesRequest $request)
    {
        $input = $request->all();

        $mensajes = $this->mensajesRepository->create($input);

        Flash::success('Mensajes saved successfully.');

        return redirect(route('mensajes.index'));
    }

    /**
     * Display the specified Mensajes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        return view('mensajes.show')->with('mensajes', $mensajes);
    }

    /**
     * Show the form for editing the specified Mensajes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        return view('mensajes.edit')->with('mensajes', $mensajes);
    }

    /**
     * Update the specified Mensajes in storage.
     *
     * @param  int              $id
     * @param UpdateMensajesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMensajesRequest $request)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        $mensajes = $this->mensajesRepository->update($request->all(), $id);

        Flash::success('Mensajes updated successfully.');

        return redirect(route('mensajes.index'));
    }

    /**
     * Remove the specified Mensajes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mensajes = $this->mensajesRepository->findWithoutFail($id);

        if (empty($mensajes)) {
            Flash::error('Mensajes not found');

            return redirect(route('mensajes.index'));
        }

        $this->mensajesRepository->delete($id);

        Flash::success('Mensajes deleted successfully.');

        return redirect(route('mensajes.index'));
    }
}
