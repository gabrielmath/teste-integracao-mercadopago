<?php

namespace App\Http\Controllers;

use App\Services\MercadoPago\MercadoPagoPayerData;
use App\Services\MercadoPago\MercadoPagoPaymentData;
use App\Services\MercadoPago\MercadoPagoService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function creditCard()
    {
        return view('payment.credit-card');
    }

    public function ticket()
    {
//        $mercadoPago = new MercadoPagoService();
//        $paymentMethods = $mercadoPago->paymentMethods();

        return view('payment.ticket');
    }

    public function processCreditCard(Request $request)
    {
        $payerData = new MercadoPagoPayerData(
            email: $request->payer['email'],
            identification: [
                'type'   => $request->payer['identification']['type'],
                'number' => $request->payer['identification']['number']
            ]
        );

        $paymentData = new MercadoPagoPaymentData(
            transactionAmount: (float)$request->transaction_amount,
            token: $request->token,
            description: $request->description,
            installments: (int)$request->installments,
            paymentMethodId: $request->payment_method_id,
            issuerId: (int)$request->issuer_id,
        );

        $payment = new MercadoPagoService();
        $payment->setPayment($paymentData, $payerData);

        if (!$payment->execute()) {
            return response()->json($payment->error());
        }

        return $payment->status();
//        return redirect()->route('payment.success');
    }

    public function processTicket(Request $request)
    {
        $payerData = new MercadoPagoPayerData(
            email: $request->payerEmail,
            identification: [
                'type'   => $request->docType,
                'number' => $request->docNumber
            ],
            firstName: $request->payerFirstName,
            lastName: $request->payerLastName
        );

        $paymentData = new MercadoPagoPaymentData(
            transactionAmount: (float)$request->transactionAmount,
            token: null,
            description: $request->productDescription,
            installments: null,
            paymentMethodId: $request->paymentMethodId,
            issuerId: null,
        );

        $payment = new MercadoPagoService();
        $payment->setPayment($paymentData, $payerData);

        if (!$payment->execute()) {
            return response()->json($payment->error());
        }

//        return $payment->status();

        $ticketLink = base64_encode($payment->status()['transaction_details']->external_resource_url);

        return redirect(url(route('payment.success')) . '?ticket_link=' . $ticketLink);
    }

    public function success()
    {
        return view('payment.success');
    }
}
