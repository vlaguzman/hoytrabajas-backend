<?php

namespace App\DataTables;

use App\Models\MembresiaPrecio;
use Form;
use Yajra\Datatables\Services\DataTable;

class MembresiaPrecioDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'membresia_precios.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $membresiaPrecios = MembresiaPrecio::query();

        return $this->applyScopes($membresiaPrecios);
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
            'membresia_id' => ['name' => 'membresia_id', 'data' => 'membresia_id'],
            'precio' => ['name' => 'precio', 'data' => 'precio'],
            'duracion' => ['name' => 'duracion', 'data' => 'duracion'],
            'desde' => ['name' => 'desde', 'data' => 'desde'],
            'hasta' => ['name' => 'hasta', 'data' => 'hasta']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'membresiaPrecios';
    }
}
