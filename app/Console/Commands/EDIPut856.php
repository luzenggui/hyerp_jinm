<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Curl, Log;

class EDIPut856 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edi:put856 {asn_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put 856 data to customer FTP server.';

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
        $asn_id = $this->argument('asn_id');
        $response = Curl::to(config('custom.edi.url.put856') . '?asn_id=' . $asn_id)->get();
        Log::info($response);
    }
}
