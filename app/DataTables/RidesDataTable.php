<?php

namespace App\DataTables;

use App\Ride;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RidesDataTable extends DataTable
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
            ->editColumn('bus', fn(Ride $ride) => $ride->bus->name)
            ->editColumn('departure_time', fn(Ride $ride) => $ride->departure_time->format('H:i'))
            ->editColumn('ride_date', fn(Ride $ride) => optional($ride->ride_date)->format('Y-m-d') ?? '-')
            ->editColumn('auto_confirm', fn(Ride $ride) => $ride->auto_confirm ? 'Yes' : 'No')
            ->editColumn('updated_at', fn(Ride $ride) => $ride->updated_at)
            ->editColumn('route', function(Ride $ride) {
                $route = route('admin.routes.show', $ride->route->id);
                return "<a href='{$route}'>" . $ride->route->id . '. ' . $ride->route->name . '</a>';
            })
            ->rawColumns(['route'])
            ->addColumn('ride_type', fn(Ride $ride) => $ride->ride_date ? 'Single' : 'Cyclic')
            ->addColumn('state', fn(Ride $ride) => $ride->isActive() ? 'Active' : 'Inactive')
            ->addColumn('actions', function (Ride $ride) {
                return view('admin.partials.datatable-action-buttons', [
                    'id' => $ride->id,
                    'itemName' => 'ride',
                    'showRoute' => route('admin.rides.show', $ride),
                    'editRoute' => route('admin.rides.edit', $ride),
                    'destroyRoute' => route('admin.rides.destroy', $ride)
                ]);
            })
            ->orderColumn('ride_type', fn($query, $order) => $query->orderBy('ride_date', $order));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Ride $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ride $model)
    {
        return $model->newQuery()->with(['route', 'bus', 'schedule']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('rides-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->addTableClass('table-hover')
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
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
            Column::make('id')->width('5%'),
            Column::make('route')->width('30%')->name('route.id'),
            Column::make('bus')->width('10%')->name('bus.name'),
            Column::make('departure_time')->width('5%'),
            Column::make('ride_date')->width('10%'),
            Column::make('ride_type')->width('5%')->searchable('false'),
            Column::make('auto_confirm')->width('5%')->searchable('false'),
            Column::make('updated_at')->width('10%'),
            Column::computed('state')->width('5%'),
            Column::computed('actions')->width('15%')->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Rides_' . date('YmdHis');
    }
}
