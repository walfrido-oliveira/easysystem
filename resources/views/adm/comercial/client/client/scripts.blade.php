<script>

    $("#search_client").click(function(event) {
        $('#cnpjModalValue').val($('#cnpj').val())
        $('#searchClient').modal('toggle');
        $('#fieldset_client_modal').hide();
    });

    $("#search_cnae").click(function(event) {
        var tbody = $("#cnae_results tbody");
        tbody.empty();
        $('#searchCNAE').modal('toggle');
    });


    $("#logo").on("change", function (e) {
        const maxAllowedSize = 50 * 1024 * 1024;
        if(this.files[0].size > maxAllowedSize){
            alert("Tamanho máximo permitido: 50kb!");
            this.value = "";
        } else {
            document.getElementById('output_logo').src = window.URL.createObjectURL(this.files[0])
        }
    });

    $("#cep").blur(function (e) {
        input = $(this).val().replace(/[^0-9]/g,'');
        $.ajax({
            type : 'get',
            url : '/helper/cep',
            data:{'cep':input},
            success:function(data){
                var result = data.result;
                $('#adress').val(result.endereco);
                $('#district').val(result.bairro);
                $('#state').val(result.uf);
                $('#city').val(result.cidade);
            }
        });
    });

    $("#search_cnpj_modal").click(function(event) {
        input = $('#cnpjModalValue').val().replace(/[^0-9]/g,'');
        $.ajax({
            type : 'get',
            url : '/helper/cnpj',
            data:{'cnpj':input},
            success:function(data) {
                var result = data.result;
                if (result.status === 'OK') {
                    $('#razao_social_modal').text(result.nome);
                    $('#nome_fantasia_modal').text(result.fantasia);
                    $('#phone_modal').text(result.telefone.split('/')[0]);
                    $('#phone_2_modal').text(result.telefone.split('/')[1]);
                    $('#adress_modal').text(result.logradouro);
                    $('#district_modal').text(result.bairro);
                    $('#state_modal').text(result.uf);
                    $('#city_modal').text(result.municipio);
                    $('#cep_modal').text(result.cep.replace('.',''));
                    $('#number_modal').text(result.numero);
                    $('#alert_cnpj_modal').hide();
                    $('#fieldset_client_modal').show();
                    $("#import_cnpj_modal").removeAttr("disabled");
                }
                if (result.status == 'ERROR') {
                    $('#alert_cnpj_modal').show();
                    $('#alert_cnpj_modal').text(result.message);
                    $('#fieldset_client_modal').hide();
                    $("#import_cnpj_modal").attr("disabled","disabled");
                }
            },
            fail:function(data) {
                $('#alert_cnpj_modal').show();
                $('#alert_cnpj_modal').text(result.message);
                $('#fieldset_client_modal').hide();
                $("#import_cnpj_modal").attr("disabled","disabled");
            }
        });
    });

    $("#import_cnpj_modal").click(function(event) {
        $("#import_cnpj_modal").attr("disabled","disabled");
        $('#fieldset_client_modal').hide();
        $('#searchClient').modal('hide');

        $('#cnpj').val($('#cnpjModalValue').val());
        $('#razao_social').val($('#razao_social_modal').text());
        $('#nome_fantasia').val($('#nome_fantasia_modal').text());
        $('#phone').val($('#phone_modal').text().substring(5));
        $('#ddd').val($('#phone_modal').text().substring(1,3));
        $('#phone_2').val($('#phone_2_modal').text().substring(5));
        $('#ddd_2').val($('#phone_2_modal').text().substring(2,4));
        $('#adress').val($('#adress_modal').text());
        $('#district').val($('#district_modal').text());
        $('#state').val($('#state_modal').text());
        $('#city').val($('#city_modal').text());
        $('#cep').val($('#cep_modal').text());
        $('#number').val($('#number_modal').text());
    });

    $("#close_cnpj_modal").click(function(event) {
        $("#import_cnpj_modal").attr("disabled","disabled");
        $('#fieldset_client_modal').hide();
        $('#searchClient').modal('hide');
    });

    $("#search_cnae").click(function(event) {
        var tbody = $("#cnae_results tbody");
        tbody.empty();
        $('#searchCNAE').modal('toggle');
    });

    $('#searchCNAEValue').on('keyup',function() {
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '/home/comercial/client/cnae/search',
            data:{'search':$value},
            success:function(data) {
                var result = data.result;
                var tbody = $("#cnae_results tbody");
                tbody.empty();
                result.forEach(function(element) {
                    tbody.append('<tr id="'+element.id+
                                '"><td>'+element.cnae_id+
                                '</td><td>'+element.desc+
                                '</td></tr>');
                });
            }
        });
    });

    $(".del_user_client").click(function(event) {

        if (confirm("Deseja realmente excluír?")) {
            var id= $(this).data("id");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type : 'POST',
                url : '/home/acess/user-client/' + id,
                data:{  '_method' :  'DELETE',
                        '_token'  :  $('meta[name="csrf-token"]').attr('content')},
                success:function(data) {
                    $('#user_client_'+id).remove();
                }
            });
        } else {
            return false;
        }
    });


</script>
