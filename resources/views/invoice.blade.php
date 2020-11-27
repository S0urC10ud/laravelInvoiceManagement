<!DOCTYPE html>
<html lang="de">
<head>
    <style>
        th {
            width: 200px;
        }
    </style>
</head>
<body>
<h1>Rechnungskontrolle</h1>
<table>
    <tr>
        <th>ID</th>
        <th>PriceNet</th>
        <th>PriceGross</th>
        <th>Vat</th>
        <th>UserClearing</th>
        <th>ClearingDate</th>
    </tr>
    @foreach ($invoiceData as $invoice)
        <tr>
            <td>{{$invoice->id}}</td>
            <td>{{$invoice->PriceNet}}</td>
            <td>{{$invoice->PriceGross}}</td>
            <td>{{$invoice->Vat}}</td>
            <td>{{$invoice->UserClearing}}</td>
            <td>{{$invoice->ClearingDate}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
