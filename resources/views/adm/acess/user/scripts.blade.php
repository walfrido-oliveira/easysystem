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

    $(document).on('click', '.del_user_client', function(event) {

        event.preventDefault();

        let that = $(this);

        let id = $(this).data("id");

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
                toastr.success(res.data.message, 'Sucesso');
                that.parent().parent().hide();
            },
            erro: function(err) {
                alert(err);
            }
        })
    });


</script>
