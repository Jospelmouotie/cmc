<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DownloadPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $view;
    protected $data;
    protected $filename;
    protected $orientation;
    protected $format; // << NEW

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @param string $view
     * @param array $data
     * @param string $filename
     * @param string $orientation
     * @return void
     */
    // UPDATED: add $format param
    public function __construct($view, $data, $filename, $orientation = 'portrait', $format = 'A4')
    {
        $this->view = $view;
        $this->data = $data;
        $this->filename = $filename;
        $this->orientation = $orientation;
        $this->format = $format; // << NEW
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $config = [
                'format' => $this->format, // << NEW
                'orientation' => $this->orientation === 'landscape' ? 'L' : 'P'
            ];

            $pdf = PDF::loadView($this->view, $this->data, [], $config);

            // Ensure pdfs directory exists
            if (!Storage::exists('pdfs')) {
                Storage::makeDirectory('pdfs');
            }

            // Save PDF to storage
            $pdfOutput = $pdf->output();
            Storage::put("pdfs/{$this->filename}", $pdfOutput);

            // Log success
            Log::info("PDF generated successfully: {$this->filename}");

        } catch (\Exception $e) {
            Log::error("PDF generation failed: {$this->filename}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to mark job as failed
        }
    }

    /**
     * Handle job failure
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error("PDF job failed permanently: {$this->filename}", [
            'error' => $exception->getMessage()
        ]);
        // Could send notification to admin here
    }
}