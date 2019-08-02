<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use Log;

class EDIGet850 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edi:get850';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get 850 data from customer FTP server.';

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
        //
        $response = Curl::to(config('custom.edi.url.get850'))->get();
        Log::info($response);
    }
}
