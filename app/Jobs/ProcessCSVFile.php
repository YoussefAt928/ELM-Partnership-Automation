<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessRowJob;

class ProcessCSVFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if (!Storage::exists($this->filePath)) {
            return;
        }

        $file = Storage::get($this->filePath);

        // إزالة BOM إذا كان موجودًا
        if (substr($file, 0, 3) === "\xEF\xBB\xBF") {
            $file = substr($file, 3);
        }

        $rows = array_map('str_getcsv', explode("\n", $file));
        $header = array_shift($rows);

        if (!$header || empty($rows)) {
            return;
        }

        $header = array_map('trim', $header);

        foreach ($rows as $row) {
            if (count($row) === count($header)) {
                $data = array_combine($header, $row);

                // إرسال كل صف كـ Job منفصل
                ProcessRowJob::dispatch($data);
            }
        }
    }
}
