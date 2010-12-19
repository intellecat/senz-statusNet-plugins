    $(document).ready(function(){
        //equalHeight();
        
        function equalHeight(){
            var contentPadding = parseInt($('#content').css('padding-top'))+parseInt($('#content').css('padding-bottom'))+parseInt($('#content').css('border-top-width'))+parseInt($('#content').css('border-bottom-width'));
            var contentHeight = $('#content').height() + contentPadding;
            var sideHeight = $('#aside_primary').height();
            var coreHeight = $('#core').height();
            if(sideHeight < coreHeight){
                $('#aside_primary').height(coreHeight);
            }else if(contentHeight < coreHeight){
                $('#content').height(coreHeight - contentPadding);
            }   
        }
    });
    
    