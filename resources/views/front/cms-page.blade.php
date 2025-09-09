<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $cmsPage->meta_title ?: $cmsPage->title }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $cmsPage->meta_description ?: strip_tags(Str::limit($cmsPage->content, 160)) }}">
    <meta name="keywords" content="{{ $cmsPage->title }}, {{ config('app.name') }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
        }
        
        .page-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .page-content h1, .page-content h2, .page-content h3, .page-content h4, .page-content h5, .page-content h6 {
            color: #2c3e50;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .page-content h1 {
            font-size: 2.5rem;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        .page-content h2 {
            font-size: 2rem;
            color: #34495e;
        }
        
        .page-content h3 {
            font-size: 1.5rem;
            color: #7f8c8d;
        }
        
        .page-content p {
            margin-bottom: 20px;
            text-align: justify;
        }
        
        .page-content ul, .page-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .page-content li {
            margin-bottom: 8px;
        }
        
        .page-content blockquote {
            border-left: 4px solid #3498db;
            padding-left: 20px;
            margin: 20px 0;
            font-style: italic;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        
        .page-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .page-content table th,
        .page-content table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        .page-content table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        
        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        
        .back-to-home {
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 30px;
            transition: background-color 0.3s;
        }
        
        .back-to-home:hover {
            background-color: #2980b9;
            color: white;
            text-decoration: none;
        }
        
        .page-meta {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #3498db;
        }
        
        .page-meta small {
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
            }
            
            .page-content h1 {
                font-size: 2rem;
            }
            
            .page-content h2 {
                font-size: 1.5rem;
            }
            
            .page-content {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>{{ $cmsPage->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $cmsPage->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Page Meta Information -->
                <div class="page-meta">
                    <div class="row">
                        <div class="col-md-6">
                            <small><i class="fas fa-calendar-alt me-1"></i> Last Updated: {{ $cmsPage->updated_at->format('F d, Y') }}</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small><i class="fas fa-clock me-1"></i> Reading Time: {{ ceil(str_word_count(strip_tags($cmsPage->content)) / 200) }} min</small>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="page-content">
                    {!! $cmsPage->content !!}
                </div>

                <!-- Back to Home Button -->
                <div class="text-center">
                    <a href="{{ url('/') }}" class="back-to-home">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add table of contents functionality
        function generateTableOfContents() {
            const headings = document.querySelectorAll('.page-content h2, .page-content h3');
            if (headings.length > 2) {
                const toc = document.createElement('div');
                toc.className = 'table-of-contents';
                toc.innerHTML = '<h4><i class="fas fa-list me-2"></i>Table of Contents</h4><ul></ul>';
                
                const tocList = toc.querySelector('ul');
                
                headings.forEach((heading, index) => {
                    const id = 'heading-' + index;
                    heading.id = id;
                    
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    a.href = '#' + id;
                    a.textContent = heading.textContent;
                    a.className = heading.tagName.toLowerCase() === 'h3' ? 'ms-3' : '';
                    li.appendChild(a);
                    tocList.appendChild(li);
                });
                
                document.querySelector('.page-content').insertBefore(toc, document.querySelector('.page-content').firstChild);
            }
        }

        // Initialize table of contents when page loads
        document.addEventListener('DOMContentLoaded', function() {
            generateTableOfContents();
        });
    </script>
</body>
</html>
