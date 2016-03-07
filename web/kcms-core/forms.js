define(['./ajax'], function(ajax) {

    /** Should be built like this:
     *
     * form_identifier: {
     *      selector:
     *      token_selector:
     *      buttons = {
     *          identifier: {
     *              selector:
     *              callback: /!\ SI LE BOUTON EST DE TYPE SUBMIT, IL FAUT RETOURNER FALSE SI ON NE VEUT PAS SOUMETTRE LE FORMULAIRE. SINON IL SERA SOUMIS
     *          }
     *      },
     *      pre_validate: callback(object literal form_identifier)
     *      form_valid: callback(object literal form_identifier)
     *      form_invalid: callback(object literal form_identifier)
     * }
     */
    var _defaults = {
        forms: {

        }
    };

    var _ajax = ajax;

    var addFunction = function(name, parameters) {
        if (typeof(name) === 'undefined' || typeof(name) !== "string") {
            console.error("Form name invalid");
            return false;
        }

        // check params

        if (!("selector" in parameters) || typeof(parameters.selector) !== "string") {
            console.error("Form selector invalid");
            return false;
        }

        if (!("buttons" in parameters) || typeof(parameters.buttons) !== "object" || $.map(parameters.buttons, function(n, i) { return i; }).length < 1)
        {
            console.error("Form buttons list invalid");
            return false;
        }

        for(button in parameters.buttons)
        {
            if(!("selector" in parameters.buttons[button]) || typeof(parameters.buttons[button].selector) !== "string" || !("callback" in parameters.buttons[button]) || typeof(parameters.buttons[button].callback) !== "function")
            {
                console.error("Form button "+button+" invalid");
                return false;
            }

            $(parameters.buttons[button].selector).unbind("click");
            $(parameters.buttons[button].selector).click(function(e)
            {
                parameters.buttons[button].callback(parameters.selector);
            });
        }

        if("pre_validate" in parameters)
        {
            if(typeof(parameters.pre_validate) !== "function") {
                console.error("Form pre_validate is not a function");
                return false;
            }else
            {
                parameters.pre_validate = function(){};
            }
        }else
        {
            parameters.pre_validate = function(){};
        }

        if(!("form_valid" in parameters) || typeof(parameters.form_valid) !== "function")
        {
            console.error("Form form_valid is not a function");
            return false;
        }

        if(!("form_invalid" in parameters) || typeof(parameters.form_invalid) !== "function")
        {
            console.error("Form form_invalid is not a function");
            return false;
        }

        if("token_selector" in parameters)
        {
            if(typeof(parameters.token_selector) !== "string") {
                console.error("Form token_selector is not a string");
                return false;
            }
        }else
        {
            parameters.token_selector = "";
        }

        $(parameters.selector).unbind('submit');
        $(parameters.selector).submit(function()
        {
            var returnValue = false;
            parameters.pre_validate(name, parameters);
            if($(this).valid())
            {
                returnValue =  parameters.form_valid(name, parameters);
            }else{

                returnValue = parameters.form_invalid(name, parameters);
            }

            /** TO IMPLEMENT ONCE AJAX QUEUING IS DONE
             if(parameters.token_selector)
             {
                 _regenerateToken(name, parameters.token_selector);
             }*/

            if(typeof(returnValue) === "undefined")
            {
                returnValue = false;
            }

            return returnValue;
        });

        _defaults.forms[name] = parameters;

        return true;

    };

    var _regenerateToken = function(intention, token_selector)
    {
        _ajax.run(Routing.generate('kreativecms.security.token_generator', {intention: intention}), {
            success: function (data) {
                $(token_selector).val(data.token);
            }
        });
    };

    var _parseErrors = function(errors, callback, name, call_if_empty, currentItem)
    {
        var _separator = "_";

        // check params
        if(typeof(errors) !== "object")
        {
            console.error("Form errors not valid object");
            return false;
        }


        if(typeof(callback) !== "function")
        {
            console.error("Form callback not valid function");
            return false;
        }

        if(typeof(name) !== "string")
        {
            name = '';
        }


        if(typeof(call_if_empty) !== "boolean")
        {
            call_if_empty = false;
        }


        if(typeof(currentItem) !== "string")
        {
            currentItem = "";
        }

        var keys = Object.keys(errors);

        if(keys.length == 0)
        {
            if(call_if_empty)
            {
                callback();
            }

            return true;
        }

        for(keyIndex in keys)
        {
            var key = keys[keyIndex];
            if(key === "children")
            {
                _parseErrors(errors[key], callback, name, call_if_empty, currentItem);
            }
            else
            {
                var _currentItem = key;
                var currentObject = errors[_currentItem];

                if (typeof(currentObject) !== "object") {
                    console.error("Item " + _currentItem + "." + currentItemKeys[currentItemKeyIndex] + "is not an object. Skipping...");
                }
                else {
                    var currentItemKeys = Object.keys(currentObject);
                    for(currentItemKeyIndex in currentItemKeys) {
                        var currentObjectKey = currentItemKeys[currentItemKeyIndex];
                        if("errors" == currentObjectKey)
                        {
                            for(errorIndex in currentObject.errors){
                                var errorMessage = currentObject.errors[errorIndex];
                                callback(currentItem + _separator + _currentItem, errorMessage, name);
                            }
                        }

                        if("children" == currentObjectKey)
                        {
                            _parseErrors(currentObject.children, callback, name, call_if_empty, currentItem + _separator + _currentItem);
                        }
                    }
                }
            }
        }
    };

    return {

        add: addFunction,
        parseErrors: _parseErrors,
        materializeErrors: function(element, message, name){
            var label = "label[for="+name+element+"]";
            var input = "input[id="+name+element+"]";
            var fallback = "#"+name+element;

            if($(label).length > 0 && $(input).length > 0) {
                $(label).attr("data-error", message);
                $(input).removeClass('valid');
                $(input).addClass("invalid");

                if ($(label).val() == '') {
                    $(label).addClass("active");
                }
            }
            else if($(fallback).length == 1)
            {
                $("<p></p>").addClass("red-text kcms-custom-validator").text(message).appendTo($(fallback));
            }

        }

    }
});