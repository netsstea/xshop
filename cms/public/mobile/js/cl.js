$(document).ready(function() {
    //courtesy : http://stackoverflow.com/questions/1184624/convert-form-data-to-js-object-with-jquery
    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    //All the ajax request
    $.cl_ajax = function(options)
    {
        defaultSettings = {
            dataType: 'jsonp',
            data: {
                _cl_submit: 1,
                _cl_ajax: 1,
                _cl_rest: 1
            },
            cache: false
        };
        if (localStorage && options.url !== '/user/login') {
            if (localStorage.getItem("_cl_uid") !== null) {
                defaultSettings['data']['_cl_uid'] = localStorage.getItem("_cl_uid");
            }
            if (localStorage.getItem("_cl_uhash") !== null) {
                defaultSettings['data']['_cl_uhash'] = localStorage.getItem("_cl_uhash");
            }
            if (localStorage.getItem("_cl_token") !== null) {
                defaultSettings['data']['_cl_token'] = localStorage.getItem("_cl_token");
            }
        }
        $.extend(true, options, defaultSettings);
        options.url = SERVER + options.url;
        $.ajax(options);
    };
    $.cl_upload = function(options)
    {
        defaultSettings = {
            dataType: 'html',
            data: {
            },
            cache: false
        };
        if (localStorage && options.url !== '/user/login') {
            if (localStorage.getItem("_cl_uid") !== null) {
                defaultSettings['data']['_cl_uid'] = localStorage.getItem("_cl_uid");
            }
        }
        $.extend(true, options, defaultSettings);
        options.url = SERVER + options.url;
        $.ajax(options);
    };
    //bind the form submit action
    $("input[name=submit]").on("tap", function(e) {
        e.preventDefault();
        $form = $(this).closest('form');
        data = $form.serializeObject();
        url = $form.attr('action');
        formName = $form.attr('id');
        options = {
            url: url,
            data: data
        };
        if (typeof formConfigs[formName] !== 'undefined')
        {
            configOptions = formConfigs[formName];
            $.extend(true, options, configOptions);//deep copy			
        }
        $.cl_ajax(options);
    });
    $("input[name=upload]").on("tap", function(e) {
        e.preventDefault();
        $form = $(this).closest('form');
        data = $form.serializeObject();
        url = $form.attr('action');
        formName = $form.attr('id');
        options = {
            url: url,
            data: data
        };
        if (typeof formConfigs[formName] !== 'undefined')
        {
            configOptions = formConfigs[formName];
            $.extend(true, options, configOptions);//deep copy			
        }
        $.cl_upload(options);
    });
    //end of login submit event
    //upload plugin
});

