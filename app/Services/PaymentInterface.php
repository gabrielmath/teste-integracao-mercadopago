<?php

namespace App\Services;

interface PaymentInterface
{
    public function execute();

    public function status(): array;

    public function error();
}
