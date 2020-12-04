<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Showing an Invoice</title>
</head>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>PriceNet</th>
        <th>PriceGross</th>
        <th>Vat</th>
        <th>UserClearing</th>
        <th>ClearingDate</th>
        <th>Actions</th>
    </tr>
    <tr>
        <td>{{$invoice->Name}}</td>
        <td>{{$invoice->PriceNet}}</td>
        <td>{{$invoice->PriceGross}}</td>
        <td>{{$invoice->Vat}}</td>
        <td>{{$invoice->UserClearing}}</td>
        <td>
            <form action="{{ url('/invoice', ['id' => $invoice->id]) }}" method="post">
                <input class="btn btn-default" type="submit" value="Delete"/>
                @method('delete')
                @csrf
            </form>
        </td>
    </tr>
</table>
</body>
</html>
