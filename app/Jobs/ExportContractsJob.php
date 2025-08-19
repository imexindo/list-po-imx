<?php

namespace App\Jobs;

use App\Exports\ContractsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportContractsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $region_id;


    /**
     * Create a new job instance.
     */
    public function __construct(string $from, string $to, ?string $region_id)
    {
        $this->from = $from;
        $this->to = $to;
        $this->region_id = $region_id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $filename = 'contracts_details_' . $this->from . '_to_' . $this->to . '.xlsx';

        return Excel::download(new ContractsExport($this->from, $this->to, $this->region_id), $filename);
    }
}
