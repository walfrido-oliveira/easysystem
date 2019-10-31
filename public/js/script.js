function seacherServices() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("area");
    filter =  input.options[input.selectedIndex].text;
    table = document.getElementById("services");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[3];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
}

$(".add-service").click(function(event) {
    event.preventDefault();
    var row = $(this).parents('tr');
    var id = row.find('td>input').val();
    var i = row.find('td>a>i');
    if (row.hasClass("selected-row"))
    {
        row.addClass("unselected-row").fadeOut(10).fadeIn(500);
        row.removeClass("selected-row");

        $(this).removeClass("btn-danger");
        $(this).addClass("btn-success");

        i.removeClass("fa-trash");
        i.addClass('fa-plus');

        $("#service_id_"+id).prop('disabled', true);
        $("#service_count_"+id).prop('disabled', true);
        $("#service_obs_"+id).prop('disabled', true);
    } else {
        row.addClass("selected-row").fadeOut(10).fadeIn(500);
        row.removeClass("unselected-row");

        $(this).addClass("btn-danger");
        $(this).removeClass("btn-success");

        i.addClass("fa-trash");
        i.removeClass('fa-plus');

        $("#service_id_"+id).prop('disabled', false);
        $("#service_count_"+id).prop('disabled', false);
        $("#service_obs_"+id).prop('disabled', false);
    }
});

$(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
     if ((event.which < 48 || event.which > 57)) {
         event.preventDefault();
     }
 });

 $("#step_1_next").click(function(event) {
    var fieldset_1 = $('#servicos');
    var fieldset_2 = $('#terms');
    fieldset_1.hide(500);
    fieldset_2.show(500);
 });

 $("#step_1_prev").click(function(event) {
    var fieldset_1 = $('#servicos');
    var fieldset_2 = $('#terms');
    fieldset_1.show(500);
    fieldset_2.hide(500);
 });

 $("#step_2_next").click(function(event) {
    var fieldset_1 = $('#terms');
    var fieldset_2 = $('#client_fields');
    fieldset_1.hide(500);
    fieldset_2.show(500);
 });

 $("#step_2_prev").click(function(event) {
    var fieldset_1 = $('#terms');
    var fieldset_2 = $('#client_fields');
    fieldset_1.show(500);
    fieldset_2.hide(500);
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
    $('#searchCNAE').modal('toggle');
});

$("#search_service_type").click(function(event) {
    $('#searchService').modal('toggle');
});

$("#search_client").click(function(event) {
    $('#cnpjModalValue').val($('#cnpj').val())
    $('#searchClient').modal('toggle');
    $('#fieldset_client_modal').hide();
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

$('#searchServiceValue').on('keyup',function() {
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '/home/comercial/budget/service_type/search',
        data:{'search':$value},
        success:function(data) {
            var result = data.result;
            var tbody = $("#service_results tbody");
            tbody.empty();
            result.forEach(function(element) {
                tbody.append('<tr id="'+element.id+
                             '"><td>'+element.tse_id+
                             '</td><td>'+element.desc+
                             '</td></tr>');
            });
        }
    });
});

$(document).on('click', '#cnae_results tbody tr', function(event) {
    var value = $(this).find('td').eq(0).text();
    $('#cnae').val(value);
    $('#searchCNAE').modal('toggle');
    var tbody = $("#cnae_results tbody");
    tbody.empty();
    $('#searchCNAEValue').val('');
});

$(document).on('click', '#service_results tbody tr', function(event) {
    var value = $(this).find('td').eq(0).text();
    $('#service_type_id').val(value);
    $('#searchService').modal('toggle');
    var tbody = $("#service_results tbody");
    tbody.empty();
    $('#searchServiceValue').val('');
});

