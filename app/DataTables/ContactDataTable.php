<?php

namespace App\DataTables;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ContactDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('message', function ($q) {
                $message = $q->message ?? '';
                // Truncate long messages for better display
                return strlen($message) > 100 ? substr($message, 0, 100) . '...' : $message;
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at ? $q->created_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->editColumn('updated_at', function ($q) {
                return $q->updated_at ? $q->updated_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->addColumn('action', function ($contact) {
                return view('admin.contacts.actions', compact('contact'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Contact $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contacts-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'pageLength' => 25,
                'responsive' => true,
                'autoWidth' => false,
                'processing' => true,
                'serverSide' => true,
                'searching' => false, // Disable searching
                'paging' => true,
                'info' => true,
                'lengthChange' => true,
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
                'language' => [
                    'processing' => 'Loading...',
                    'lengthMenu' => 'Show _MENU_ entries',
                    'zeroRecords' => 'No contact submissions found',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                    'infoFiltered' => '(filtered from _MAX_ total entries)',
                    'search' => 'Search:',
                    'paginate' => [
                        'first' => 'First',
                        'last' => 'Last',
                        'next' => 'Next',
                        'previous' => 'Previous'
                    ]
                ]
            ])
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width(50)->addClass('text-center'),
            Column::make('id')->visible(false)->searchable(false)->exportable(false),
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('phone_number')->title('Phone Number'),
            Column::make('message')->title('Message'),
            Column::make('ip_address')->title('IP Address'),
            Column::make('created_at')->title('Submitted Date'),
            Column::computed('action')->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Contact_Submissions_' . date('YmdHis');
    }
}
