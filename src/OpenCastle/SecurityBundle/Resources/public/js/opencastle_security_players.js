/**
 * Register / Login module
 *
 * This script file uses RequireJS to handle
 * The registration and login forms, aswell as
 * their submission, error handling, and the server's output.
 */
requirejs(['/bundles/opencastlecore/js/main.js'], function()
{
    requirejs(['core/forms', 'core/materialize', 'core/ajax'], function(forms, materialize, ajax){
        materialize.init();

        // Setup the registration form, and its callback.
        var name = "opencastle_security_player_inscription";
        var parameters = {
            selector: '#opencastle_security_player_inscription',
            token_selector: '#opencastle_security_player_inscription__token',
            buttons: {
                create: {
                    selector: "#opencastle_security_inscription_process",
                    callback: function(formSelector)
                    {
                        materialize.showLoadingPreloader();
                        $(formSelector).submit();
                    }
                }
            },
            form_valid: function(name, parameters)
            {
                var action = $(parameters.selector).attr('action');
                $(parameters.selector).find(".kcms-custom-validator").remove();
                materialize.showLoadingPreloader();
                ajax.run(
                    action,
                    {
                        data: $(parameters.selector).serialize(),
                        method: "POST",
                        success: function(data)
                        {
                            materialize.hideLoadingPreloader();
                            if (data.status == 'ok')
                            {
                                materialize.showToast(data.message, 2000, "green");
                                window.location.reload(true);
                            } else {
                                // parse errors of the form by putting them under the label, MaterializeCSS style.
                                forms.parseErrors(JSON.parse(data.errors), function(element, message){

                                    var label = "label[for="+name+element+"]";
                                    var input = "input[id="+name+element+"]";
                                    var fallback = "#"+name+element;

                                    if($(label).length > 0 && $(input).length > 0) {
                                        $(label).attr("data-error", message);
                                        $(input).addClass("invalid");

                                        if ($(label).val() == '') {
                                            $(label).addClass("active");
                                        }
                                    }
                                    else if($(fallback).length == 1)
                                    {
                                        $("<p></p>").addClass("red-text kcms-custom-validator").text(message).appendTo($(fallback));
                                    }

                                }, false);
                            }
                        }
                    }
                );
                return false;
            },
            form_invalid: function(name, parameters)
            {
                materialize.hideLoadingPreloader();
                return false;
            }
        };

        forms.add(name, parameters);

        /**
         * The login form is a bit different since the process
         * is handled by Symfony. We only have to do an ajax request
         * and wait for the response to be positive or negative
         */
        $("#opencastle_security_connexion_submit").click(function(e)
        {
            materialize.showLoadingPreloader();
            var $form = $("#opencastle_form_connexion");
            var action = $form.attr('action');

            var data = $form.serialize();

            $("#error_connexion_container").addClass('hide');
            ajax.run(
                action,
                {
                    data: data,
                    method: 'POST',
                    success: function(data)
                    {
                        if (data.success == 'false') {
                            $("#error_connexion_container").removeClass('hide');
                            $("#error_connexion_content").html(data.message);
                            materialize.hideLoadingPreloader();
                        }else {
                            window.location.reload(true);
                        }
                    }
                }
            );
        });

    });
});