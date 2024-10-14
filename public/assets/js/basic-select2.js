$('.basic-select').each(function(){
    var table = $(this).attr("t");
    var value = $(this).attr("data-value");
    var text = $(this).attr("data-text");
    var placeHolder = $(this).attr("data-place-holder");

    $(this).select2({
        placeholder: placeHolder,
        ajax: {
            url:"/global/basic-select-two/" +table+"/"+value+"/"+text,
            dataType: 'json',
            data: function (params) {
                    return {
                        search: $.trim(params.term),
                        curent_selected : $(this).val(),
                    };
                },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
})
