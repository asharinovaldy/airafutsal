<?php

namespace App\Services\Midtrans;


use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans {
    protected $order;
    protected $fields;
    protected $user;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->prefix,
                'gross_amount' => $this->order->total_amount,
            ],
            // 'item_details' => [
            //     'id' => $this->fields->id,
            //     'price' => $this->fields->price,
            //     'quantity' => $this->order->duration,
            //     'name' => $this->fields->field_name
            // ],
            // 'customer_details' => [
            //     'first_name' => $this->user->name,
            //     'email' => $this->user->email,
            // ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}
