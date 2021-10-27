@extends('layout.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
     <!-- start page title -->
     <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Video</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.video.add') }}">Video Add</a></li>
                        <li class="breadcrumb-item active">Video List</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header bg-primary text-white-50">
                    <h5>Video List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered"
                    id="datatable"
                    data-url='{{ route("admin.dtable.video") }}'
                    data-edit-url='{{ route("admin.video.add", [ "id" => "ID"]) }}'
                    data-status-url='{{ route("admin.ajax.video.status", [ "id" => "ID"]) }}'
                    '>
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Video Title</th>
                                <th>Video Poster Image</th>
                                <th>Publish Date</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')


<script>
    $(document).ready(function(){


        $('#datatable').DataTable({
            searching: false,
            ordering: false,
            destroy: true,
            processing: true,
            serverSide: true,
            lengthChange: true,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: $('#datatable').data('url'),
                dataSrc: 'data'
            },
            columns: [
                {
                    data: "slNo"
                },
                {
                    data: "title",
                },
                {
                    data: "poster_image",
                },
                {
                    data: "publish_date",
                },
                {
                    data: "is_active",
                    render: function (data, type, row) {
                        console.log(row.Id);
                        return `<div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input"
                                    id="DTstatus_${row.video_id}" ${data == 1 ? 'checked' : ''}
                                    onClick="statusRecord('${row.Id}', 'datatable')">
                                    <label class="custom-control-label"
                                        for="DTstatus_${row.video_id}"></label>
                                </div>`;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<a class="btn btn-info btn-sm" data-toggle="tooltip"
                            title="" data-original-title="Edit"
                            href="${ $('#datatable').data('edit-url').replace("ID", row.Id) }">
                            <i class="fa fa-edit"></i>
                        </a>`;

                    }
                },
            ]
        });
    });
</script>
@endpush
