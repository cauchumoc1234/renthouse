$(document).ready(function(){
    $(".rate-btn").click(function(){

        // $(".overlay").css("visibility","visible");
        // console.log($(".overlay").css("visibility"));
        if($(".overlay").css("visibility") == "hidden"){
            $(".overlay").css("visibility","visible")
            $(".overlay").css("opacity","1")
        }
        else{
            $(".overlay").css("visibility","hidden")
            $(".overlay").css("opacity","0")
        }
    }
    )
    $("[name='rate']").change(function(){
        for(var i of $(".rate")){
            if($(i).index() <= ($(this).index() + 5)){
                // $(i).css("color","yellow");
                $(i).addClass("yellow");
                // $(i).addClass("selected");
            }
            else if($(i).index() > ($(this).index() + 5)){
                // $(i).css("color","black");
                // $(i).removeClass("selected");
                $(i).removeClass("yellow");
            }
        }
    })
    $("#del-rate").click(function(){
        $("input:checked")[0].checked =false;
        for(var i of $(".rate")){
            // $(i).css("color","black");
            $(i).removeClass("yellow")
            // $(i).removeClass("selected");

        }
    })
})
