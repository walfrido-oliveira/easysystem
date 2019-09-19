    $('#confirm-delete').on('show.bs.modal', function(e) 
    {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    $(function()
    {
        $(".moeda").mask("#.##0,00", {reverse: true});

        var SPMaskBehavior = function (val) 
        {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = 
        {
            onKeyPress: function(val, e, field, options) 
            {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        $('.telefone').mask(SPMaskBehavior, spOptions);

        $('.date').mask('00/00/0000', {placeholder: "__/__/____"});
    });

    $(document).ready(function()
    {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.tmbItem').click(function() 
    {
        var itens = $(".tmbItem");

        itens.each( function(index, value) 
        {
            $(this).removeClass('tmbItemSel');
        });

        $(this).addClass('tmbItemSel');
    });

    $("#textSearch").on("input",function() 
    {

        var itens = $(".tmbItem");
        var text = $(this).val();

        itens.each( function(index, value) 
        {
            var value2 = $(this).find(".title .name").data('name');
            var regex = new RegExp(text);
            
            if(regex.test(value2) === false) $(this).hide(500);
            else $(this).show(500);
            if(text === '') $(this).show(500);
        });
    });

    $('#textSearch').on("input",function() 
    {
        $('table').show();
        
        var selection = $(this).val();
        var dataset = $('#table-usuarios tbody').find('tr');
        
        dataset.show();
        dataset.filter(function(index, item) 
        {
            var regex = new RegExp(selection);
            var value = $(item).find('#value-filter').text();
            return !regex.test(value);
        }).hide();
        dataset.filter(function(index, item) 
        {
            return selection === '';
        }).show();
    });

    $(document).ready(function() 
    {
        $('#form-search').submit(function(event) 
        {
            event.preventDefault();
        });
    });

    $(document).ready(function() 
    {
        $('#form-adduser').submit(function(event) 
        {

            event.preventDefault();
            
            var data = $(this).serialize();
            var formMessages = $('#form-messages');
            
            $.ajax(
            {
                type: "POST",
                url: $(this).attr('action'),
                data: data
            }).done(function(response) 
            {
                $(formMessages).removeClass('alert alert-danger');
                $(formMessages).addClass('alert alert-success');

                $(formMessages).text(response);

                $('html, body').animate({scrollTop: $(formMessages).offset().top}, 500);
                $('#prevmodal').hide();
                $('#confirm-useradd').modal('show');

            }).fail(function(data) 
            {

                $(formMessages).removeClass('alert alert-success');
                $(formMessages).addClass('alert alert-danger');

                if (data.responseText !== '') 
                {
                    $(formMessages).text(data.responseText);
                } else 
                {
                    $(formMessages).text('Oops! An error occured and your message could not be sent.');
                }

                $('html, body').animate({scrollTop: $(formMessages).offset().top}, 500);
                $('#prevmodal').show();
                $('#confirm-useradd').modal('show');
            });
            
        });
    });

    $(document).ready(function() 
    {
        $('#form-delete').submit(function(event) 
        {

            event.preventDefault();
            
            var data = $(this).serialize();
            var formMessages = $('#form-messages');
            
            $.ajax(
            {
                type: "POST",
                url: $(this).attr('action'),
                data: data
            }).done(function(response) 
            {
                $(formMessages).removeClass('alert alert-danger');
                $(formMessages).addClass('alert alert-success');

                $(formMessages).text(response);

                $('#confirm-delete').modal('hide');
                $('#confirm-useradd').modal('show');

            }).fail(function(data) 
            {
                $(formMessages).removeClass('alert alert-success');
                $(formMessages).addClass('alert alert-danger');

                if (data.responseText !== '') 
                {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! Ocorreu um erro.');
                }

                $('#confirm-delete').modal('hide');
                $('#confirm-useradd').modal('show');
            });
            
        });
    }); 

    $('.confirm-delete').click(function() 
    {
        $('#idUser').val($(this).data('id'));
    });

    $('#prevmodalDelete').click(function() 
    {
        var tr = $('#user_id_' + $('#idUser').val());
        tr.css('"background-color","#FF3700"');
        tr.fadeOut(400, function() 
        {
            tr.remove();
        });
    });

    $(document).on('click', '.iconfolder', function(event)
    {
        event.preventDefault();
        var filename = $(this).data('file');
        var currentLocation = window.location.toString();
        window.open(currentLocation + '/' + filename,'_self');
    });

    $(document).ready(function() 
    {
        $('.drop-files-container').on('dragover', function(e) 
        {
            e.preventDefault();
            e.stopPropagation();
            $(this).delay(500).addClass('upload');
        })

        $('.drop-files-container').on('dragenter', function(e) 
        {
            e.preventDefault();
            e.stopPropagation();
        })

        $('.drop-files-container').on('drop', function(e)
        {
            if(e.originalEvent.dataTransfer)
            {
                var files = e.originalEvent.dataTransfer.files;
                if(files.length > 0) {
                    e.preventDefault();
                    e.stopPropagation();
                    processFileUpload(files);
                    $(this).delay(800).removeClass('upload');
                }   
            }
        })
        
        $('.drop-files-container').on('dragleave', function(e) 
        {
            e.preventDefault();
            e.stopPropagation();
            $(this).delay(800).removeClass('upload');
        })

        function processFileUpload(droppedFiles) 
        {
            var uploadFormData = new FormData($("#upload-form")[0]);
            if(droppedFiles.length>0) 
            {
                for(var f =0; f < droppedFiles.length; f++)
                {
                    uploadFormData.append("files[]",droppedFiles[f]);
                }
            }
            $.ajax(
            {
                type: "POST",
                url: "",
                data: uploadFormData,
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false
            }).done(function(response) 
            {
                var container = $('.drop-files-container');
                var title = $('#user-name');
                $('#upload').hide(500);
                container.empty();
                container.append(response);
                $('[data-toggle="tooltip"]').tooltip();
            }).fail(function(data) 
            {
                alert(data.responseText);
            });
        }
    });

    $(document).ready(function() 
    {
        $('#form-adddir').submit(function(event) 
        {
            event.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: '?controle=Files&acao=addFolderFiles',
                data: data
            }).done(function(response) 
            {
              $('#confirm-add-dir').modal('hide');
              var container = $('.drop-files-container');
              var title = $('#user-name');
              $('#upload').hide(500);
              container.empty();
              container.append(response);
              $('[data-toggle="tooltip"]').tooltip();
          }).fail(function(data) 
          {
            if (data.responseText !== '') 
            {
                alert(data.responseText);
            } else 
            {
                $(formMessages).text('Oops! Ocorreu um erro.');
            }
        });
      });
    });

    $(document).on('click', '#add-dir-btn', function(event)
    {
        $('#txtnamedir').prop('value','');
    });

    $(document).on('click', '#admin_users', function(event)
    {
        if ($(this).is(":checked"))
        {
            $(this).val(1);
        }
        else
        {
            $(this).val(0);
        }
    });