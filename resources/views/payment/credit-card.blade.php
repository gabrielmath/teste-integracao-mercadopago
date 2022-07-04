@extends('layout.master')

@section('title', 'Cartão de Crédito')

@section('content')
  <h3>Forma de Pagamento - Cartão de crédtio</h3>
  <form id="form-checkout" class="row">
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"/>

    <div class="mt-2 col-12 col-sm-6">
      <div class="form-group">
        <div id="form-checkout__cardNumber-container" class="my-input"></div>
      </div>
    </div>

    <div class="mt-2 col-6 col-sm-3">
      <div class="form-group">
        <div id="form-checkout__expirationDate-container" class="my-input"></div>
      </div>
    </div>

    <div class="mt-2 col-6 col-sm-3">
      <div class="form-group">
        <div id="form-checkout__securityCode-container" class="my-input"></div>
      </div>
    </div>

    <div class="mt-2 col-12">
      <div class="form-group">
        <input type="text" name="cardholderName" id="form-checkout__cardholderName" class="form-control"/>
      </div>
    </div>

    <div class="mt-2 col-12">
      <div class="form-group">
        <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail" class="form-control"/>
      </div>
    </div>

    <div class="mt-2 col-12">
      <div class="form-group">
        <select name="issuer" id="form-checkout__issuer" class="form-control"></select>
      </div>
    </div>

    <div class="mt-2 col-5 col-sm-3">
      <div class="form-group">
        <select name="identificationType" id="form-checkout__identificationType" class="form-control"></select>
      </div>
    </div>

    <div class="mt-2 col-7 col-sm-9">
      <div class="form-group">
        <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" class="form-control"/>
      </div>
    </div>

    <div class="mt-2 col-12">
      <div class="form-group">
        <select name="installments" id="form-checkout__installments" class="form-control"></select>
      </div>
    </div>

    <div class="mt-2 col-12">
      <div class="form-group">
        <div class="d-grid gap-1">
          <button type="submit" id="form-checkout__submit" class="btn btn-success block">Pagar</button>
        </div>
      </div>
    </div>


    <progress value="0" class="progress-bar">Carregando...</progress>
  </form>
@endsection

@push('script')
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    const mp = new MercadoPago('{{ config('mercadopago.public_key') }}', {
      locale: 'pt-BR'
    });
    const cardForm = mp.cardForm({
      amount: '100.5',
      iframe: true,
      form: {
        id: 'form-checkout',
        _token: {
          id: '_token'
        },
        cardholderName: {
          id: 'form-checkout__cardholderName',
          placeholder: "Titular do cartão",
        },
        cardholderEmail: {
          id: 'form-checkout__cardholderEmail',
          placeholder: 'E-mail'
        },
        cardNumber: {
          id: 'form-checkout__cardNumber-container',
          placeholder: 'Número do cartão',
        },
        securityCode: {
          id: 'form-checkout__securityCode-container',
          placeholder: 'Código de segurança'
        },
        installments: {
          id: 'form-checkout__installments',
          placeholder: 'Parcelas'
        },
        expirationDate: {
          id: 'form-checkout__expirationDate-container',
          placeholder: 'Data de vencimento (MM/YYYY)',
        },
        identificationType: {
          id: 'form-checkout__identificationType',
          placeholder: 'Tipo de documento'
        },
        identificationNumber: {
          id: 'form-checkout__identificationNumber',
          placeholder: 'Número do documento'
        },
        issuer: {
          id: 'form-checkout__issuer',
          placeholder: 'Banco emissor'
        }
      },
      callbacks: {
        onFormMounted: function (error) {
          if (error) return console.log('Callback para tratar o erro: montando o cardForm ', error)
        },
        onSubmit: function (event) {
          event.preventDefault();


          const {
            _token: _token,
            paymentMethodId: payment_method_id,
            issuerId: issuer_id,
            cardholderEmail: email,
            amount,
            token,
            installments,
            identificationNumber,
            identificationType
          } = cardForm.getCardFormData();

          fetch('{{ route('payment.process.credit-card') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              token,
              issuer_id,
              payment_method_id,
              transaction_amount: Number(amount),
              installments: Number(installments),
              description: 'product description',
              payer: {
                email,
                identification: {
                  type: identificationType,
                  number: identificationNumber
                }
              }
            })
          })
            .then(response => response.json())
            .then(data => {
              console.log(data);
              if (data.status === 'approved') {
                window.location.href = '{{ route('payment.success') }}';
              }
            })
            .catch(error => console.log(error))
        },
        onFetching: function (resource) {
          console.log('fetching... ', resource)
          const progressBar = document.querySelector('.progress-bar')
          progressBar.removeAttribute('value')

          return () => {
            progressBar.setAttribute('value', '0')
          }
        }
      }
    });
  </script>
@endpush
