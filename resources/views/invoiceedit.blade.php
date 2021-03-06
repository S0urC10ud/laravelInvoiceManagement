@extends('app')
@if(isset($invoice))
    @section('title','Edit')
@else
    @section('title','Create')
@endif

@section('customScripts')
    <script>
        $(document).ready(() => {
            $("#userClearingInput, #nameInput").inputFilter(function (value) {
                return /^-?[a-zA-Zöüä\s\-.]*$/.test(value); // Dash for second firstname and dot for older styled names
            });
            axios.get("{{route('getUsersClearing')}}").then((result) => {
                usersClearing = result.data;
                $("#userClearingInput").autocomplete({
                    source: usersClearing
                });
            });
        });
        //Number constraints are already applied by the Autonumeric-Library
    </script>
@endsection

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
                    <input id="nameInput" name="name" maxlength="30" type="text" class="form-control"
                           value="{{ isset($invoice) ? $invoice->Name : "" }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 mb-12">
                    <label for="userclearing">UserClearing</label>
                    <input id="userClearingInput" name="userclearing" maxlength="30" type="text" class="form-control"
                           value="{{ isset($invoice) ? $invoice->UserClearing : "" }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4 mb-4">
                    <label for="pricenet">PriceNet</label>
                    <input name="pricenet" type="text" step="0.01" maxlength="30" class="form-control currency"
                           value="{{ isset($invoice) ? $invoice->PriceNet : "" }}">
                </div>

                <div class="form-group col-md-4 mb-4">
                    <label for="pricegross">PriceGross</label>
                    <input name="pricegross" type="text" step="0.01" maxlength="30" class="form-control currency"
                           value="{{ isset($invoice) ? $invoice->PriceGross : "" }}">
                </div>

                <div class="form-group col-md-4 mb-4">
                    <label for="vat">Vat</label>
                    <input name="vat" type="text" step="0.01" maxlength="30" class="form-control currency"
                           value="{{ isset($invoice) ? $invoice->Vat : "" }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 mb-12">
                    <label for="clearingdate">Clearing-Date</label>
                    <input name="clearingdate" type="date" class="form-control"
                           value="{{ isset($invoice) ? \Carbon\Carbon::parse($invoice->ClearingDate)->format('Y-m-d') : "" }}">
                </div>
            </div>

            <a href="{{route('invoice.index')}}">
                <div class="btn btn-outline-danger float-left">Cancel</div>
            </a>
            <input type="submit" class="btn btn-dark float-right"
                   value="{{isset($invoice) ?  "Edit invoice" : "Create invoice"}}">
        </form>
    </div>
@endsection
