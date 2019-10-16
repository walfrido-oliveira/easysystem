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

    var loading = $('#loading-cep');
    loading.text('Carregando dados...');

    $.getJSON( CORREIOS_URL+input+"/?app_key="+CORREIOS_APP_KEY+"&app_secret="+CORREIOS_APP_SECRET, function( data ) {
        $.each( data, function( key, val ) {
            if (key == 'endereco') {
                $('#adress').val(val);
            }
            if (key == 'bairro') {
                $('#district').val(val);
            }
            if (key == 'cidade') {
                $('#city').val(val);
            }
            if (key == 'uf') {
                $('#state').val(val);
            }
        });
        loading.text('');
    });

});

$("#search_cnae").click(function(event) {
    $('#searchCNAE').modal('toggle');
 });

 $('#searchCNAEValue').on('keyup',function(){
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '/home/comercial/client/cnae/search',
        data:{'search':$value},
        success:function(data){
            var result = data.result;
            var tbody = $("#cnae_results tbody");
            tbody.empty();
            result.forEach(function(element) {
                tbody.append('<tr id="'+element.id+'"><td>'+element.cnae_id+'</td><td>'+element.desc+'</td></tr>');
            });
        }
    });
})

$(document).on('click', '#cnae_results tbody tr', function(event)
{
    var value = $(this).find('td').eq(0).text();
    $('#cnae').val(value);
    $('#searchCNAE').modal('toggle');
    var tbody = $("#cnae_results tbody");
    tbody.empty();
    $('#searchCNAEValue').val('');
});

$('.phone').mask('0000-00009');
$('.phone').blur(function(event) {
   if($(this).val().length == 10){
      $('.phone').mask('00000-0009');
   } else {
      $('.phone').mask('0000-00009');
   }
});
