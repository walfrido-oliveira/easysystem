function format(value, pattern) {
    var i = 0,
        v = value.toString();
    return pattern.replace(/#/g, _ => v[i++]);
}

$(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
     if ((event.which < 48 || event.which > 57)) {
         event.preventDefault();
     }
 });

$("#search_client_id").click(function(event) {
    var tbody = $("#client_results tbody");
    tbody.empty();
    $('#searchClient').find('.modal-body').css({
        width:'auto',
        height:'auto',
        'max-height':'100%',
        'overflow': 'auto',
    });
    $('#searchClient').modal('toggle');
});

$('#searchClient').on('shown.bs.modal', function(){
    $value= '';
    $.ajax({
        type : 'get',
        url : '/home/comercial/client/client/search',
        data:{'search':$value},
        success:function(data) {
            var result = data.result;
            var tbody = $("#client_results tbody");
            tbody.empty();
            result.forEach(function(element) {
                var cnpj = element.cnpj;
                if (cnpj.length < 14 ) {
                    cnpj = format(cnpj, '###.###.###-##');
                } else {
                    cnpj = format(cnpj, '##.###.###/####-##');
                }
                tbody.append('<tr id="'+element.id+'">'+
                             '<td>'+element.id+'</td>'+
                             '<td>'+element.razao_social+'</td>'+
                             '<td>'+cnpj+'</td>'+
                             '<td>'+removeNullValue(element.contact)+'</td>'+
                             '<td>('+removeNullValue(element.ddd)+') '+removeNullValue(element.phone)+'</td>'+
                             '<td>'+removeNullValue(element.mail)+'</td>'+
                             '</tr>');
            });
        }
    });
});

function removeNullValue(value) {
    return (value == null) ? "" : value;
}

$("#search_service_type").click(function(event) {
    $('#searchService').modal('toggle');
});

$("#search_client").click(function(event) {
    $('#cnpjModalValue').val($('#cnpj').val());
    $('#searchClient').modal('toggle');
    $('#fieldset_client_modal').hide();
});

$('#searchClientValue').on('keyup',function() {
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '/home/comercial/client/client/search',
        data:{'search':$value},
        success:function(data) {
            var result = data.result;
            var tbody = $("#client_results tbody");
            tbody.empty();
            result.forEach(function(element) {
                var cnpj = element.cnpj;
                if (cnpj.length < 14 ) {
                    cnpj = format(cnpj, '###.###.###-##');
                } else {
                    cnpj = format(cnpj, '##.###.###/####-##');
                }
                tbody.append('<tr id="'+element.id+'">'+
                             '<td>'+element.id+'</td>'+
                             '<td>'+element.razao_social+'</td>'+
                             '<td>'+cnpj+'</td>'+
                             '<td>'+element.contact+'</td>'+
                             '<td>('+element.ddd+') '+element.phone+'</td>'+
                             '<td>'+element.mail+'</td>'+
                             '</tr>');
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

$(document).on('click', '#client_results tbody tr', function(event) {
    var id = $(this).find('td').eq(0).text();
    var razao_socail = $(this).find('td').eq(1).text();
    var cnpj = $(this).find('td').eq(2).text();
    var contact = $(this).find('td').eq(3).text();
    var phone = $(this).find('td').eq(4).text();
    var mail = $(this).find('td').eq(5).text();

    if ($('#clients tr > td:contains('+id+') + td:contains('+razao_socail+')').length > 0) {
        alert('Esse cliente já foi adicionado');
        return;
    }

    var tbody = $("#clients tbody");
    tbody.append('<tr id="'+id+'">'+
                 '<td>'+id+'<input type="hidden" name="clients[R'+id+'][client_id]" value="'+id+'" id="client_id_'+id+'"></td>'+
                 '<td>'+razao_socail+'</td>'+
                 '</tr>');

    $("#client").val(razao_socail);

    $("#client_id").val(id);

    $("#cnpj").val(cnpj);

    $("#contact").val(contact);

    $("#phone").val(phone);

    $("#mail").val(mail);

    $('#searchClient').modal('toggle');
    var tbody = $("#client_results tbody");
    tbody.empty();
    $('#searchClientValue').val('');
});

$(document).on('click', '#service_results tbody tr', function(event) {
    var value = $(this).find('td').eq(0).text();
    $('#service_type_id').val(value);
    $('#searchService').modal('toggle');
    var tbody = $("#service_results tbody");
    tbody.empty();
    $('#searchServiceValue').val('');
});

function showSpinner() {
    document.getElementById("overlay").style.display = "flex";
}

  function hideSpinner() {
    document.getElementById("overlay").style.display = "none";
}



