<?php

namespace App\DataTables;

use App\Bus;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BusesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function (Bus $bus) {
                return view('admin.partials.datatable-action-buttons', [
                    'id' => $bus->id,
                    'itemName' => 'bus',
                    'editRoute' => route('admin.buses.edit', $bus),
                    'destroyRoute' => route('admin.buses.destroy', $bus),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Bus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bus $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('buses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->addTableClass('table-hover')
            ->parameters([
                'responsive' => true,
                'autoWidth' => false
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->width('15%'),
            Column::make('name')->width('40%'),
            Column::make('seats')->width('20%'),
            Column::computed('actions')->width('25%')->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Buses_' . date('YmdHis');
    }
}
