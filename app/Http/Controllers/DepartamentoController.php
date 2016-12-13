<?php

namespace App\Http\Controllers;

use App\DataTables\DepartamentoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDepartamentoRequest;
use App\Http\Requests\UpdateDepartamentoRequest;
use App\Repositories\DepartamentoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Departamento;

class DepartamentoController extends AppBaseController
{
    /** @var  DepartamentoRepository */
    private $departamentoRepository;

    public function __construct(DepartamentoRepository $departamentoRepo)
    {
        $this->departamentoRepository = $departamentoRepo;
    }
	public function listar(){
         // $lista = $this->departamentoRepository->all();
		  $lista= Departamento::orderBy('descripcion')->pluck('descripcion', 'id');
			return Response::json([
				  $lista
			], 200);
     }
    /**
     * Display a listing of the Departamento.
     *
     * @param DepartamentoDataTable $departamentoDataTable
     * @return Response
     */
    public function index(DepartamentoDataTable $departamentoDataTable)
    {
        return $departamentoDataTable->render('departamentos.index');
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartamentoRequest $request)
    {
        $input = $request->all();

        $departamento = $this->departamentoRepository->create($input);

        Flash::success('Departamento saved successfully.');

        return redirect(route('departamentos.index'));
    }

    /**
     * Display the specified Departamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $departamento = $this->departamentoRepository->findWithoutFail($id);

        if (empty($departamento)) {
            Flash::error('Departamento not found');

            return redirect(route('departamentos.index'));
        }

        return view('departamentos.show')->with('departamento', $departamento);
    }

    /**
     * Show the form for editing the specified Departamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $departamento = $this->departamentoRepository->findWithoutFail($id);

        if (empty($departamento)) {
            Flash::error('Departamento not found');

            return redirect(route('departamentos.index'));
        }

        return view('departamentos.edit')->with('departamento', $departamento);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartamentoRequest $request)
    {
        $departamento = $this->departamentoRepository->findWithoutFail($id);

        if (empty($departamento)) {
            Flash::error('Departamento not found');

            return redirect(route('departamentos.index'));
        }

        $departamento = $this->departamentoRepository->update($request->all(), $id);

        Flash::success('Departamento updated successfully.');

        return redirect(route('departamentos.index'));
    }

    /**
     * Remove the specified Departamento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $departamento = $this->departamentoRepository->findWithoutFail($id);

        if (empty($departamento)) {
            Flash::error('Departamento not found');

            return redirect(route('departamentos.index'));
        }

        $this->departamentoRepository->delete($id);

        Flash::success('Departamento deleted successfully.');

        return redirect(route('departamentos.index'));
    }
}
