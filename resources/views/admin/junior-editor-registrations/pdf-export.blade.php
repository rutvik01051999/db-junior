<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #666;
        }
        
        .filters {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .filters h3 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #333;
        }
        
        .filters p {
            margin: 2px 0;
            font-size: 10px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        
        .status-failed {
            color: #dc3545;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ $exportDate }}</p>
        <p>Total Records: {{ $totalCount }}</p>
    </div>
    
    @if($filters['payment_status'] || $filters['start_date'] || $filters['end_date'])
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if($filters['payment_status'])
            <p><strong>Payment Status:</strong> {{ ucfirst($filters['payment_status']) }}</p>
        @endif
        @if($filters['start_date'])
            <p><strong>Start Date:</strong> {{ $filters['start_date'] }}</p>
        @endif
        @if($filters['end_date'])
            <p><strong>End Date:</strong> {{ $filters['end_date'] }}</p>
        @endif
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mobile</th>
                <th>Student Name</th>
                <th>Parent Name</th>
                <th>Email</th>
                <th>School</th>
                <th>Class</th>
                <th>State</th>
                <th>City</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Delivery</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
            <tr>
                <td>{{ $registration->id }}</td>
                <td>{{ $registration->mobile_number }}</td>
                <td>{{ $registration->first_name }} {{ $registration->last_name }}</td>
                <td>{{ $registration->parent_name ?? 'N/A' }}</td>
                <td>{{ $registration->email ?? 'N/A' }}</td>
                <td>{{ $registration->school_name ?? 'N/A' }}</td>
                <td>{{ $registration->school_class ?? 'N/A' }}</td>
                <td>{{ $registration->state ?? 'N/A' }}</td>
                <td>{{ $registration->city ?? 'N/A' }}</td>
                <td class="amount">₹{{ number_format($registration->amount ?? 0, 2) }}</td>
                <td class="status-{{ $registration->payment_status }}">
                    {{ ucfirst($registration->payment_status) }}
                </td>
                <td>{{ $registration->delivery_type ?? 'N/A' }}</td>
                <td>{{ $registration->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" style="text-align: center; padding: 20px; color: #666;">
                    No registrations found with the applied filters.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>This report was generated automatically by the Junior Editor Registration System.</p>
        <p>For any queries, please contact the system administrator.</p>
    </div>
</body>
</html>
