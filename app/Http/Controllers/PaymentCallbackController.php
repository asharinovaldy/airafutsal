<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    //
    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                Order::where('prefix', $order->prefix)->update([
                    'status' => 'Done',
                ]);
            }

            if ($callback->isExpire()) {
                Order::where('prefix', $order->prefix)->update([
                    'payment_status' => 'Unpaid',
                ]);
            }

            if ($callback->isCancelled()) {
                Order::where('prefix', $order->prefix)->update([
                    'payment_status' => 'Cancel',
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
