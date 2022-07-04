<?php

namespace App\Services\MercadoPago;

use App\Services\PaymentInterface;
use Illuminate\Support\Facades\Http;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;

class MercadoPagoService implements PaymentInterface
{
    private string $accessToken;
    private string $publicKey;
    private Payer $payer;
    private Payment $payment;

    public function __construct()
    {
        $this->accessToken = config('mercadopago.access_token');
        $this->publicKey = config('mercadopago.public_key');
        $this->initialize();
    }

    private function initialize(): void
    {
        SDK::setAccessToken($this->accessToken);
        SDK::setPublicKey($this->publicKey);
    }

    public function paymentMethods()
    {
        return Http::withToken($this->accessToken)->get('https://api.mercadopago.com/v1/payment_methods')->json();
    }

    public function setPayment(MercadoPagoPaymentData $paymentData, MercadoPagoPayerData $payerData): MercadoPagoService
    {
        $this->payment = new Payment();
        $this->payment->transaction_amount = $paymentData->transactionAmount();
        $this->payment->description = $paymentData->description();
        $this->payment->payment_method_id = $paymentData->paymentMethodId();

        if ($paymentData->token()) {
            $this->payment->token = $paymentData->token();
        }

        if ($paymentData->issuerId()) {
            $this->payment->issuer_id = $paymentData->issuerId();
        }

        if ($paymentData->installments()) {
            $this->payment->installments = $paymentData->installments();
        }

        $this->setPayer($payerData);
        $this->payment->payer = $this->payer;

        return $this;
    }

    public function execute()
    {
        return $this->payment->save();
    }

    public function status(): array
    {
        return [
            'status'              => $this->payment->status,
            'status_detail'       => $this->payment->status_detail,
            'id'                  => $this->payment->id,
            'date_approved'       => $this->payment->date_approved,
            'payer'               => $this->payment->payer,
            'payment_method_id'   => $this->payment->payment_method_id,
            'payment_type_id'     => $this->payment->payment_type_id,
            'refunds'             => $this->payment->refund(),
            'transaction_details' => $this->payment->transaction_details
        ];
    }

    public function error()
    {
        return $this->payment->Error();
    }

    private function setPayer(MercadoPagoPayerData $payerData): MercadoPagoService
    {
        $this->payer = new Payer();
        $this->payer->first_name = $payerData->firstName();
        $this->payer->last_name = $payerData->lastName();
        $this->payer->email = $payerData->email();
        $this->payer->identification = $payerData->identification();
        return $this;
    }
}
