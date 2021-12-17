@extends('layouts.sidebar')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4>Printer</h4>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h3>Printer List</h3>
                <div class="row">
                    <div class="card card-body">
                        <div style="float: left">
                        </div><br>
                        <div style="float: right">
                            <a href="/printer/addprinter" class="btn btn-smrs" style="width: 20%; float: right">Add New</a>
                        </div><br>
                        <table id="allPrinter" class="table table-bordered table-striped">
                            <thead class="table-smrs">
                                <tr>
                                    <th>#</th>
                                    <th>Mac Address</th>
                                    <th>Label Tag</th>
                                    <th>Type</th>
                                    <th>Branch ID</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( !empty($printers) ){ ?>
                                <?php foreach( $printers as $printer ){?>
                                <tr>
                                    <td>{{ $printer->id }}</td>
                                    <td>{{ $printer->mac_address }}</td>
                                    <td>{{ $printer->label }}</td>
                                    <td>{{ $printer->type }}</td>
                                    <td>{{ $printer->branch->code }} ({{ $printer->branch->name }})</td>
                                    @if ($printer->status == 1)
                                        <td>Active</td>
                                    @else
                                        <td>Inactive</td>
                                    @endif
                                    <td>{{ $printer->created_at->format('d-M-Y') }}</td>
                                    <td align="center"><a href="/printer/editprinter/{{ $printer->id }}" style="width: 90%"
                                            class="btn btn-smrs" data-toggle="tooltip" data-placement="top"
                                            title="Edit">Edit</a><br>
                                        <a onclick="remove({{ $printer->id }})" class="btn btn-danger"
                                            style="margin-top: 3%; width: 90%;" data-toggle="tooltip" data-placement="top"
                                            title="Remove">Remove</a>
                                </tr>
                                <?php }?>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        var allPrinter = $('#allPrinter').DataTable({
            aaSorting: [
                [0, 'desc']
            ],
            "dom": "Bfrtip",
            buttons: {
                buttons: [{
                    extend: 'pdf',
                    className: 'btn-smrs'
                }],
                dom: {
                    button: {
                        className: 'btn'
                    },
                },
            },
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "iDisplayLength": 10,
            "sScrollX": "100%",
            "sScrollXInner": "100%",
            "bScrollCollapse": true
        });

        function remove(printerId) {
            swal({
                    text: "Are you sure you want to delete?",
                    icon: "warning",
                    buttons: ['NO', 'YES'],
                    dangerMode: true
                })
                .then(function(value) {
                    if (value == true) {
                        window.location.href = "/printer/removeprinter/" + printerId;
                    }
                });
        }
    </script>
@endsection
