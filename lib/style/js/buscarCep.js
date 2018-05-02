$(function() {
    function limpa_endereco() {
        // Limpa valores do formulário de cep.
        $("#desEndereco").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function () {
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se o campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {
                //Verifica se existe conexão com a internet
                if (navigator.onLine) {
                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#desEndereco").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $('#desEndereco').val(dados.logradouro + ", " + dados.bairro + ", " + dados.localidade + "-" + dados.uf);
                        } else {
                            //CEP pesquisado não foi encontrado.
                            limpa_endereco();
                            bootbox.alert({
                                size: 'small',
                                title: '<i class="glyphicon glyphicon-shopping-cart"> </i> SCMM',
                                message: "CEP não encontrado."
                            });
                        }
                    });
                } else {
                    bootbox.alert({
                        size: 'small',
                        title: '<i class="glyphicon glyphicon-shopping-cart"> </i> SCMM',
                        message: "Sem Conexão com a Internet."
                    });
                }
            } else {
                //cep é inválido.
                limpa_endereco();
                bootbox.alert({
                    size: 'small',
                    title: '<i class="glyphicon glyphicon-shopping-cart"> </i> SCMM',
                    message: "Formato de CEP inválido."
                });
            }
        } else {
            //cep sem valor, limpa formulário.
            limpa_endereco();
        }
    });
});