<?php

namespace App\DataTables;

use App\Models\Oferta;
use Form;
use Yajra\Datatables\Services\DataTable;

class OfertaDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'ofertas.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $ofertas = Oferta::query();

        return $this->applyScopes($ofertas);
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
            'nombre' => ['name' => 'nombre', 'data' => 'nombre'],
            'descripcion' => ['name' => 'descripcion', 'data' => 'descripcion'],
            'url_imagen' => ['name' => 'url_imagen', 'data' => 'url_imagen'],
            'direccion' => ['name' => 'direccion', 'data' => 'direccion'],
            'paga' => ['name' => 'paga', 'data' => 'paga'],
            'sector_id' => ['name' => 'sector_id', 'data' => 'sector_id'],
            'ciudad_id' => ['name' => 'ciudad_id', 'data' => 'ciudad_id'],
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
        return 'ofertas';
    }
}
