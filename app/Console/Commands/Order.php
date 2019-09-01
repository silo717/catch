<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\ExportController;

class Order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a program to create csv files from jsonl file orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $summary_controller = new SummaryController();
        $summary_controller->cleanData();
        $summary_controller->summaryData($this->getJsonLines());
        $this->info("1. Successfully Summarize JsonLines data");

            $export = new ExportController();
            if($export->createCsv()) {
                $this->info("2. Successfully Create a CSV Files");
                $this->info("   File name : orders.csv | located in storage/app folder");
            }
        
    }

    public function getJsonLines() {
        $jsonLines = file_get_contents('https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl');
        $saparator = "\n";
    
        if (empty($jsonLines)) {
            return json_encode([]);
        }
        $lines = [];
        $jsonLines = explode($saparator, trim($jsonLines));
        foreach ($jsonLines as $line) {
            $lines[] = $this->guardedJsonLine($line);
        }
        return $lines;
    }

    public function guardedJsonLine($line)
    {
        if (is_string($line)) {
            $guardedJsonLine = json_decode((string) $line, true);
            return $guardedJsonLine;
        }
    }

  
}
