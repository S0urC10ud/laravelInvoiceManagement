@extends('app')
@if(isset($invoice))
    @section('title','Edit')
@else
    @section('title','Create')
@endif

@section('content')
    <div class="container pt-3" style="max-width: 40rem;">
        <form action="{{ isset($invoice) ? route('invoice.update', [$invoice->id]) : route('invoice.store') }}"
              method="post">
            @csrf
            @if(isset($invoice))
                @method('PUT')
            @endif
            <br>
            <div class="form-row">
                @if(isset($invoice))
                <div class="form-group col-md-4 mb-4">
                    <label for="id">Id</label>
                    <input name="id" maxlength="30" type="number" class="form-control"
                           value="{{ isset($invoice) ? $invoice->id : "" }}"
                           readonly>
                </div>
                @endif
                <div class="form-group {{isset($invoice) ? "col-md-8 mb-8" : "col-md-12 mb-12"}}">
                    <label for="name">Name</label>
                    <input name="name" maxlength="30" type="text" class="form-control"
                           value="{{ isset($invoice) ? $invoice->Name : "" }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4 mb-4">
                    <label for="pricenet">PriceNet</label>
                    <input name="pricenet" type="number" step="0.01" maxlength="30" class="form-control"
                           value="{{ isset($invoice) ? $invoice->PriceNet : "" }}">
                </div>

                <div class="form-group col-md-4 mb-4">
                    <label for="pricegross">PriceGross</label>
                    <input name="pricegross" type="number" step="0.01" maxlength="30" class="form-control"
                           value="{{ isset($invoice) ? $invoice->PriceGross : "" }}">
                </div>

                <div class="form-group col-md-4 mb-4">
                    <label for="vat">Vat</label>
                    <input name="vat" type="number" step="0.01" maxlength="30" class="form-control"
                           value="{{ isset($invoice) ? $invoice->Vat : "" }}">
                </div>
            </div>

            <a href="{{route('invoice.index')}}">
                <div class="btn btn-outline-danger float-left">Cancel</div>
            </a>
            <input type="submit" class="btn btn-dark float-right" value="{{isset($invoice) ?  "Edit invoice" : "Create invoice"}}">
        </form>
    </div>
@endsection
