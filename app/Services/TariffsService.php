<?php

namespace App\Services;

use App\Models\Documents;
use App\Models\Pages;
use App\Models\PaymentRequest;
use App\Models\Tariffs;
use App\Models\TariffsUserBlocks;
use App\Models\VariantBlocks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TariffsService
{

    public function get()
    {
        $arVariants = [];
        $variants = VariantBlocks::get();
        foreach ($variants as $variant) {
            if (isset($variant->tariffs) && $variant->tariffs && is_array($variant->tariffs)) {
                foreach ($variant->tariffs as $tariff) {
                    $arVariants[$tariff][] = $variant;
                }
            }
        }
        return Tariffs::get()->each(function ($item) use ($arVariants) {
            $variants = collect($arVariants[$item->id] ?? []);
            $item->statistic = [
                'variants' => $variants->count(),
                'blocks' => $variants->pluck('block_id')->unique()->count(),
            ];
        });
    }

    public function setTariffToUser($tariffId, $userId)
    {
        TariffsUserBlocks::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'tariff' => $tariffId,
                'active_to' => Carbon::now()->addMonth()
            ]
        );
    }

    public function sendToPayment(Tariffs $tariff)
    {
        if($tariff->price>0){
            $mrh_login = env('ROBOKASSA_ID');
            $mrh_pass1 = env('ROBOKASSA_PASS_1');
            $inv_id = PaymentRequest::create([
                'sum' => $tariff->price,
                'user_id' => Auth::id(),
                'tariff_id' => $tariff->id
            ])->id;
            $inv_desc = sprintf('%s %s', Auth::user()->email, $tariff->name);   // invoice desc
            $out_summ = $tariff->price;
            $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");

            $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=$mrh_login&" .
                "OutSum=$out_summ&InvId=$inv_id&Description=$inv_desc&SignatureValue=$crc&IsTest=1";

            return redirect($url);
        }else{
            $this->setTariffToUser($tariff->id, Auth::id());
            return redirect()->back();
        }

    }

    public function checkPaymentResponse($arData)
    {
        if(isset($arData["SignatureValue"])){
            $mrh_pass1 = env('ROBOKASSA_PASS_1');
            $out_summ = $arData["OutSum"];
            $inv_id = $arData["InvId"];
            $crc = strtoupper($arData["SignatureValue"]);
            $paymentRequest = PaymentRequest::find($inv_id);
            $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
            if ($paymentRequest && $my_crc == $crc) {
                $this->setTariffToUser($paymentRequest->tariff_id, $paymentRequest->user_id);
            }else{
                echo "bad sign\n";
                exit();
            }
            echo "OK$inv_id\n";
            return '';
        }else{
            return redirect()->route('documents.index');
        }


    }
    public function checkTariffs(){
        TariffsUserBlocks::where('active_to', '<',Carbon::now()->format('Y-m-d H:i:s'))->each(function ($item){
            $item->update([
                'tariff'=>Tariffs::where('default', true)->first()->id??1,
                'active_to'=>null
            ]);
        });
    }

    public function getCurrentTariff()
    {
        $tariffs = TariffsUserBlocks::where('user_id', \Auth::user()->id)->where('active_to', '>',
            Carbon::now()->format('Y-m-d H:i:s'))->first();

        if ($tariffs) {
            $result = Tariffs::find($tariffs->tariff);
        } else {
            $result = Tariffs::where('default', true)->first();
        }

        return ['result' => $result, 'tariff' => $tariffs];
    }

    public function getUserDocsAndPages()
    {
        $pagesCount = 0;
        $documents = Documents::where('user_id', \Auth::user()->id);
        $docsCount = $documents->count();

        foreach ($documents->get() as $document) {
            $pagesCount = $pagesCount + $document->pagesCount();
        }

        return ['docs' => $docsCount, 'pages' => $pagesCount];
    }

}
