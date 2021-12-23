<?php

namespace App\Http\Controllers;

use App\Http\Requests\TariffRequest;
use App\Models\Tariffs;
use App\Services\TariffsService;
use Illuminate\Http\Request;

class TariffsController extends Controller
{
    /**
     * success response method.
     *
     */
    public function index(TariffsService $tariffsService)
    {
        \SEOMeta::setTitle('Тариф');

        $currentTariff = $tariffsService->getCurrentTariff();
        return view('users.rates', [
            'data' => $tariffsService->get(),
            'tariff' => $currentTariff['result'],
            'tariff_user' => $currentTariff['tariff'],
            'status' => $tariffsService->getUserDocsAndPages()
        ]);
    }


    public function list(TariffsService $tariffsService)
    {
        \SEOMeta::setTitle('Список тарифов');

        return view('admin.tariffs_list', [
            'data' => $tariffsService->get(),
        ]);
    }

    public function detail(Tariffs $tariff)
    {
        \SEOMeta::setTitle('Тариф: ' . $tariff->name);
        $tariff->statistic = $tariff->getStatistic();
        return view('admin.tariff_add', [
            'data' => $tariff,
        ]);
    }

    public function update(Tariffs $tariff, TariffRequest $tariffRequest, TariffsService $tariffsService)
    {
        $tariff->fill($tariffRequest->all());
        $tariff->save();
        return redirect()->route('tariffs_list')->with('success', true);
    }

    public function post(Tariffs $tariff, TariffsService $tariffsService)
    {
        return $tariffsService->sendToPayment($tariff);
    }

    public function confirm(TariffsService $tariffsService, Request $request)
    {
       return $tariffsService->checkPaymentResponse($request->all());
    }


}
