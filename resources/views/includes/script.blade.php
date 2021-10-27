<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>


<script type="text/javascript" src="{{ asset('assets/libs/datatables.net/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/libs/loadingoverlay/loadingoverlay.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url("assets/libs/toastr/toastr.min.js") }}"></script>


<script src="{{ asset('assets/js/app.js') }}"></script>



<script>
    function deleteRecord(ID, datatableID){
        $("#" + datatableID).LoadingOverlay("show");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url     : $('#' + datatableID).data('delete-url').replace("ID", ID),
            type    : "POST",
            dataType: 'json',
            success : function(resp){
                $('#' + datatableID).DataTable().ajax.reload();;
                toastr.error(resp.msg);
                $("#" + datatableID).LoadingOverlay("hide", true);
            }
        });
    }
    function deleteRecordOthers(ID, datatableID){
        $("#" + datatableID).LoadingOverlay("show");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url     : $('#' + datatableID).data('delete-url').replace("ID", ID),
            type    : "POST",
            dataType: 'json',
            success : function(resp){

                toastr.error(resp.msg);
                $('#search').trigger('click');
                $("#" + datatableID).LoadingOverlay("hide", true);
            }
        });
    }
    function statusRecord(ID, datatableID){
        $("#" + datatableID).LoadingOverlay("show");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url     : $('#' + datatableID).data('status-url').replace("ID", ID),
            type    : "POST",
            dataType: 'json',
            success : function(resp){
                toastr.info(resp.msg);
                $("#" + datatableID).LoadingOverlay("hide", true);
            }
        });
    }
</script>
