<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Winner;
use App\DataTables\WinnerDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WinnerDataTable $dataTable)
    {
        return $dataTable->render('admin.winners.index');
    }

    /**
     * Get the next batch number
     */
    private function getNextBatchNumber()
    {
        $lastBatch = Winner::max('batch_no');
        return $lastBatch ? $lastBatch + 1 : 1;
    }

    /**
     * Upload CSV file and store winners
     */
    public function uploadCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please upload a valid CSV file (max 2MB)',
                'errors' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($csvData); // Remove header row

            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $batchNumber = $this->getNextBatchNumber();

            foreach ($csvData as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Map CSV columns to database fields
                    $winnerData = [
                        'name' => $row[0] ?? '',
                        'email' => $row[1] ?? '',
                        'mobile_number' => $row[2] ?? '',
                        'batch_no' => $batchNumber,
                        'created_date' => $row[3] ?? now(),
                    ];

                    // Validate required fields
                    if (empty(trim($winnerData['name']))) {
                        $errors[] = "Row " . ($index + 2) . ": Name is required";
                        $errorCount++;
                        continue;
                    }
                    
                    if (empty(trim($winnerData['mobile_number']))) {
                        $errors[] = "Row " . ($index + 2) . ": Mobile number is required";
                        $errorCount++;
                        continue;
                    }
                    
                    // Validate mobile number format
                    if (!preg_match('/^[6-9]\d{9}$/', $winnerData['mobile_number'])) {
                        $errors[] = "Row " . ($index + 2) . ": Mobile number must be a valid 10-digit number starting with 6, 7, 8, or 9";
                        $errorCount++;
                        continue;
                    }
                    
                    // Validate name format (only letters, spaces, and common characters)
                    if (!preg_match('/^[a-zA-Z\s\.\-\']+$/', $winnerData['name'])) {
                        $errors[] = "Row " . ($index + 2) . ": Name should contain only letters, spaces, dots, hyphens, and apostrophes";
                        $errorCount++;
                        continue;
                    }
                    
                    // Validate name length
                    if (strlen(trim($winnerData['name'])) < 2 || strlen(trim($winnerData['name'])) > 100) {
                        $errors[] = "Row " . ($index + 2) . ": Name must be between 2 and 100 characters";
                        $errorCount++;
                        continue;
                    }

                    // Validate email format if provided
                    if (!empty($winnerData['email']) && !filter_var($winnerData['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Row " . ($index + 2) . ": Invalid email format";
                        $errorCount++;
                        continue;
                    }

                    
                    // Validate created_date format if provided
                    if (!empty($winnerData['created_date']) && is_string($winnerData['created_date'])) {
                        try {
                            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $winnerData['created_date']);
                            if (!$date || $date->format('Y-m-d') !== $winnerData['created_date']) {
                                $errors[] = "Row " . ($index + 2) . ": Created date must be in YYYY-MM-DD format";
                                $errorCount++;
                                continue;
                            }
                            // Convert string date to Carbon instance
                            $winnerData['created_date'] = $date;
                        } catch (\Exception $e) {
                            $errors[] = "Row " . ($index + 2) . ": Invalid date format. Use YYYY-MM-DD";
                            $errorCount++;
                            continue;
                        }
                    }

                    // Allow duplicate mobile numbers - removed duplicate check

                    Winner::create($winnerData);
                    $successCount++;

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                    $errorCount++;
                }
            }

            $message = "CSV uploaded successfully. {$successCount} winners added to Batch #{$batchNumber}.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} rows had errors.";
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'batch_number' => $batchNumber,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('CSV upload failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process CSV file. Please check the format and try again.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $winner = Winner::findOrFail($id);
            $winner->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Winner deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Winner deletion failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete winner'
            ]);
        }
    }
}