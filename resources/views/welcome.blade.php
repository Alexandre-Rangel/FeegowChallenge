<!doctype html>
<html lang="en" class="h-100">
<?php header('Access-Control-Allow-Origin: *'); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Sistema de Agendamento</title>

    <link rel="stylesheet" href={{ asset('css/ajax-bootstrap-select.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
    <link rel="stylesheet" type="text/css" href={{ asset('css/bootstrap-select.css') }}>
    <link rel="stylesheet" href={{ asset('css/bootstrap-select.min.css') }}>
    <link rel="stylesheet" href={{ asset('css/principal.css') }}>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap_37.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

</head>

<body class="d-flex h-100 text-center text-white cor-fundo">
    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <header class="mb-auto">

        </header>

        <div class="row justify-content-center">
            <div class="col-4">
                <p class="lead" for="ajax-select">Consulta de</p>
            </div>
            <div class="col-4">
                <select onChange="profissional(this)" title="Escolha a Especialidade" id="ajax-select"
                    name="ajax-select" class="selectpicker" data-live-search="true"></select>
            </div>
        </div>

        <div class="row justify-content-center area-profissional">
            <div class="col-6">
                <p class="lead" for="ajax-profissional">Escolha o Profissional</p>
            </div>
            <div class="col-6">
                <select title="Escolha o Profissional" id="ajax-profissional" name="ajax-profissional"
                    class="selectpicker" data-live-search="true"></select>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agendamento" tabindex="-1" role="dialog" aria-labelledby="agendamentoModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agendamentoModal">Agendar Consulta</h5>
                </div>
                <div class="modal-body">
                    <div class="mt-5">
                        <div class="row d-flex justify-content-center" style="margin-bottom: 20px;">
                            <div class="col-md-7">
                                <div class="md-6">
                                    <div class="md-12">
                                        <div class="text-center">
                                            <img id="img-profissional" src="" width="100"
                                                class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="md-12">
                                        <h5 class="mt-2 mb-0 " id="nome-profissional"></h5>
                                    </div>
                                    <div class="md-12">
                                        <span id="info-profissional"> </span>
                                    </div>
                                    <div class="md-12">
                                        <span class="bg-secondary p-1 px-4 rounded text-white "
                                            id="especialidade-profissional"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="name" placeholder="Nome"
                                title="Nome Completo">
                        </div>
                        <div class="form-group col-md-6 select-source_id">
                            <select id="source_id" name="source_id" title="Como nos encontrou?" class="selectpicker"
                                data-live-search="true"></select>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" placeholder="Data de Nascimento" onkeypress="mascaraData(this)"
                                class="form-control" id="birthdate" title="Nascimento">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" onfocus="retirarFormatacao(this);" onblur="formatarCampo(this);"
                                maxlength="11" placeholder="Cpf" class="form-control" id="cpf">
                        </div>
                        <input type="hidden" class="form-control" id="specialty_id" name="specialty_id">
                        <input type="hidden" class="form-control" id="professional_id" name="professional_id">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" onClick="save()" class="btn btn-primary">Agendar</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-auto text-white-50 ">
        <p>Desenvolvido por <a href="https://www.linkedin.com/in/alexandre-rangel-79641510b/"
                class="text-white">Alexandre Rangel</a> </p>
    </footer>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/validacoes.js') }}"></script>
    <script>
        function save() {

            $("#source_id").removeClass("glowing-border-error");
            $("#birthdate").removeClass("glowing-border-error");
            $("#name").removeClass("glowing-border-error");
            $("#cpf").removeClass("glowing-border-error");
            $(".select-source_id").removeClass("glowing-border-error");

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "save",
                data: {
                    'specialty_id': $("#specialty_id").val(),
                    'professional_id': $("#professional_id").val(),
                    'cpf': $("#cpf").val(),
                    'name': $("#name").val(),
                    'source_id': $("#source_id").val(),
                    'birthdate': $("#birthdate").val()
                },
                success: function(value) {

                    swal("Confirmado!", "Agendamento realizado com Sucesso", "success").then((value) => {
                        window.location.reload();
                    });
                },
                error: function(value) {
                    var errors = Object.keys(value.responseJSON.errors);

                    $.each(errors, function(key, val) {
                        var element = document.getElementById(val);
                        element.classList.add("glowing-border-error");

                        if (val == 'source_id') {
                            $(".select-source_id").addClass("glowing-border-error");
                        }
                    });
                    swal("Ops", "Parece que você esqueceu de preencher alguns campos", "error");
                }
            });
        }
    </script>
</body>

</html>
