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

    const correios_app_key =  "WCDKcdgMxB805tLJ2atHvIHcUIRViz9h";
    const correios_app_secret = "k6QNlftoMdHdBjy8hgvri47kqUvgBMXU7nrxLIT3DUfFzQDV";
    input = $(this).val().replace(/[^0-9]/g,'');

    var loading = $('#loading-cep');
    loading.text('Carregando dados...');

    $.getJSON( "https://webmaniabr.com/api/1/cep/"+input+"/?app_key="+correios_app_key+"&app_secret="+correios_app_secret, function( data ) {
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
