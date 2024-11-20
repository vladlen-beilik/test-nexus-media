<?php

namespace App\Services;

use App\Models;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ShopifyService
{
    private ?string $apiKey;
    private ?string $password;
    private ?string $shop;
    private ?string $version;
    private string $exception = "You need to add `SHOPIFY_API_KEY`, `SHOPIFY_PASSWORD` and `SHOPIFY_SHOP` to your .env to continue.";

    public function __construct(string $version)
    {
        $this->apiKey = config('shopify.api_key');
        $this->password = config('shopify.password');
        $this->shop = config('shopify.shop');
        $this->version = $version;
    }

    /**
     * @throws Exception
     */
    public function getAll(): void
    {
        if(empty($this->apiKey) || empty($this->password) || empty($this->shop)) throw new Exception($this->exception);

        $response = Http::withBasicAuth($this->apiKey, $this->password)
            ->baseUrl("https://$this->shop/admin/api/$this->version")
            ->get('orders.json');

        if ($response->ok()) {
            DB::transaction(function () use ($response) {
                collect($response->json('orders'))->map(function ($order) {

                    if(isset($order['customer'])) {
                        $customer = Models\Customer::firstOrCreate([
                            'foreign_id' => $order['customer']['id'],
                        ], [
                            'first_name' => $order['customer']['first_name'],
                            'last_name' => $order['customer']['last_name'],
                            'email' => $order['customer']['email'],
                            'foreign_created_at' => $order['customer']['created_at'],
                            'foreign_updated_at' => $order['customer']['updated_at'],
                        ]);
                    }

                    $order = Models\Order::firstOrCreate([
                        'foreign_id' => $order['id'],
                    ], [
                        'customer_id' => $customer->id ?? null,
                        'total_price' => $order['total_price'],
                        'financial_status' => $order['financial_status'],
                        'fulfillment_status' => $order['fulfillment_status'],
                        'foreign_created_at' => $order['created_at'],
                        'foreign_updated_at' => $order['updated_at'],
                    ]);
                });
            });
        }
    }
}
