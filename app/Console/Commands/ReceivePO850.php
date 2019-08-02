<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage, Mail;

class ReceivePO850 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receive:po850';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive PO information from customer. 850 data.';

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
        Mail::send('shipment.shipments.shipmenttracking_mail', [], function ($message) {
            $message->to('260822310@qq.com', '123')->subject('zhuti');
        });
        return;

        $exists = Storage::disk('local')->exists('PO_SAMPLE_4816249.002823068');
        if ($exists)
        {
            $contents = Storage::get('PO_SAMPLE_4816249.002823068');
            $lines = explode("\n", $contents);
            $data = [];
            foreach ($lines as $line)
            {
                if (trim($line) == "") continue;

                $cols = explode("*", $line);
                $this->info(json_encode($cols));

                if (count($cols) > 0 && strlen($cols[0]) > 0)
                {
                    if ($cols[0] == "ISA" && count($cols) > 16)
                    {
                        $data = [];     // clear data

                        $data['interchange_sender_id'] = trim($cols[6]);
                        $data['interchange_receiver_id'] = trim($cols[8]);
//                        $data['interchange_datetime'] = Carbon::parse(trim($cols[9]))->toDateTimeString();
//                        $data['interchange_datetime'] = trim($cols[9]) . trim($cols[10]);
                        $data['interchange_datetime'] = Carbon::createFromFormat('ymdHi', trim($cols[9]) . trim($cols[10]))->toDateTimeString(); //'1808171823'
                        $data['interchange_control_number'] = trim($cols[13]);
                        $data['test_indicator'] = trim($cols[15]);
                    }
                }

                if (count($cols) > 0 && strlen($cols[0]) > 0)
                {
                    if ($cols[0] == "GS" && count($cols) > 8)
                    {
                        $data['data_interchange_datetime'] = Carbon::createFromFormat('YmdHis', trim($cols[4]) . trim($cols[5]))->toDateTimeString();   // 20180817182346
                    }
                }

                if (count($cols) > 0 && strlen($cols[0]) > 0)
                {
                    if ($cols[0] == "ST" && count($cols) > 2)
                    {
                        $data['transaction_set_control_no'] = trim($cols[2]);
                    }
                }

                if (count($cols) > 0 && strlen($cols[0]) > 0)
                {
                    if ($cols[0] == "IEA" && count($cols) > 2)
                    {
                        $this->info(json_encode($data));
                    }
                }

            }
        }
    }
}
