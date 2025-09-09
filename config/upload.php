<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for file uploads including size limits and validation
    |
    */

    'max_file_size' => env('MAX_FILE_SIZE', 100 * 1024), // 100MB in KB
    'max_video_size' => env('MAX_VIDEO_SIZE', 100 * 1024), // 100MB in KB
    'max_image_size' => env('MAX_IMAGE_SIZE', 2 * 1024), // 2MB in KB
    
    'allowed_video_types' => ['mp4', 'mov', 'avi', 'wmv', 'webm'],
    'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    
    'chunk_size' => 1024 * 1024, // 1MB chunks for large file uploads
];
