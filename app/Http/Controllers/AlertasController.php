<?php

namespace App\Http\Controllers;

use App\DataTables\AlertasDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAlertasRequest;
use App\Http\Requests\UpdateAlertasRequest;
use App\Repositories\AlertasRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AlertasController extends AppBaseController
{
    /** @var  AlertasRepository */
    private $alertasRepository;

    public function __construct(AlertasRepository $alertasRepo)
    {
        $this->alertasRepository = $alertasRepo;
    }

    /**
     * Display a listing of the Alertas.
     *
     * @param AlertasDataTable $alertasDataTable
     * @return Response
     */
    public function index(AlertasDataTable $alertasDataTable)
    {
        return $alertasDataTable->render('alertas.index');
    }

    /**
     * Show the form for creating a new Alertas.
     *
     * @return Response
     */
    public function create()
    {
        return view('alertas.create');
    }

    /**
     * Store a newly created Alertas in storage.
     *
     * @param CreateAlertasRequest $request
     *
     * @return Response
     */
    public function store(CreateAlertasRequest $request)
    {
        $input = $request->all();

        $alertas = $this->alertasRepository->create($input);

        Flash::success('Alertas saved successfully.');

        return redirect(route('alertas.index'));
    }

    /**
     * Display the specified Alertas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $alertas = $this->alertasRepository->findWithoutFail($id);

        if (empty($alertas)) {
            Flash::error('Alertas not found');

            return redirect(route('alertas.index'));
        }

        return view('alertas.show')->with('alertas', $alertas);
    }

    /**
     * Show the form for editing the specified Alertas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $alertas = $this->alertasRepository->findWithoutFail($id);

        if (empty($alertas)) {
            Flash::error('Alertas not found');

            return redirect(route('alertas.index'));
        }

        return view('alertas.edit')->with('alertas', $alertas);
    }

    /**
     * Update the specified Alertas in storage.
     *
     * @param  int              $id
     * @param UpdateAlertasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAlertasRequest $request)
    {
        $alertas = $this->alertasRepository->findWithoutFail($id);

        if (empty($alertas)) {
            Flash::error('Alertas not found');

            return redirect(route('alertas.index'));
        }

        $alertas = $this->alertasRepository->update($request->all(), $id);

        Flash::success('Alertas updated successfully.');

        return redirect(route('alertas.index'));
    }

    /**
     * Remove the specified Alertas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $alertas = $this->alertasRepository->findWithoutFail($id);

        if (empty($alertas)) {
            Flash::error('Alertas not found');

            return redirect(route('alertas.index'));
        }

        $this->alertasRepository->delete($id);

        Flash::success('Alertas deleted successfully.');

        return redirect(route('alertas.index'));
    }
}
