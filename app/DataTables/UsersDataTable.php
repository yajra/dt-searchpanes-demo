<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->searchPane('email', Pair::options(User::pluck('email', 'email')))
            ->searchPane('name', Pair::options(User::pluck('name', 'name')))
            ->addColumn('action', 'user.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addColumnDef([
                'searchPanes' => ['show' => true, 'viewTotal' => false, 'hideCount' => true],
                'targets' => [2, 3],
            ])
            ->dom('Bfrtip')
            ->orderBy(1)
            ->select()
            ->buttons([
                Button::make('searchPanes'),
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_'.date('YmdHis');
    }
}
