@extends('app')
@section('title','Show')
@section('customStyles')
<style>
    #footer{
        position: fixed !important;
        bottom: 0;
        width: 100%;
    }
</style>
@endsection
@section('content')
    <div class="container pt-3" style="max-width: 40rem;">
        <br>
        <div class="row justify-content-between">
            <div class="form-group col-md-4 mb-4 listedShowElement">
                Id <br/>
                <span>{{$invoice->id}}</span>
            </div>
            <div class="form-group {{isset($invoice) ? "col-md-7 mb-7" : "col-md-11 mb-11"}} listedShowElement">
                Name <br/>
                <span>{{$invoice->Name}}</span>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="form-group col-md-4 mb-4 listedShowElement">
                PriceNet<br/>
                <span class="currency">{{$invoice->PriceNet}}</span>
            </div>

            <div class="form-group col-md-4 mb-4 listedShowElement">
                PriceGross<br/>
                <span class="currency">{{$invoice->PriceGross}}</span>
            </div>

            <div class="form-group col-md-3 mb-3 listedShowElement">
                VAT<br/>
                <span class="currency">{{$invoice->Vat}}</span>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="form-group col-md-6 mb-6 listedShowElement">
                User clearing<br/>
                <span>{{$invoice->UserClearing}}</span>
            </div>

            <div class="form-group col-md-5 mb-6 listedShowElement">
                Clearing date<br/>
                <span>{{$invoice->ClearingDate}}</span>
            </div>
        </div>
        <div class="row float-right">
            <a class="btn btn-dark" style="margin-right: 1rem" href="{{route('invoice.edit',$invoice->id)}}">Edit</a>
            <button class="btn btn-danger" onclick="deleteEntry({{$invoice->id}})">Delete</button>
        </div>
    </div>
@endsection
