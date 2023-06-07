<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVerimorSms implements ShouldQueue
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
        $message = '';
        
        if ($this->data->fields->Transfer_Yontemi == 'UPS Kargo') {
            $message = 'Sayın müşterimiz '.$this->data->fields->Siparis_Kodu.' nolu siparişiniz UPS Kargoya verilmiştir. Kargo hareketlerini aşağıdaki linkten takip edebilirsiniz. İyi günler dileriz. https://portal.bicozum.com/order-tracking/'.$this->data->fields->Siparis_Kodu;
        } 
        
        if ($this->data->fields->Transfer_Yontemi == 'Biçözüm Kurye') {
            $message = 'Sayın müşterimiz, Siparişiniz BiÇözüm ekibine teslim edilmiştir. Siparişinizin durumunu 0850 255 5545 numarasından yada aşağıdaki linkten sorgulayabilirsiniz. İyi günler dileriz. https://portal.bicozum.com/order-tracking/'.$this->data->fields->Siparis_Kodu;
        }

        app('App\Http\Controllers\TransportRequestController')->verimorSendSms(
            $this->data->fields->Musteri_Telefon,
            $message
        );
    }
}
