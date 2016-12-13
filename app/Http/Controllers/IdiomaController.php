<?php

namespace App\Http\Controllers;

use App\DataTables\IdiomaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateIdiomaRequest;
use App\Http\Requests\UpdateIdiomaRequest;
use App\Repositories\IdiomaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Idioma;
class IdiomaController extends AppBaseController
{
    /** @var  IdiomaRepository */
    private $idiomaRepository;

    public function __construct(IdiomaRepository $idiomaRepo)
    {
        $this->idiomaRepository = $idiomaRepo;
    }
	public function listar(){
          $lista= Idioma::orderBy('descripcion')->pluck('descripcion', 'id');
			return Response::json([
				  $lista
			], 200);
     }
    /**
     * Display a listing of the Idioma.
     *
     * @param IdiomaDataTable $idiomaDataTable
     * @return Response
     */
    public function index(IdiomaDataTable $idiomaDataTable)
    {
        return $idiomaDataTable->render('idiomas.index');
    }

    /**
     * Show the form for creating a new Idioma.
     *
     * @return Response
     */
    public function create()
    {
        return view('idiomas.create');
    }

    /**
     * Store a newly created Idioma in storage.
     *
     * @param CreateIdiomaRequest $request
     *
     * @return Response
     */
    public function store(CreateIdiomaRequest $request)
    {
        $input = $request->all();

        $idioma = $this->idiomaRepository->create($input);

        Flash::success('Idioma saved successfully.');

        return redirect(route('idiomas.index'));
    }

    /**
     * Display the specified Idioma.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $idioma = $this->idiomaRepository->findWithoutFail($id);

        if (empty($idioma)) {
            Flash::error('Idioma not found');

            return redirect(route('idiomas.index'));
        }

        return view('idiomas.show')->with('idioma', $idioma);
    }

    /**
     * Show the form for editing the specified Idioma.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $idioma = $this->idiomaRepository->findWithoutFail($id);

        if (empty($idioma)) {
            Flash::error('Idioma not found');

            return redirect(route('idiomas.index'));
        }

        return view('idiomas.edit')->with('idioma', $idioma);
    }

    /**
     * Update the specified Idioma in storage.
     *
     * @param  int              $id
     * @param UpdateIdiomaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIdiomaRequest $request)
    {
        $idioma = $this->idiomaRepository->findWithoutFail($id);

        if (empty($idioma)) {
            Flash::error('Idioma not found');

            return redirect(route('idiomas.index'));
        }

        $idioma = $this->idiomaRepository->update($request->all(), $id);

        Flash::success('Idioma updated successfully.');

        return redirect(route('idiomas.index'));
    }

    /**
     * Remove the specified Idioma from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $idioma = $this->idiomaRepository->findWithoutFail($id);

        if (empty($idioma)) {
            Flash::error('Idioma not found');

            return redirect(route('idiomas.index'));
        }

        $this->idiomaRepository->delete($id);

        Flash::success('Idioma deleted successfully.');

        return redirect(route('idiomas.index'));
    }
}
