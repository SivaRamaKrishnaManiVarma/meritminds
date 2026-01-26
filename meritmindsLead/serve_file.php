<?php
// Advanced serve_file.php with document viewer support
session_start();

// Function to determine if we should use a document viewer
function should_use_doc_viewer($extension) {
    $viewer_extensions = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
    return in_array($extension, $viewer_extensions);
}

// Basic request validation
if (!isset($_GET['path'])) {
    http_response_code(400);
    die("Invalid request: No path specified");
}

// Check if we're in "view" mode
$use_viewer = isset($_GET['view']) && $_GET['view'] == 'inline';

// Get and decode the requested path
$requested_path = urldecode($_GET['path']);

// Strip any path traversal attempts
$requested_path = str_replace('..', '', $requested_path);

// Get script's directory as base path
$script_dir = dirname(__FILE__);

// Construct full path
$file_path = $script_dir . '/' . $requested_path;

// Check if file exists
if (!file_exists($file_path)) {
    // Try alternative path construction
    $alternative_path = $requested_path;
    if (!file_exists($alternative_path)) {
        http_response_code(404);
        die("File not found");
    }
    $file_path = $alternative_path;
}

// Get file extension
$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

// Expanded allowed extensions
$allowed_extensions = [
    'pdf', 'doc', 'docx', 'txt', 'rtf', 'xls', 'xlsx', 'csv', 
    'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp',
    'zip', 'rar', 'php'
];

if (!in_array($file_extension, $allowed_extensions)) {
    http_response_code(403);
    die("File type not allowed");
}

// MIME type mapping
$mime_types = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'txt' => 'text/plain',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'csv' => 'text/csv',
    'ppt' => 'application/vnd.ms-powerpoint',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'webp' => 'image/webp',
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
    'php' => 'application/octet-stream'
];

$mime_type = $mime_types[$file_extension] ?? 'application/octet-stream';

// Check if this is a file type that should use a document viewer and if view mode is requested
if (should_use_doc_viewer($file_extension) && $use_viewer) {
    // We'll create a viewer page for Office documents
    $server_name = $_SERVER['SERVER_NAME'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $base_url = "https://$server_name" . dirname($request_uri);
    
    // Remove any query parameters from the request URI to get the base path
    $base_path = strtok($request_uri, '?');
    $base_url = "https://$server_name" . dirname($base_path);
    
    // Create a direct download URL (without the view parameter)
    $download_url = "https://$server_name$request_uri";
    $download_url = str_replace('view=inline', 'download=true', $download_url);
    
    // Get file basename for display
    $file_name = basename($file_path);
    
    // Create a Google Docs Viewer URL
    $encoded_url = urlencode($download_url);
    $google_viewer_url = "https://docs.google.com/viewer?url=$encoded_url&embedded=true";
    
    // Create a Microsoft Office Online Viewer URL
    $office_viewer_url = "https://view.officeapps.live.com/op/view.aspx?src=$encoded_url";
    
    // Output HTML with embedded viewers
    header("Content-Type: text/html");
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Document Viewer - $file_name</title>
        <style>
            body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; }
            .container { display: flex; flex-direction: column; height: 100vh; }
            .header { background-color: #f1f1f1; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
            .viewer { flex-grow: 1; border: none; width: 100%; height: calc(100% - 60px); }
            .btn { padding: 8px 16px; background-color: #4285f4; color: white; border: none; border-radius: 4px; cursor: pointer; }
            .btn:hover { background-color: #3367d6; }
            .viewer-select { padding: 8px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h3>Viewing: $file_name</h3>
                <div>
                    <select id='viewerSelect' class='viewer-select' onchange='changeViewer()'>
                        <option value='office'>Microsoft Office Viewer</option>
                        <option value='google'>Google Docs Viewer</option>
                    </select>
                    <a href='$download_url' class='btn'>Download</a>
                </div>
            </div>
            <iframe id='viewer' class='viewer' src='$office_viewer_url' allowfullscreen></iframe>
        </div>
        <script>
            function changeViewer() {
                const select = document.getElementById('viewerSelect');
                const viewer = document.getElementById('viewer');
                
                if (select.value === 'google') {
                    viewer.src = '$google_viewer_url';
                } else {
                    viewer.src = '$office_viewer_url';
                }
            }
        </script>
    </body>
    </html>";
    exit;
}

// If we're here, we're either serving a non-Office document or providing direct download

// For PHP files, do additional security checks
if ($file_extension == 'php') {
    $content = file_get_contents($file_path);
    if (strpos($content, '<?php') !== false || strpos($content, '<?=') !== false) {
        http_response_code(403);
        die("Cannot serve PHP script files for security reasons");
    }
    
    if (strpos($content, '%PDF') === 0) {
        $mime_type = 'application/pdf';
    }
}

// Determine content disposition
$inline_extensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
$disposition = in_array($file_extension, $inline_extensions) ? 'inline' : 'attachment';

// Set appropriate headers
header("Content-Type: $mime_type");
header("Content-Disposition: $disposition; filename=\"" . basename($file_path) . "\"");
header("Content-Length: " . filesize($file_path));

// Disable output buffering
@ob_end_clean();

// Output file content
readfile($file_path);
exit;
?>