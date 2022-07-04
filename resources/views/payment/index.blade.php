@extends('layout.master')

@section('title','Selecione o método de pagamento')

@section('content')
  <h3 class="text-center p-3">Escolha abaixo o método de pagamento</h3>
  <div class="d-flex justify-content-center h-auto p-2">
    <a href="{{ route('payment.credit-card') }}" class="mx-2 btn btn-success">
      Cartão de Crédito
    </a>
    <a href="{{ route('payment.ticket') }}" class="mx-2 btn btn-success">
      Boleto
    </a>
  </div>
@endsection
