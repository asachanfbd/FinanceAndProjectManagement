function relativeTime(ot){
    var mnth=new Array();
    mnth[0]="January";
    mnth[1]="February";
    mnth[2]="March";
    mnth[3]="April";
    mnth[4]="May";
    mnth[5]="June";
    mnth[6]="July";
    mnth[7]="August";
    mnth[8]="September";
    mnth[9]="October";
    mnth[10]="November";
    mnth[11]="December";
    
    oldtime = new Date(ot);
    ct = new Date();
    todayStart = new Date(ct.getFullYear(), ct.getMonth(), ct.getDate(), 0, 0, 0, 0);
    yStart = new Date(ct.getFullYear(), ct.getMonth(), ct.getDate()-1, 0, 0, 0, 0);
    
    if(oldtime.getTime() < yStart.getTime()){
        return "on "+mnth[oldtime.getMonth()]+" "+oldtime.getDate()+", "+oldtime.getFullYear();
    }else if(oldtime.getTime() < todayStart.getTime()){
        return 'Yesterday at '+oldtime.toLocaleTimeString();
    }else{
        diff = ct.getTime() - oldtime.getTime();
        //document.write("Time difference: "+diff+"<br>");
        if(diff < 0){
            return 'Invalid time';
        }else if(diff < 60*1000){
            return 'a few seconds ago';
        }else if(diff < 60*2*1000){
            return 'about a minute ago';
        }else if(diff < 60*60*1000){
            return Math.round(diff/(60*1000))+' minutes ago';
        }else if(diff < 60*60*2*1000){
            return 'about an hour ago';
        }else{
            return Math.round(diff/(3600*1000))+' hours ago';
        }
    }
}

function plural(diff) {
    if (diff != 1){return "s";}
}

function updatetime(){
    $(".timeautoupdate").each(function() {
        tm = relativeTime($(this).attr('timestamp')*1000);
        $(this).html(tm);
    });
    t = setTimeout('updatetime()', 5000);
}

$(document).ready(function(){
    updatetime();
});