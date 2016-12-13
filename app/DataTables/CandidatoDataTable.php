<?php

namespace App\DataTables;

use App\Models\Candidato;
use Form;
use Yajra\Datatables\Services\DataTable;

class CandidatoDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'candidatos.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $candidatos = Candidato::query();

        return $this->applyScopes($candidatos);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'nombres' => ['name' => 'nombres', 'data' => 'nombres'],
            'apellidos' => ['name' => 'apellidos', 'data' => 'apellidos'],
            'url_imagen' => ['name' => 'url_imagen', 'data' => 'url_imagen'],
            'fnac' => ['name' => 'fnac', 'data' => 'fnac'],
            'telefono' => ['name' => 'telefono', 'data' => 'telefono'],
            'correo' => ['name' => 'correo', 'data' => 'correo'],
            'descripcion' => ['name' => 'descripcion', 'data' => 'descripcion'],
            'direccion' => ['name' => 'direccion', 'data' => 'direccion'],
            'experiencia' => ['name' => 'experiencia', 'data' => 'experiencia'],
            'rate' => ['name' => 'rate', 'data' => 'rate'],
            'genero_id' => ['name' => 'genero_id', 'data' => 'genero_id'],
            'ciudad_id' => ['name' => 'ciudad_id', 'data' => 'ciudad_id']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'candidatos';
    }
}
