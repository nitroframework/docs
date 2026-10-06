// config/fusion.php
'uploads' => [
    'directory' => storage_path('app/fusion-uploads'),   // Where uploads wait until you store them.
    'rules' => ['file', 'max:12288'],                    // Checked as each file arrives.
    'max_files' => 20,                                   // Files in one input at once.
    'throttle' => '60,1',                                // Uploads a minute, per visitor.
],
