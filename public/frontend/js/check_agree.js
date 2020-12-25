//check if the "Tôi đồng ý" checkbox was checked or not
$(document).ready(function(){
    $("#agree-ckd").change(function(){
        if(this.checked == true){
            $("#submit_btn").removeAttr("disabled");
        }
        else{
            $("#submit_btn").attr("disabled", true);
        }
    })
})