<?php

namespace App\DataTables;

use App\Models\JuniorEditor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JuniorEditorRegistrationsDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('full_name', function ($q) {
                $firstName = $q->first_name ?? '';
                $lastName = $q->last_name ?? '';
                return trim($firstName . ' ' . $lastName) ?: 'N/A';
            })
            ->addColumn('parent_name', function ($q) {
                return $q->parent_name ?? 'N/A';
            })
            ->addColumn('school_info', function ($q) {
                $schoolName = $q->school_name ?? 'N/A';
                $schoolClass = $q->school_class ?? 'N/A';
                return $schoolName . ' (Class: ' . $schoolClass . ')';
            })
            ->addColumn('location', function ($q) {
                $city = $q->city ?? 'N/A';
                $state = $q->state ?? 'N/A';
                return $city . ', ' . $state;
            })
            ->editColumn('amount', function ($q) {
                $amount = $q->amount ?? 0;
                return '₹' . number_format($amount, 2);
            })
            ->editColumn('payment_status', function ($q) {
                $status = $q->payment_status ?? 'pending';
                $badgeClass = $status === 'completed' ? 'success' : ($status === 'failed' ? 'danger' : 'warning');
                return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($status) . '</span>';
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at ? $q->created_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->editColumn('updated_at', function ($q) {
                return $q->updated_at ? $q->updated_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->addColumn('action', function ($registration) {
                return view('admin.junior-editor-registrations.actions', compact('registration'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['action', 'payment_status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(JuniorEditor $model): QueryBuilder
    {
        $request = $this->request();
        $paymentStatus = $request->get('payment_status');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        
        // Handle search parameter properly - DataTables sends it as an array
        $searchValue = $request->get('search');
        $search = '';
        if (is_array($searchValue) && isset($searchValue['value'])) {
            $search = $searchValue['value'];
        } elseif (is_string($searchValue)) {
            $search = $searchValue;
        }

        $model = $model->when($paymentStatus != '', function ($q) use ($paymentStatus) {
            return $q->where('payment_status', $paymentStatus);
        })
        ->when($startDate != '' && $endDate != '', function ($q) use ($startDate, $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            return $q->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->when($search != '', function ($q) use ($search) {
            return $q->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('parent_name', 'like', "%{$search}%")
                      ->orWhere('mobile_number', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('school_name', 'like', "%{$search}%");
            });
        });

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('junior-editor-registrations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->parameters)
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel')->addClass('btn-sm btn-warning')->text('<i class="bx bx-file"></i> Export to Excel'),
                Button::make('csv')->addClass('btn-sm btn-info')->text('<i class="bx bx-file"></i> Export to CSV'),
                Button::make('pdf')->addClass('btn-sm btn-danger')->text('<i class="bx bx-file"></i> Export to PDF'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->visible(false)->searchable(false)->exportable(false),
            Column::make('mobile_number')->title('Mobile Number'),
            Column::make('full_name')->title('Student Name')->searchable(false)->orderable(false),
            Column::make('parent_name')->title('Parent Name')->searchable(false)->orderable(false),
            Column::make('email')->title('Email'),
            Column::make('school_info')->title('School Info')->searchable(false)->orderable(false),
            Column::make('location')->title('Location')->searchable(false)->orderable(false),
            Column::make('amount')->title('Amount'),
            Column::make('payment_status')->title('Payment Status'),
            Column::make('delivery_type')->title('Delivery Type'),
            Column::make('created_at')->title('Registration Date'),
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
        return 'Junior_Editor_Registrations_' . date('YmdHis');
    }
}
