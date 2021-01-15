@extends('app')
@section('title','Invoice-List')

@section('customScripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('#invoiceDataTable tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" style="width: 12em" placeholder="Search ' + title + '" />');
            });

            $('#invoiceDataTable').DataTable(
                {
                    ajax: {
                        "url": "{{ route("getInvoiceData") }}",
                        "type": "GET"
                    },
                    columns: [
                        {
                            data: "id"
                        },
                        {
                            data: "Name",
                        },
                        {
                            data: "PriceNet"
                        },
                        {
                            data: "PriceGross"
                        },
                        {
                            data: "Vat"
                        },
                        {
                            data: "UserClearing"
                        },
                        {
                            data: "ClearingDate"
                        },
                        {
                            render: function (data, type, row) {
                                return `<a href="{{route('invoice.index')}}/${row.id}">
                                    <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">&#128269; Show</button>
                                </a>
                                <a href="{{route('invoice.index')}}/${row.id}/edit">
                                    <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">📝 Edit</button>
                                </a>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteEntry(${row.id})">🗑️ Delete</button>`
                            },
                            class: "dt-center"
                        },
                    ],
                    order: [[0, 'asc']],
                    autoWidth: false,
                    pageLength: 5,
                    processing: true,
                    serverSide: true,
                    "language": {
                        processing: '<div class="loader"></div>'
                    },
                    initComplete: function () {
                        // Apply the search
                        this.api().columns().every(function () {
                            var activeColumn = this;

                            $('input', this.footer()).on('keyup change clear', function () {
                                if (activeColumn.search() !== this.value) {
                                    activeColumn.search(this.value).draw();
                                }
                            });
                        })
                    }
                }
            );
        });
    </script>
@endsection

@section('customStyles')
    <link rel="stylesheet" href="/css/invoiceIndex.css"/>

@endsection

@section('content')

    <a href="{{route('invoice.create')}}" class="btn btn-success" style="margin: 2rem;">Create new invoice</a>
    <table id="invoiceDataTable">
        <thead>
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
        </thead>
        <tbody>
        </tbody>
        <tfoot>
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
        </tfoot>
    </table>
@endsection
