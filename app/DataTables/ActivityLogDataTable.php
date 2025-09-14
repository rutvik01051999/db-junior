<?php

namespace App\DataTables;

use App\Helpers\App;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Spatie\Activitylog\Models\Activity as ActivityLog;

class ActivityLogDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('causer', function ($q) {
                if ($q->causer) {
                    return $q->causer->full_name ?? $q->causer->name ?? 'Admin User';
                }
                
                // For front-end activities, show IP and user agent info
                $properties = json_decode($q->properties ?? '', true) ?? [];
                if (isset($properties['ip'])) {
                    return 'Frontend User (' . $properties['ip'] . ')';
                }
                
                return 'System';
            })
            ->addColumn('activity_type', function ($q) {
                $properties = json_decode($q->properties ?? '', true) ?? [];
                $type = $properties['type'] ?? 'admin_activity';
                
                $typeLabels = [
                    'page_load' => '<span class="badge bg-info">Page Load</span>',
                    'form_submission' => '<span class="badge bg-success">Form Submission</span>',
                    'admin_activity' => '<span class="badge bg-primary">Admin Activity</span>',
                    'certificate_download' => '<span class="badge bg-warning">Certificate Download</span>',
                    'otp_activity' => '<span class="badge bg-secondary">OTP Activity</span>',
                ];
                
                return $typeLabels[$type] ?? '<span class="badge bg-secondary">Unknown</span>';
            })
            ->addColumn('details', function ($q) {
                $properties = json_decode($q->properties ?? '', true) ?? [];
                return view('admin.activitylog.details', compact('properties', 'q'))->render();
            })
            ->addColumn('description', function ($q) {
                return view('admin.activitylog.description', compact('q'))->render();
            })
            ->addColumn('action', function ($q) {
                return view('admin.activitylog.actions', compact('q'))->render();
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['activity_type', 'details', 'description', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ActivityLog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('activitylog-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->parameters)
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->visible(false)->searchable(false)->exportable(false),
            Column::make('causer')->title('User'),
            Column::make('activity_type')->title('Type'),
            Column::make('description')->title('Description'),
            Column::make('details')->title('Details'),
            Column::make('created_at')->title('Date & Time'),
            Column::make('action')->title('Action')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ActivityLog_' . date('YmdHis');
    }
}
