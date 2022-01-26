<script>

    $(document).ready(function(){
        $('.add_more').click(function(e){
            e.preventDefault();
            $('input[type="file"]').trigger('click');
        });
    });


    $('#files_budget').change(function(e) {

        let tbody = $("#files_table tbody");
        let id =  $('#files_budget').data("id");
        let signed = $('#signed').val();

        let formdata = new FormData();

        let isSigned = signed == 1 ? 'SIM' : 'NÃO';
        let isSignedClass = signed == 1 ? 'disabled' : '';

        formdata.append('id', id);
        formdata.append('signed', signed);

        for(var i=0; i< this.files.length; i++) {
            file =this.files[i];
            formdata.append("files_" + i, file);
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        showSpinner();

        $.ajax({
            url: '/budget/upload',
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (res) {
                var budget_files_id = res.data.budget_files_id;
                for( var i=0; i < budget_files_id.length; i++) {
                    tbody.append('<tr>'+
                    '<td>'+budget_files_id[i].name+'</td>'+
                    '<td>'+isSigned+'</td>' +
                    '<td>' +
                    '<a href="/pdf/signer?id='+budget_files_id[i].id+'" class="btn btn-success signer '+isSignedClass+'" target="_blank" title="Assinar documento">' +
                    '<i class="fa fa-pencil"></i>' +
                    '</a>&nbsp;' +
                    '<a href="/open/'+budget_files_id[i].id+'" class="btn btn-success" target="_blank" title="Abrir documento">' +
                    '<i class="fa fa-folder-open"></i>' +
                    '</a>&nbsp;' +
                    '</a>' +
                    '<a href="/download/'+budget_files_id[i].id+'" class="btn btn-success" target="_blank" title="Baixar documento">' +
                    '<i class="fa fa-download"></i>' +
                    '</a>&nbsp;' +
                    '<a href="#" class="btn btn-danger destroy-file" title="Remover arquivo" data-id="'+budget_files_id[i].id+'"'+
                    'data-target="#confirm-delete" data-msg-destroy="Deseja realmente remover esse arquivo?"'+
                    'id="del_file' + budget_files_id[i].id +'"'+
                    'data-toggle="modal">' +
                    '<i class="fa fa-trash"></i>' +
                    '</a>' +
                    '</tr>');
                }
                hideSpinner();
                toastr.success(res.data.message, 'Sucesso');
                $('input[type="file"]').val(null);
            },
            erro: function(err) {
                hideSpinner();
                toastr.error("Houve um erro ao enviar seu arquivo", 'Erro');
                $('input[type="file"]').val(null);
            }
        });
    });

    $(document).on('click', '.signer', function(event) {
        $(this).addClass('disabled');
        var parent = $(this).parent();
        parent.parent().find('td').eq(1).text('SIM');
    });

    $(document).on('click', '.btn-ok-destroy', function(event) {

        event.preventDefault();

        let that = $(this);

        let id = $('input[name="id"]').val();

        let data = {
            _token : '{{ csrf_token() }}',
            _method : 'DELETE',
            id : id
        };

        $.ajax({
            type: 'POST',
            url: "{{ route('budget-files.index') }}" + '/' + id,
            data: data,
            dataType: 'json',
            success: function(res){
                $("#confirm-delete").modal('hide');
                toastr.success(res.data.message, 'Sucesso');
                $('#del_file'+id).parent().parent().remove();
            },
            erro: function(err) {
                $("#confirm-delete").modal('hide');
                toastr.success("Arquivo removido com sucesso", 'Sucesso');
                $('#del_file'+id).parent().parent().remove();
            }
        })
    });

    $('#signed_checkbox').change(function() {
    if($(this).is(":checked")) {
        $('#signed').val(1);
    } else {
        $('#signed').val(0);
    }
});


</script>
