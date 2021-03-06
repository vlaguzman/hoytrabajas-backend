<?php

namespace App\DataTables;

use App\Models\MembresiaEmpleador;
use Form;
use Yajra\Datatables\Services\DataTable;

class MembresiaEmpleadorDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'membresia_empleadors.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $membresiaEmpleadors = MembresiaEmpleador::query();

        return $this->applyScopes($membresiaEmpleadors);
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
            'pagado' => ['name' => 'pagado', 'data' => 'pagado'],
            'desde' => ['name' => 'desde', 'data' => 'desde'],
            'hasta' => ['name' => 'hasta', 'data' => 'hasta'],
            'empleador_id' => ['name' => 'empleador_id', 'data' => 'empleador_id']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'membresiaEmpleadors';
    }
}
