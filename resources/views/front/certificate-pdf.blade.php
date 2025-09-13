<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $student->name ?? 'N/A' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        
        .certificate-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .certificate-image {
            width: 100%;
            height: auto;
            max-width: 800px;
            display: block;
        }
        
        .student-name-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);
            letter-spacing: 2px;
            text-transform: uppercase;
            max-width: 80%;
            word-wrap: break-word;
        }
        
        .certificate-details {
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: #34495e;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .certificate-id {
            position: absolute;
            bottom: 10%;
            right: 10%;
            color: #7f8c8d;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <img src="file://{{ public_path('front/assets/img/certificate/certificate.jpg') }}" alt="Certificate" class="certificate-image">
        
        <div class="student-name-overlay">
            {{ $student->name ?? 'N/A' }}
        </div>
        
        <div class="certificate-details">
            <div><strong>Mobile:</strong> {{ $student->mobile_number ?? 'N/A' }}</div>
            <div><strong>Date:</strong> {{ $student->created_date ? date('d M Y', strtotime($student->created_date)) : date('d M Y') }}</div>
        </div>
        
        <div class="certificate-id">
            ID: JE{{ $student->id ?? 'N/A' }}{{ date('Y') }}
        </div>
    </div>
</body>
</html>
