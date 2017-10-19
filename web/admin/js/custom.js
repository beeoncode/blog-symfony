jQuery(document).ready(function($) {
    $(document).on('click', '.badge', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $.ajax({
            url: '/admin/status/'+id,
            type: 'POST',
            data: {
                'id' : id,
            },
            success: function (response) {
                if (status == 1){
                    $('#badge'+id).replaceWith('<span class="badge" id="badge'+id+'" data-id="'+id+'" data-status="'+0+'">Show</span>');
                }else if (status == 0){
                    $('#badge'+id).replaceWith('<span class="badge" id="badge'+id+'" data-id="'+id+'" data-status="'+1+'">Hide</span>');
                }
            }
        });
    })
})