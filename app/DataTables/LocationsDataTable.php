<?php

namespace App\DataTables;

use App\Location;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LocationsDataTable extends DataTable
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
            ->addColumn('actions', function (Location $location) {
                return view('admin.partials.datatable-action-buttons', [
                    'id' => $location->id,
                    'itemName' => 'location',
                    'editRoute' => route('admin.locations.edit', $location),
                    'destroyRoute' => route('admin.locations.destroy', $location),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Location $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Location $model)
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
            ->setTableId('locations-table')
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
            Column::make('name')->width('55%'),
            Column::computed('actions')->width('30%')->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Locations_' . date('YmdHis');
    }
}
