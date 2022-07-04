@extends('layout.master')

@section('title','Boleto Bancário')

@section('content')
  <form action="{{ route('payment.process.ticket') }}" method="post" id="paymentForm">
    @csrf
    <h3>Forma de Pagamento - Boleto</h3>
    <div>
      <input type="hidden" id="paymentMethodId" name="paymentMethodId" value="bolbradesco">
      <input type="hidden" id="paymentTypeId" name="paymentTypeId" value="ticket">
    </div>
    <h4>Detalhe do comprador</h4>
    <div class="row">
      <div class="col-12 col-sm-6 mt-2">
        <div class="form-group">
          <label for="payerFirstName">Nome</label>
          <input class="form-control" id="payerFirstName" name="payerFirstName" type="text" placeholder="Nome">
        </div>
      </div>

      <div class="col-12 col-sm-6 mt-2">
        <div class="form-group">
          <label for="payerLastName">Sobrenome</label>
          <input class="form-control" id="payerLastName" name="payerLastName" type="text" placeholder="Sobrenome">
        </div>
      </div>

      <div class="col-12 mt-2">
        <div class="form-group">
          <label for="payerEmail">E-mail</label>
          <input class="form-control" id="payerEmail" name="payerEmail" type="text" placeholder="test@test.com">
        </div>
      </div>

      <div class="col-5 col-sm-3 mt-2">
        <div class="form-group">
          <label for="docType">Tipo de documento</label>
          <select class="form-control" id="docType" name="docType" data-checkout="docType" type="text"></select>
        </div>
      </div>

      <div class="col-7 col-sm-9 mt-2">
        <div class="form-group">
          <label for="docNumber">Número do documento</label>
          <input class="form-control" id="docNumber" name="docNumber" data-checkout="docNumber" type="text">
        </div>
      </div>

      <div class="col-12 mt-2">
        <div class="form-group">
          <input type="hidden" name="transactionAmount" id="transactionAmount" value="100">
          <input type="hidden" name="productDescription" id="productDescription" value="Nome do Produto">
          <div class="d-grid gap-1">
            <button type="submit" class="btn btn-success">Pagar</button>
          </div>
        </div>
      </div>

    </div>
  </form>
@endsection

@push('script')
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    let mp = new MercadoPago("{{ config('mercadopago.public_key') }}");
    // Step #getIdentificationTypes
    getIdentificationTypes();

    // Helper function to append option elements to a select input
    function createSelectOptions(elem, options, labelsAndKeys = {label: "name", value: "id"}) {
      const {label, value} = labelsAndKeys;

      elem.options.length = 0;

      const tempOptions = document.createDocumentFragment();

      options.forEach(option => {
        const optValue = option[value];
        const optLabel = option[label];

        const opt = document.createElement('option');
        opt.value = optValue;
        opt.textContent = optLabel;

        tempOptions.appendChild(opt);
      });

      elem.appendChild(tempOptions);
    }

    // Get Identification Types
    // (async function getIdentificationTypes() {
    //   try {
    //     const identificationTypes = await mp.getIdentificationTypes();
    //     const docTypeElement = document.getElementById('docType');
    //
    //     createSelectOptions(docTypeElement, identificationTypes)
    //   } catch (e) {
    //     return console.error('Error getting identificationTypes: ', e);
    //   }
    // })()

    async function getIdentificationTypes() {
      try {
        const identificationTypes = await mp.getIdentificationTypes();
        const docTypeElement = document.getElementById('docType');

        createSelectOptions(docTypeElement, identificationTypes)
      } catch (e) {
        return console.error('Error getting identificationTypes: ', e);
      }
    }
  </script>
@endpush
