<script>

    $('#active_checkbox').change(function() {
        if($(this).is(":checked")) {
            $('#active').val(1);
        } else {
            $('#active').val(0);
        }
    });

    $('#type').on('change', function() {
        if (this.value == 'user'){
            $('#client_list').show();
        } else {
            $('#client_list').hide();
        }
    });

    $(document).on('click', '.btn-ok-destroy', function(event) {
        event.preventDefault();

        let id = $('input[name="id"]').val();

        let data = {
            _token : '{{ csrf_token() }}',
            _method : 'DELETE',
            id : id
        };

        $.ajax({
            type: 'POST',
            url: "{{ route('user-client.index') }}" + '/' + id,
            data: data,
            dataType: 'json',
            success: function(res){
                $("#confirm-delete").modal('hide');
                toastr.success(res.data.message, 'Sucesso');
                $('#del_client'+id).parent().parent().remove();
            },
            error: function(err) {
                $("#confirm-delete").modal('hide');
                toastr.success("Cliente removido com sucesso", 'Sucesso');
                $('#del_client'+id).parent().parent().remove();
            }
        })
    });



</script>
