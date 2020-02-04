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


</script>
