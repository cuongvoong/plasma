$(function(){
    $(".asa").each(function() {
        var asa = $(this).html();
                    
        if(asa.length <= 6 && asa[0] == ":")
            asa = "00" + asa;
        else if(asa.length == 5)
            asa = "00:" + asa;
        else if(asa.length == 4)
            asa = "00:0" + asa;
                    
        if(asa > asa_threshold_red)
            $(this).css('background-color', 'red');
        else if(asa > asa_threshold_yellow)
            $(this).css('background-color', 'yellow');
    });

    $(".aux_reason").each(function(){
        if($(this).html() == 'Lunch' && $(this).closest("tr").find(".time").html() > lunch_threshold)
        {
            $($(this).closest("tr").find(".time")).css('background-color', 'red');
        }
    });
    
    $(".aux_reason").each(function(){
        if($(this).html() == 'Break' && $(this).closest("tr").find(".time").html() > break_threshold)
        {
            $($(this).closest("tr").find(".time")).css('background-color', 'red');
        }
    });
    
    $(".aux_reason").each(function(){
        if($(this).html() == 'Break' && $(this).closest("tr").find(".time").html() > break_threshold)
        {
            $($(this).closest("tr").find(".time")).css('background-color', 'red');
        }
    });

    $(".state").each(function(){
        if($(this).html() == 'ACW' && $(this).closest("tr").find(".time").html() > acw_threshold)
        {
            $($(this).closest("tr").find(".time")).css('background-color', 'yellow');
        }
    });
});