

function nv_genpass(){
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZ";
    var string_length = 20;
    var randomstring = '';
    var charCount = 0;
    var numCount = 0;

    for (var i=0; i<string_length; i++) {
        // If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value. 
        if((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {
            var rnum = Math.floor(Math.random() * 10);
            randomstring += rnum;
            numCount += 1;
        } else {
            // If any of the above criteria fail, go ahead and generate an alpha character from the chars string
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
            charCount += 1;
        } 
    }
    $('input[name=apikey]').val(randomstring);
}