<?php

namespace App\DataTables;

use App\Models\Survey;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class SurveyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query): \Yajra\DataTables\DataTableAbstract
    {
        return datatables()->eloquent($query)
            ->editColumn('status', function($row) {
                if(Carbon::now() > Carbon::parse($row->expires_at)) {
                    return '<span class="badge bg-danger text-white">EXPIRED</span>';
                }

                if(Carbon::parse($row->expires_at) > Carbon::now()) {
                    return '<span class="badge bg-success text-white">ACTIVE</span>';
                }
                else {
                    return '<span class="badge bg-warning text-white"'.strtoupper($row->status).'</span>';
                }
            })

            ->editColumn('expires', function($row) {
                return Carbon::parse($row->expires_at)->format('d M, Y H:i:s A');
            })
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group" aria-label="Action buttons">' .
                    '<a class="btn btn-xs btn-primary" href="'.route('survey.app.view', [$row->id]).'" target="_self"><i class="fa fa-eye text-gray-dark" aria-hidden="true"></i></a>' .
                    '</div>';
            })->rawColumns(['questions', 'action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Survey::with(['questions', 'participants'])->where('status',  '=','active')->where('expires_at', '>', Carbon::now())->orderByDesc('updated_at');
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => 50])
            ->serverSide(true)
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            'title'          => ['width' => 50],
            'description'          => ['width' => 100],
            'user'   => ['title' => 'CREATED&nbsp;BY', 'width' => 50],
            'status'          => ['width' => 50],
            'expires'          => ['title' => 'EXPIRES&nbsp;AT', 'width' => 50],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'SurveyDataTable_' . time();
    }
}
