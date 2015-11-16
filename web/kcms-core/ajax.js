/**
 * Created by lmerotta on 02.09.2015.
 */
define([], function() {

    var _run = function(url, settings)
    {
        $.ajax(url, settings);
    };

    return {
        run: _run
    }
});