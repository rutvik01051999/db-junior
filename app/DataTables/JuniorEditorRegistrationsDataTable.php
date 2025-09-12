<?php

namespace App\DataTables;

use App\Models\JuniorEditor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
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
            ->addIndexColumn()
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
        $state = $request->get('state');
        $city = $request->get('city');
        
        // Debug: Log filter parameters
        Log::info('DataTable Filter Parameters:', [
            'payment_status' => $paymentStatus,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'state' => $state,
            'city' => $city,
            'all_params' => $request->all()
        ]);
        
        // Log the exact values being used in queries
        Log::info('Filter Values for Query:', [
            'payment_status_empty' => empty($paymentStatus),
            'startDate_empty' => empty($startDate),
            'endDate_empty' => empty($endDate),
            'state_empty' => empty($state),
            'city_empty' => empty($city),
            'state_value' => $state,
            'city_value' => $city
        ]);
        
        // Handle search parameter properly - DataTables sends it as an array
        $searchValue = $request->get('search');
        $search = '';
        if (is_array($searchValue) && isset($searchValue['value'])) {
            $search = $searchValue['value'];
        } elseif (is_string($searchValue)) {
            $search = $searchValue;
        }

        $query = $model->newQuery()
            ->when(!empty($paymentStatus), function ($q) use ($paymentStatus) {
                return $q->where('payment_status', $paymentStatus);
            })
            ->when(!empty($startDate), function ($q) use ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                return $q->where('created_at', '>=', $startDate);
            })
            ->when(!empty($endDate), function ($q) use ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                return $q->where('created_at', '<=', $endDate);
            })
            ->when(!empty($state), function ($q) use ($state) {
                return $q->where('state', $state);
            })
            ->when(!empty($city), function ($q) use ($city) {
                return $q->where('city', $city);
            })
            ->when(!empty($search), function ($q) use ($search) {
                return $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhere('parent_name', 'like', "%{$search}%")
                          ->orWhere('mobile_number', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('school_name', 'like', "%{$search}%");
                });
            });
        
        // Log the final SQL query for debugging
        Log::info('Final SQL Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);
        
        return $query;
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
