/* global $, document */
$(document).ready(function() {
    // Cria uma requisição ajax ao clicar nos botões de adicionar e editar.
    $(document).on("click", "#adicionar, .editar", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                $(".modal").remove();
                $("body").append(data);
                $(".modal").modal("show");
                $("#txt_celular").mask("(00) 00000-0000");
            }
        });
    });
    
    // Remove o modal do html ao ser fechado.
    $(document).on("hidden.bs.modal", ".modal", function() {
        $(this).remove();
    });
    
    // Evento para o botão de salvar do formulário.
    $(document).on("click", ".salvar", function(event) {
        event.preventDefault();
        var form = $(this).attr("data-form");
        $(form).find("[type='submit']").trigger("click");
    });
    
    // Cria uma requisição ajax com os dados do formulário.
    $(document).on("submit", ".modal form", function(event) {
        event.preventDefault();
        var form = this;
        $(this).find("*").blur();
        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: $(form).serialize(),
            success: function(data) {
		$(".modal").modal("hide");
                if ($(form).attr("id") == "form_adicionar") {
                    $(data).appendTo("table").find("td").wrapInner("<div style='display: none;' />").parent().find("td > div").slideDown(350, function() {
                        $(this).replaceWith($(this).contents());
                    });
                    
                } else {
                    var id = $(form).find("input[name='id']").attr("value");
                    var element = $("table").find("tr[data-id='" + id + "']");
                    element.fadeOut("slow", function() {
                        element.replaceWith(function() {
                            return $(data).hide().fadeIn();
                        });
                    });
                }
            }
        });
    });
    
    // Cria uma requisição ajax para o botão de excluir.
    $(document).on("click", ".excluir", function(event) {
        event.preventDefault();
        var name = $(this).parent().parent().find("td").first().text();
        $.ajax({
            url: $(this).attr("href"),
            data: {nome: name},
            success: function(data) {
                $(".modal").remove();
                $("body").append(data);
                $(".modal").modal("show");
            }
        });
    });
    
    // Cria uma requisição ajax para a confirmação da exclusão.
    $(document).on("click", ".modal .confirmar", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            success: function(data) {
                var element = $("table").find("tr[data-id='" + data + "']");
                element.fadeOut("slow", function() {
                    element.remove();
                });
            }
        });
    });
});
