$.fn.regcheck = function() {
    $(this).submit(function() {
        $("span.error").remove();
        $("input, label").removeClass("error");
        
        $(":text").filter(".validate").each(function() {
            $(this).filter(".required").each(function() {
                if($(this).val() == "") {
                    $(this).after("<span class='error'>必須項目です</span>");
                    $(this).addClass("error");
                }
            })
            
            $(this).filter(".mail").each(function() {
                if($(this).val() && !$(this).val().match(/.+@.+\..+/g)) {
                    $(this).after("<span class='error'>メールアドレスの形式が異なります</span>");
                    $(this).addClass("error");
                }
            })
        })
        
        $(":password").filter(".validate").each(function() {
            $(this).filter(".required").each(function() {
                if(!$(this).val()) {
                    $(this).after("<span class='error'>必須項目です</span>");
                    $(this).addClass("error");
                }
            })
        })
        
        $(":radio").filter(".validate").each(function() {
            $(this).filter(".required").each(function() {
                if($(":radio[name="+$(this).attr("name")+"]:checked").size() == 0) {
//                    $(this).after("<span class='error'>選択して下さい</span>")
                    $('<span class="error">選択して下さい</span>').insertAfter('span#sex_check');
                    $('label.sex').addClass("error");
                }
            })
        })
        
        if($("span.error").size() > 0) {
            $('html,body').animate({scrollTop:$("span.error:first").offset().top-40}, 'slow');
//            $("span.error").parent().addClass("error");
            return false;
        }        
    })
    
}
