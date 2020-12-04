<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{ isset($invoice) ? route('invoice.update', [$invoice->id]) : route('invoice.store') }}" method="post">
    @csrf
    @if(isset($invoice))
        @method('PUT')
    @endif
    <br>

    <label for="name">Name</label>
    <input name="name" maxlength="30" value="{{ isset($invoice) ? $invoice->Name : "" }}">

    <label for="pricenet">PriceNet</label>
    <input name="pricenet" maxlength="30" value="{{ isset($invoice) ? $invoice->PriceNet : "" }}">

    <label for="pricegross">PriceGross</label>
    <input name="pricegross" maxlength="30" value="{{ isset($invoice) ? $invoice->PriceGross : "" }}">

    <label for="vat">Vat</label>
    <input name="vat" maxlength="30" value="{{ isset($invoice) ? $invoice->Vat : "" }}">

    <input type="submit" value="Rechnung erstellen">
</form>
</body>
</html>
