
$( document ).ready( function(evt) {

    /**
     * Link Toggler
     */

    if( $('.hide') )
    {
        $('.hide').css('display' , 'block');
    }
    if( $('.link-toggle') ) 
    {
        $('.link-toggle').click(function() 
        {
            let target = $(this).attr('data-target');

            $(target).toggle();
        });
    }


    $('.hide').css('display' , 'block');



    if( $('.flash-msg-fade') )
    {
        $('.flash-msg-fade').click(function() {

            $(this).hide();
        })


        setTimeout(function() {
            $('.flash-msg-fade').hide();
        }, 2000);
        
    }
    
});

