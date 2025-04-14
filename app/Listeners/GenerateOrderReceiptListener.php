<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateOrderReceiptListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaidEvent $event): void
    {
       try {
        $order = $event->order;

        // Generate PDF receipt
        $pdf = Pdf::loadView('receipts.order', ['order' => $order]);
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width thermal paper
        // Save the PDF
        $filename = 'receipt_' . $order->order_number . '.pdf';
        // Ensure the directory exists
        $this->ensureDirectoryExists(storage_path('app/public/receipts/'));
        
        $pdf->save(storage_path('app/public/receipts/' . $filename));
       } catch (Exception $e) {
           Log::error($e->getMessage());
           dd($e->getMessage());
       }
    }

    private function ensureDirectoryExists($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}