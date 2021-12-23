<?php

namespace App\Console\Commands;

use App\Services\TariffsService;
use Illuminate\Console\Command;

class CheckTariffs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tariff:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking tariff activity';

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
     * @param TariffsService $tariffsService
     * @return int
     */
    public function handle(TariffsService $tariffsService)
    {
        $tariffsService->checkTariffs();
        return Command::SUCCESS;
    }
}
