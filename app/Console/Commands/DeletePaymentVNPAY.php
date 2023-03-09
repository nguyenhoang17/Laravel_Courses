<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PaymentVNPAY;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeletePaymentVNPAY extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:delete-payment-vnpay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        try {
            $now = Carbon::now()->timestamp;
            $payments = PaymentVNPAY::where('status', PaymentVNPAY::STATUS['UNPAID'])->get();
            foreach ($payments as $payment) {
                $time = Carbon::createFromTimeString($payment->created_at)->timestamp;
                if ($now - $time > 600) {
                    $payment->order->delete();
                    $payment->delete();
                }
            }

        } catch (\Exception $e) {
            Log::error('Error delete overdue vnpay transaction', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
