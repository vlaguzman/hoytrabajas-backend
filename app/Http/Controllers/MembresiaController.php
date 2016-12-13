<?php

namespace App\Http\Controllers;

use App\DataTables\MembresiaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMembresiaRequest;
use App\Http\Requests\UpdateMembresiaRequest;
use App\Repositories\MembresiaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MembresiaController extends AppBaseController
{
    /** @var  MembresiaRepository */
    private $membresiaRepository;

    public function __construct(MembresiaRepository $membresiaRepo)
    {
        $this->membresiaRepository = $membresiaRepo;
    }

    /**
     * Display a listing of the Membresia.
     *
     * @param MembresiaDataTable $membresiaDataTable
     * @return Response
     */
    public function index(MembresiaDataTable $membresiaDataTable)
    {
        return $membresiaDataTable->render('membresias.index');
    }

    /**
     * Show the form for creating a new Membresia.
     *
     * @return Response
     */
    public function create()
    {
        return view('membresias.create');
    }

    /**
     * Store a newly created Membresia in storage.
     *
     * @param CreateMembresiaRequest $request
     *
     * @return Response
     */
    public function store(CreateMembresiaRequest $request)
    {
        $input = $request->all();

        $membresia = $this->membresiaRepository->create($input);

        Flash::success('Membresia saved successfully.');

        return redirect(route('membresias.index'));
    }

    /**
     * Display the specified Membresia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $membresia = $this->membresiaRepository->findWithoutFail($id);

        if (empty($membresia)) {
            Flash::error('Membresia not found');

            return redirect(route('membresias.index'));
        }

        return view('membresias.show')->with('membresia', $membresia);
    }

    /**
     * Show the form for editing the specified Membresia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $membresia = $this->membresiaRepository->findWithoutFail($id);

        if (empty($membresia)) {
            Flash::error('Membresia not found');

            return redirect(route('membresias.index'));
        }

        return view('membresias.edit')->with('membresia', $membresia);
    }

    /**
     * Update the specified Membresia in storage.
     *
     * @param  int              $id
     * @param UpdateMembresiaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMembresiaRequest $request)
    {
        $membresia = $this->membresiaRepository->findWithoutFail($id);

        if (empty($membresia)) {
            Flash::error('Membresia not found');

            return redirect(route('membresias.index'));
        }

        $membresia = $this->membresiaRepository->update($request->all(), $id);

        Flash::success('Membresia updated successfully.');

        return redirect(route('membresias.index'));
    }

    /**
     * Remove the specified Membresia from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $membresia = $this->membresiaRepository->findWithoutFail($id);

        if (empty($membresia)) {
            Flash::error('Membresia not found');

            return redirect(route('membresias.index'));
        }

        $this->membresiaRepository->delete($id);

        Flash::success('Membresia deleted successfully.');

        return redirect(route('membresias.index'));
    }
}
