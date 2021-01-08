<html lang="en">
<head>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script>
        function deleteEntry(buttonId) {
            Swal.fire({
                icon: 'warning',
                title: 'Attention',
                text: `Are you absolutely sure that you want to delete Invoice ${buttonId} ?`,
                confirmButtonText: 'Yeah!',
                cancelButtonText: 'Nope',
                showCancelButton: true
            }).then((result) => {
                if (!result.isConfirmed)
                    return;
                axios.delete('/invoice/' + buttonId, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(() => Swal.fire({
                    title: 'Success!',
                    icon: 'success',
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

                    window.location.replace("{{route('invoice.index')}}");
                }));
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    @section('customScripts')
    @show

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"/>
    <style>
        button, input {
            width: 8em;
        }

        .listedShowElement {
            border-bottom: 2px #959595 solid;
            box-shadow: 4px 4px 10px #d0d0d0;
            height: 3.5rem !important;
            color: #535353;
            font-size: .9rem;
        }

        .listedShowElement span {
            font-size: 1.2rem;
            padding-left: 2%;
            color: black;
        }


        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #wrap {
            min-height: 100%;
        }

        #main {
            overflow: auto;
            padding-bottom: 5em;
        }


        #footer {
            position: relative;
            margin-top: -3em;
            height: 3em;
            clear: both;
            line-height: 3em;
            vertical-align: center;
        }

        /*Opera Fix*/
        body:before { /* thanks to Maleika (Kohoutec)*/
            content: "";
            height: 100%;
            float: left;
            width: 0;
            margin-top: -32767px; /* thank you Erik J - negate effect of float*/
        }

    </style>
    @section('customStyles')
    @show
    <title>Rechnungsverwaltung - @yield('title')</title><!-- Yield ist immer eine Vorlage -->
</head>
<body>
<div id="wrap">
    <div id="main">
        @section('header')
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand" href="{{route('invoice.index')}}">
                    🧾 Invoice-Management<span style="margin-left: 2rem; margin-right: 2rem;">|</span>
                    <span style="color:lightgrey;">@yield('title')</span>
                </a>
            </nav>@show

        <div class="mainContainer" style="overflow: auto">
            @yield('content')
        </div>
    </div>
</div>
<div id="footer" class="font-small bg-dark navbar-fixed-bottom">
    <div class="text-center" style="color:#afafaf;">{{Carbon\Carbon::now()->format('d.m.Y')}} | <a
            style="color: white;" href="{{route('imprint')}}">Legal Notice (Imprint)</a></div>
</div>
</body>
</html>
