<?php

namespace App\DataTables;

use App\Models\Mensajes;
use Form;
use Yajra\Datatables\Services\DataTable;

class MensajesDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'mensajes.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $mensajes = Mensajes::query();

        return $this->applyScopes($mensajes);
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
            'deuser_id' => ['name' => 'deuser_id', 'data' => 'deuser_id'],
            'parauser_id' => ['name' => 'parauser_id', 'data' => 'parauser_id'],
            'mensaje' => ['name' => 'mensaje', 'data' => 'mensaje'],
            'fenviado' => ['name' => 'fenviado', 'data' => 'fenviado'],
            'frecivido' => ['name' => 'frecivido', 'data' => 'frecivido'],
            'fleido' => ['name' => 'fleido', 'data' => 'fleido'],
            'recivido' => ['name' => 'recivido', 'data' => 'recivido'],
            'leido' => ['name' => 'leido', 'data' => 'leido']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'mensajes';
    }
}
