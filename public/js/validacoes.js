$.ajax({
    url: '/home',
    dataType: 'json',
    type: "GET",
    data: {
        tipo: 'conheceu'
    },
    success: function (retorno) {
        $.each(retorno.content, function (key, val) {
            $("#source_id").append($("<option>")
                .val(val.origem_id)
                .html(val.nome_origem)
            );
        });
        $("#source_id").selectpicker("refresh");

    },
    error: function (error) {
        console.log(JSON.stringify(error));
    }
});

$.ajax({
    url: '/home',
    dataType: 'json',
    type: "GET",
    data: {
        tipo: 'especialidade'
    },
    success: function (retorno) {


        // $(".area-profissional").css("display", "block");
        $.each(retorno.content, function (key, val) {
            $("#ajax-select").append($("<option>")
                .val(val.especialidade_id)
                .html(val.nome)
            );
        });
        $('#ajax-select').selectpicker('val', '0');
        $("#ajax-select").selectpicker("refresh");
    },
    error: function (error) {
        console.log(JSON.stringify(error));
    }
});
$('.area-profissional').hide();

function profissional(el) {
    $('.area-profissional').show();
    var idEspecialidadeDesejada = $(el).val();

    $.ajax({
        url: '/home',
        dataType: 'json',
        type: "GET",
        data: {
            tipo: 'especialista'
        },
        success: function (retorno) {
            console.log(retorno);

            var tamPerson = Object.keys(retorno.content);
            let add;
            let especialidade;
            $.each(retorno.content, function (key, val) {
                add = false;
                $.each(val.especialidades, function (keyEspecialidade, valEspecialidade) {
                    if (idEspecialidadeDesejada == valEspecialidade.especialidade_id) {
                        add = true;
                        especialidade_id = valEspecialidade.especialidade_id;
                    }
                });
                especialista = val.profissional_id;
                if (add == true) {

                    let data = {
                        especialista: especialista,
                        especialidade: especialidade_id,
                        nome_profissional: (val.tratamento ? val.tratamento : '') + ' ' +
                            val.nome,
                        foto: val.foto,
                        doc: (val.conselho ? val.conselho : 'Número:') + ' ' + val
                            .documento_conselho
                    }

                    let botao =
                        "<button type='button' data-toggle='modal' data-target='#agendamento' class='btn btn-success btn-agendar' onClick='agendar(" +
                        JSON.stringify(data) + ")' >Agendar</button>";
                    let documento = val.documento_conselho ? 'Número:' : '';
                    let foto = val.foto ? val.foto : '/img/no-profile.jpg'
                    $("#ajax-profissional").append($("<option>")
                        .val(val.nome)
                        .html("<h5>" + val.nome + "</h5>" + "<p>" + (val.conselho ? val
                            .conselho : documento) + ' ' + val
                                .documento_conselho + "</p>" + botao)
                        .attr("data-thumbnail", foto)
                        .addClass("size-select")
                    );
                }
            });

            $("#ajax-profissional").selectpicker("refresh");
            $("#ajax-profissional").selectpicker('refresh').empty().append(output).selectpicker(
                'refresh').trigger('change');
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
};


function agendar(result) {
    $('#source_id').selectpicker('val', '0');
    let especialidade = $("#ajax-select option:selected").text();

    let documento = result.doc ? result.doc : '';
    let foto = result.foto ? result.foto : '/img/no-profile.jpg'

    $("#especialidade-profissional").html(especialidade);
    $("#specialty_id").val(result.especialidade);
    $("#professional_id").val(result.especialista);
    $("#img-profissional").attr("src", foto);
    $("#info-profissional").html(documento);
    $("#nome-profissional").html(result.nome_profissional);

}


function mascaraData(val) {
    var pass = val.value;
    var expr = /[0123456789]/;

    for (i = 0; i < pass.length; i++) {
        var lchar = val.value.charAt(i);
        var nchar = val.value.charAt(i + 1);

        if (i == 0) {
            if ((lchar.search(expr) != 0) || (lchar > 3)) {
                val.value = "";
            }

        } else if (i == 1) {

            if (lchar.search(expr) != 0) {
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }

            if ((nchar != '/') && (nchar != '')) {
                var tst1 = val.value.substring(0, (i) + 1);

                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);

                val.value = tst1 + '/' + tst2;
            }

        } else if (i == 4) {

            if (lchar.search(expr) != 0) {
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }

            if ((nchar != '/') && (nchar != '')) {
                var tst1 = val.value.substring(0, (i) + 1);

                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);

                val.value = tst1 + '/' + tst2;
            }
        }

        if (i >= 6) {
            if (lchar.search(expr) != 0) {
                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
            }
        }
    }

    if (pass.length > 10)
        val.value = val.value.substring(0, 10);
    return true;
}


function formatarCampo(campoTexto) {

    campoTexto.value = mascaraCpf(campoTexto.value);

}

function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g, "");
}

function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}

