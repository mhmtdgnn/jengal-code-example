<?php

namespace App\Jobs;

use App\Models\YeniGibiAl\Order;
use App\Models\YeniGibiAl\OrderHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Str;

class YGACargoManagement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();
        foreach ($this->data['rows'] as $row) {
            $mok = Str::startsWith($row['mok'], ['202']);
            if ($mok) {
                Order::where('order_id', $row['mok'])->whereIn('order_status_id', [2,15])->update(
                    [
                        'order_status_id' => 4,
                        'kargo_firmasi' => 'ARAS',
                        'kargo_kodu' => $row['kargo_takip_no']
                    ]
                );

                $history = new OrderHistory();
                $history->order_id = $row['mok'];
                $history->order_status_id = 4;
                $history->notify = 1;
                $history->comment = $row['kargo_takip_no'];
                $history->save();
            }
        }
    }
}
