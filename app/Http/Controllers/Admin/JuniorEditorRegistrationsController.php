<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\JuniorEditorRegistrationsDataTable;
use App\Http\Controllers\Controller;
use App\Models\JuniorEditor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Barryvdh\Snappy\Facades\SnappyPdf;

class JuniorEditorRegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JuniorEditorRegistrationsDataTable $dataTable)
    {
        return $dataTable->render('admin.junior-editor-registrations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(JuniorEditor $juniorEditorRegistration)
    {
        return view('admin.junior-editor-registrations.show', compact('juniorEditorRegistration'));
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:junior_editor_registrations,id',
            'payment_status' => 'required|in:pending,completed,failed'
        ]);

        $registration = JuniorEditor::findOrFail($request->id);
        $registration->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully.'
        ]);
    }

    /**
     * Export registrations data
     */
    public function export(Request $request)
    {
        $query = JuniorEditor::query();

        // Apply filters
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $registrations = $query->get();

        $filename = 'junior_editor_registrations_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Mobile Number', 'Student Name', 'Parent Name', 'Email',
                'School Name', 'Class', 'State', 'City', 'Amount', 'Payment Status',
                'Delivery Type', 'Registration Date'
            ]);

            // CSV data
            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->id,
                    $registration->mobile_number,
                    $registration->first_name . ' ' . $registration->last_name,
                    $registration->parent_name ?? 'N/A',
                    $registration->email ?? 'N/A',
                    $registration->school_name ?? 'N/A',
                    $registration->school_class ?? 'N/A',
                    $registration->state ?? 'N/A',
                    $registration->city ?? 'N/A',
                    $registration->amount ?? '0',
                    $registration->payment_status,
                    $registration->delivery_type ?? 'N/A',
                    $registration->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export registrations to Excel
     */
    public function exportExcel(Request $request)
    {
        $paymentStatus = $request->get('payment_status');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $registrations = JuniorEditor::query()
            ->when($paymentStatus != '', function ($q) use ($paymentStatus) {
                return $q->where('payment_status', $paymentStatus);
            })
            ->when($startDate != '' && $endDate != '', function ($q) use ($startDate, $endDate) {
                $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();

        return Excel::download(new class($registrations) implements FromCollection, WithHeadings, WithMapping {
            private $registrations;

            public function __construct($registrations)
            {
                $this->registrations = $registrations;
            }

            public function collection()
            {
                return $this->registrations;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Mobile Number',
                    'Student Name',
                    'Parent Name',
                    'Email',
                    'School Name',
                    'Class',
                    'State',
                    'City',
                    'Amount',
                    'Payment Status',
                    'Delivery Type',
                    'Registration Date'
                ];
            }

            public function map($registration): array
            {
                return [
                    $registration->id,
                    $registration->mobile_number,
                    $registration->first_name . ' ' . $registration->last_name,
                    $registration->parent_name ?? 'N/A',
                    $registration->email ?? 'N/A',
                    $registration->school_name ?? 'N/A',
                    $registration->school_class ?? 'N/A',
                    $registration->state ?? 'N/A',
                    $registration->city ?? 'N/A',
                    $registration->amount ?? '0',
                    $registration->payment_status,
                    $registration->delivery_type ?? 'N/A',
                    $registration->created_at->format('Y-m-d H:i:s')
                ];
            }
        }, 'junior_editor_registrations_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export registrations to PDF
     */
    public function exportPdf(Request $request)
    {
        $paymentStatus = $request->get('payment_status');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $registrations = JuniorEditor::query()
            ->when($paymentStatus != '', function ($q) use ($paymentStatus) {
                return $q->where('payment_status', $paymentStatus);
            })
            ->when($startDate != '' && $endDate != '', function ($q) use ($startDate, $endDate) {
                $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();

        $data = [
            'registrations' => $registrations,
            'title' => 'Junior Editor Registrations Report',
            'exportDate' => now()->format('Y-m-d H:i:s'),
            'totalCount' => $registrations->count(),
            'filters' => [
                'payment_status' => $paymentStatus,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];

        $pdf = SnappyPdf::loadView('admin.junior-editor-registrations.pdf-export', $data)
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download('junior_editor_registrations_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
