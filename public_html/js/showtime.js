function showtime(){
    setTimeout("showtime();",1000);
    callerdate.setTime(callerdate.getTime()+1000);
    var hh  = String(callerdate.getHours());
    var mm  = String(callerdate.getMinutes());
    var ss  = String(callerdate.getSeconds());
    document.clock.face.value =
        ((hh < 10) ? " " : "") + hh +
        ((mm < 10) ? ":0" : ":") + mm +
        ((ss < 10) ? ":0" : ":") + ss;

}