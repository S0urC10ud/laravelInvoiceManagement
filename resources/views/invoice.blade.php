@extends('app')
@section('title','Invoice-List')

@section('customStyles')
    <style>
        th {
            width: 200px;
        }

        table {
            border-collapse: collapse;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            width: 100%;
        }

        table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
        }

        table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
    </style>
@endsection

@section('content')

    <a href="{{route('invoice.create')}}" class="btn btn-success" style="margin: 2rem;">Create new invoice</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>PriceNet</th>
            <th>PriceGross</th>
            <th>Vat</th>
            <th>UserClearing</th>
            <th>ClearingDate</th>
            <th>Actions</th>
        </tr>

        @php
            $formatter = new NumberFormatter('de_DE',  NumberFormatter::CURRENCY)
        @endphp
        @foreach ($invoiceData as $invoice)
            <tr>
                <td>{{$invoice->id}}</td>
                <td>{{$invoice->Name}}</td>
                <td>{{$formatter->formatCurrency($invoice->PriceNet,'EUR')}}</td>
                <td>{{$formatter->formatCurrency($invoice->PriceGross,'EUR')}}</td>
                <td>{{$formatter->formatCurrency($invoice->Vat,'EUR')}}</td>
                <td>{{$invoice->UserClearing}}</td>
                <td>{{$invoice->ClearingDate}}</td>
                <td>
                    <a href="{{route('invoice.show',$invoice->id)}}">
                        <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">&#128269; Show</button>
                    </a>
                    <a href="{{route('invoice.edit',$invoice->id)}}">
                        <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">📝 Edit</button>
                    </a>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteEntry({{$invoice->id}})">🗑️ Delete
                    </button>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
