@extends('layout.master')

@section('title','Obrigado!')

@section('content')
  <div class="card text-center border-success mt-5">
    <div class="card-header">
      Sucesso!
    </div>
    <div class="card-body text-success">
      <h5 class="card-title">Obrigado por comprar conosco!</h5>
      <p class="card-text">Agradecemos a preferência. Que essa seja a primeira de muitas outras!</p>
      @if(request()->has('ticket_link'))
        <a href="{{ base64_decode(request()->input('ticket_link')) }}" target="_blank" class="btn btn-primary">Imprimir
          Boleto</a>
      @endif
      <p>
        <a href="{{ route('payment.index') }}">Comprar novamente</a>
      </p>
    </div>
    <div class="card-footer text-muted">
      <small>Teste de Integração - MercadoPago</small>
    </div>
  </div>
@endsection
