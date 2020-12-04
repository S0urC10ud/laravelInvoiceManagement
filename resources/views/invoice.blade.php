<!DOCTYPE html>
<html lang="de">
<head>
    <style>
        th {
            width: 200px;
        }
        table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
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
        button, input {
            width: 8em;
            text-align: center;
        }


    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script>
        function deleteEntry(buttonId) {
            Swal.fire({
                icon:'warning',
                title: 'Attention',
                text: `Are you absolutely sure that you want to delete Invoice ${buttonId} ?`,
                confirmButtonText: 'Yeah!',
                cancelButtonText: 'Well... I changed my mind',
                showCancelButton: true
            }).then((result) => {
                if(!result.isConfirmed){
                    return;
                }
                axios.delete('/invoice/'+buttonId,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(()=>Swal.fire({
                    title: 'Success!',
                    icon:'success',
                    html: 'The item was deleted successfully',
                    timer: 2000,
                    timerProgressBar: true,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                    location.reload();
                }));
            });
        }
    </script>
</head>
<body>
<h1>Rechnungskontrolle</h1>

<form action="{{route('invoice.create')}}" method="get">
    @method('get')
    <input type="submit" value="Create new"/>
    @csrf
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>PriceNet</th>
        <th>PriceGross</th>
        <th>Vat</th>
        <th>UserClearing</th>
        <th>ClearingDate</th>
        <th>Action</th>
    </tr>
    @foreach ($invoiceData as $invoice)
        <tr>
            <td>{{$invoice->id}}</td>
            <td>{{$invoice->Name}}</td>
            <td>{{$invoice->PriceNet}}</td>
            <td>{{$invoice->PriceGross}}</td>
            <td>{{$invoice->Vat}}</td>
            <td>{{$invoice->UserClearing}}</td>
            <td>{{$invoice->ClearingDate}}</td>
            <td>
                <form action="{{route('invoice.show',$invoice->id)}}" method="get">
                    @method('get')
                    <input type="submit" value="&#128269;"/>
                    @csrf
                </form>
                <form action="{{route('invoice.edit',$invoice->id)}}" method="get">
                    @method('get')
                    <input type="submit" value="📝"/>
                    @csrf
                </form>
                <button onclick="deleteEntry({{$invoice->id}})">🗑️</button>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>
