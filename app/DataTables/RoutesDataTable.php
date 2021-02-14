<?php

namespace App\DataTables;

use App\Route;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoutesDataTable extends DataTable
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
            ->addColumn('total_locations', fn(Route $route) => $route->locations->count())
            ->addColumn('travel_duration', fn(Route $route) => $route->getTravelDuration())
            ->addColumn('actions', function (Route $route) {
                return view('admin.partials.datatable-action-buttons', [
                    'id' => $route->id,
                    'itemName' => 'route',
                    'showRoute' => route('admin.routes.show', $route),
                    'editRoute' => route('admin.routes.edit', $route),
                    'destroyRoute' => route('admin.routes.destroy', $route)
                ]);
            })
            ->orderColumn('total_locations', function ($query, $order) {
                $query->withCount('locations')->orderBy('locations_count', $order);
            })
            ->orderColumn('travel_duration', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('minutes_from_departure')
                        ->from('location_route')
                        ->whereColumn('route_id', 'routes.id')
                        ->orderByDesc('order')
                        ->limit(1);
                }, $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Route $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Route $model)
    {
        return $model->newQuery()->with('locations');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('routes-table')
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
            Column::make('id')->width('10%'),
            Column::make('name')->width('30%'),
            Column::make('total_locations')->width('15%')->searchable(false),
            Column::make('travel_duration')->width('20%')->searchable(false),
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
        return 'Routes_' . date('YmdHis');
    }
}
