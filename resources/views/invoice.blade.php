@extends('app')
@section('title','Invoice-List')

@section('customScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous"></script>
    <script>
        var usersClearing = null;

        function setUserClearing(id, UserClearingName) {
            axios.put(`{{route('updateUserClearing')}}`, {id: id, UserClearing: UserClearingName})
                .then(() => dataTable.ajax.reload());
        }

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

            const currencyRenderer = function (data, type, row) {
                return `<div class="currency">${data}</div>`;
            }

            let dataTable = $('#invoiceDataTable').DataTable(
                {
                    ajax: {
                        "url": "{{ route("getInvoiceData") }}",
                        "type": "GET"
                    },
                    columns: [
                        {
                            data: "id",
                            render: function (data, type, row) {
                                return `<a href="{{route('invoice.index')}}/${row.id}/edit">${row.id}</a>`;
                            }
                        },
                        {
                            data: "Name",
                        },
                        {
                            data: "PriceNet",
                            render: currencyRenderer
                        },
                        {
                            data: "PriceGross",
                            render: currencyRenderer
                        },
                        {
                            data: "Vat",
                            render: currencyRenderer
                        },
                        {
                            data: "UserClearing",
                            render: function (data, type, row) {
                                if (data === null)
                                    return `<div class="userClearingGroup">
                                                <input type="value" id="userClearing-${row.id}" placeholder="Not set"
                                                onfocusin="$('#saveUserClearing-${row.id}').fadeIn().css('display','inline-block')"
                                                onfocusout="$('#saveUserClearing-${row.id}').fadeOut()"/>
                                                <div id="saveUserClearing-${row.id}" style="display: none; cursor:pointer;" onclick="setUserClearing(${row.id}, $('#userClearing-${row.id}').val());">💾</div>
                                            </div>`;
                                else
                                    return data;
                            }
                        },
                        {
                            data: "ClearingDate",
                            render: function (data, type, row) {
                                return moment(row.ClearingDate).format('DD.MM.yyyy');
                            }

                        },
                        {
                            data: "id",
                            render: function (data, type, row) {
                                return `<a href="{{route('invoice.index')}}/${row.id}">
                                            <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">&#128269; Show</button>
                                        </a>
                                        <a href="{{route('invoice.index')}}/${row.id}/edit">
                                            <button class="btn btn-outline-dark btn-sm" style="margin-bottom: 5px;">📝 Edit</button>
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteEntry(${row.id})">🗑️ Delete</button>`;
                            },
                            class: "dt-center"
                        },
                    ],
                    columnDefs: [
                        {
                            "targets": "_all",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                if (rowData.UserClearing === null)
                                    $(td).css("background-color", '#ffa2a2');
                            }
                        },
                    ],
                    order: [[0, 'asc']],
                    autoWidth: false,
                    pageLength: 5,
                    processing: true,
                    serverSide: true,
                    language: {
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
                    },
                    drawCallback: function () {
                        new AutoNumeric.multiple('.currency', {
                            digitGroupSeparator: '.',
                            decimalCharacter: ',',
                            decimalCharacterAlternative: '.',
                            currencySymbol: '\u202f€',
                            currencySymbolPlacement: AutoNumeric.options.currencySymbolPlacement.suffix,
                            roundingMethod: AutoNumeric.options.roundingMethod.halfUpSymmetric,
                            unformatOnSubmit: true
                        });
                        $(".userClearingGroup input").inputFilter(function (value) {
                            return /^[a-zA-Zöüä\s\-.]*$/.test(value); // Dash for second firstname and dot for older styled names
                        });

                        if (usersClearing == null) {
                            axios.get("{{route('getUsersClearing')}}").then((result) => {
                                usersClearing = result.data;
                                $(".userClearingGroup input").autocomplete({
                                    source: usersClearing
                                });
                            });
                        } else
                            $(".userClearingGroup input").autocomplete({
                                source: usersClearing
                            });
                    }
                }
            );

            window.dataTable = dataTable;

            $(function () {
                $.contextMenu({
                    selector: 'tr',
                    trigger: 'right',
                    callback: function (key, options) {
                        var id = dataTable.row(options.$trigger).data().id;
                        switch (key) {
                            case 'delete':
                                deleteEntry(id);
                                break;
                            case 'edit':
                                window.location.href = `{{route('invoice.index')}}/${id}/edit`;
                                break;
                            case 'create':
                                window.location.href = `{{route('invoice.create')}}`;
                                break;
                        }
                    },
                    items: {
                        'delete': {name: 'Delete', icon: 'delete'},
                        'create': {name: 'Create', icon: 'add'},
                        'edit': {name: 'Edit', icon: 'edit'}
                    }
                });
            });
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
        <!--Duplicated "headers" for search at the bottom:-->
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
