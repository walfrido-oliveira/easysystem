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

jQuery(".add-service").click(function(event) {
    event.preventDefault();
    var row = $(this).parents('tr');
    var i = row.find('td>a>i');
    if (row.hasClass("selected-row"))
    {
        row.addClass("unselected-row").fadeOut(10).fadeIn(500);
        row.removeClass("selected-row");

        $(this).removeClass("btn-danger");
        $(this).addClass("btn-success");

        i.removeClass("fa-trash");
        i.addClass('fa-plus');
    } else {
        row.addClass("selected-row").fadeOut(10).fadeIn(500);
        row.removeClass("unselected-row");

        $(this).addClass("btn-danger");
        $(this).removeClass("btn-success");

        i.addClass("fa-trash");
        i.removeClass('fa-plus');
    }

});
