<?php

namespace App\Services\MercadoPago;

class MercadoPagoPaymentData
{
    public function __construct(
        private ?float $transactionAmount,
        private ?string $token,
        private ?string $description,
        private ?int $installments,
        private ?string $paymentMethodId,
        private ?int $issuerId,
    ) {
    }

    /**
     * @return float|null
     */
    public function transactionAmount(): ?float
    {
        return $this->transactionAmount;
    }

    /**
     * @param float|null $transactionAmount
     * @return MercadoPagoPaymentData
     */
    public function setTransactionAmount(?float $transactionAmount): MercadoPagoPaymentData
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function token(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return MercadoPagoPaymentData
     */
    public function setToken(?string $token): MercadoPagoPaymentData
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return MercadoPagoPaymentData
     */
    public function setDescription(?string $description): MercadoPagoPaymentData
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function installments(): ?int
    {
        return $this->installments;
    }

    /**
     * @param int|null $installments
     * @return MercadoPagoPaymentData
     */
    public function setInstallments(?int $installments): MercadoPagoPaymentData
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function paymentMethodId(): ?string
    {
        return $this->paymentMethodId;
    }

    /**
     * @param string|null $paymentMethodId
     * @return MercadoPagoPaymentData
     */
    public function setPaymentMethodId(?string $paymentMethodId): MercadoPagoPaymentData
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function issuerId(): ?int
    {
        return $this->issuerId;
    }

    /**
     * @param int|null $issuerId
     * @return MercadoPagoPaymentData
     */
    public function setIssuerId(?int $issuerId): MercadoPagoPaymentData
    {
        $this->issuerId = $issuerId;
        return $this;
    }
}
