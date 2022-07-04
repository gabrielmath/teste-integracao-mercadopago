<?php

namespace App\Services\MercadoPago;

class MercadoPagoPayerData
{
    public function __construct(
        private $email,
        private array $identification,
        private ?string $firstName = null,
        private ?string $lastName = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function firstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return MercadoPagoPayerData
     */
    public function setFirstName(?string $firstName = null): MercadoPagoPayerData
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function lastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return MercadoPagoPayerData
     */
    public function setLastName(?string $lastName = null): MercadoPagoPayerData
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return MercadoPagoPayerData
     */
    public function setEmail($email): MercadoPagoPayerData
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return array
     */
    public function identification(): array
    {
        return $this->identification;
    }

    /**
     * @param array $identification
     * @return MercadoPagoPayerData
     */
    public function setIdentification(array $identification): MercadoPagoPayerData
    {
        $this->identification = $identification;
        return $this;
    }

}
