     var tid = '';
     
     var disableform = false;
     
     $(".ajaxsubmitform").live('submit', function(e){
         
         if(disableform){
             alert("Can not submit form during upload.");
         }else{
             //alert('gOING TO SUBMIT THE FORM');
         }
       if(!disableform){
        var id = $(this);
        //alert(d);
        if($(id).attr('method').toUpperCase() == 'POST'){
            innerboxloading(id);
            var d = $(id).serialize();
            //alert(d);
             $.post($(id).attr('action'), d, function(data){
                 innerboxloading(id);
                 //alert(data);
                 var d = $.parseJSON(data);
                 if(d.error.length > 0){
                     //show error msg
                     alert(d.error);
                 }else if(d.success.length > 0){
                     if(d.success == 'vanishboxdelayed'){
                         //alert(d.result);
                         var t = $(id).closest('.innerbox');
                         $(id).closest('.tabdata').html(d.result);
                         $(t).delay(2000).slideUp(1000);
                     }
                     if(d.success == 'vanishrowdelayed'){
                         //alert(d.result);
                         var t = $(id).closest('.tabrowcontentajaxresult');
                         $(t).html(d.result);
                         $(t).closest('li').delay(2000).slideUp(1000);
                     }
                     else if(d.success == 'showresult'){
                         //alert(d.result);
                         var t = $(id).closest('.innerbox').parent().find('.resultbox');
                         $(t).find('.tabdata').prepend(d.result);
                         $(id)[0].reset();
                     }
                     else if(d.success == 'updateresultbox'){
                         var par = $(id).closest('div.ajaxresult');
                         var re = par.parent('li').children('.ajaxify');
                         re.find('.tabrowcontent').html(d.result);
                         par.hide();
                         re.show();
                         re.find(".successmsg").show();
                         re.find('.tabrow').css('background', '#FFFFC0');
                         re.find('.tabrow').animate({ backgroundColor: "#FFFFFF" }, 3000);
                         re.find(".successmsg").fadeOut(2000);
                     }
                     else if(d.success == 'showconfirm'){
                         var t = $(id).closest('.tabrowcontentajaxresult');
                         alert(d.result);
                         $(t).html('<div class="showconfirm">'+d.result+'</div>');
                         $(id)[0].reset();
                         $('#name').focus();
                     }
                     else if(d.success == 'alertnreload'){
                         alert(d.result);
                         $(id)[0].reset();
                         window.location.reload();
                     }
                     else if(d.success == 'updateremarksreply'){
                         var t = $(id).closest('.remarksconversation_container');
                         //alert(d.result);
                         $(t).find('.remarksconversation').append(d.result);
                         $(id)[0].reset();
                         $('#remarksreplybody').focus();
                     }
                     else if(d.success == 'sendmail'){
                         alert(d.result);
                         var t = $(id).closest('.mailform');
                         $(t).html("<div style='text-align:center;'>"+d.result+"</div>");
                     }
                     else if(d.success == 'showalert'){
                         alert(d.result);
                     }
                     else if(d.success == 'addclassesupdate'){
                         var pr = parseInt($(id).find('#priority').val());
                         $(id)[0].reset();
                         $(id).find('#priority').val(pr+1);
                         $(id).find('input[name=class_name]').focus();
                         $('.dbclasses').html(d.result.update);
                         alert(d.result.result);
                     }
                     else{
                         alert('Message Sent');
                         
                     }
                 }
             });
         }
       }
       return false;
     });
     
     $(document).ready(function() {
        $('.datatables').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });
     } );
     
     function innerboxloading(id){
         var box = $(id).closest('.innerbox');
         box.find('.innerboxloading').toggle();
     }
     
     $('a.ajaxify').live('click', function(e){
            e.preventDefault();
            var id = $(this);
            var par = $(this).closest('li');
            var re = par.find('div.ajaxresult');
            par.removeClass('unread');
            var lo = $(this).find('.loadingico').show();
            $.get($(this).attr('href'), function(data){
                
                //this will collapse all setting bars and nullify them.
                $('ul.tabdata li').each(function(){
                    $(this).find('a.ajaxify').show();
                    $(this).find('div.ajaxresult').hide();
                    $(this).find('.tabrowcontentajaxresult').html('');
                });
                lo.hide();
                id.hide();
                re.find('.tabrowcontentajaxresult').html(data);
                re.show();
            });
            
     });
     
     $('a.ajaxrequest').live('click', function(e){
            e.preventDefault();
            var id = $(this);
            var flag = true;
            if($(id).attr('data-confirm').length > 0){
                if(!confirm($(id).attr('data-confirm'))){
                    flag = false;
                }
            }
            if(flag){
                innerboxloading(id);
                //alert($(this).attr('href'));
                $.get($(this).attr('href'), function(data){
                    //alert(data);
                    var d = $.parseJSON(data);
                    innerboxloading(id);
                     if(d.error.length > 0){
                         alert(d.error);
                     }else if(d.success.length > 0){
                         if(d.success == 'showalert_and_remove_link'){
                             alert(d.result);
                             $(id).remove();
                         }
                         else if(d.success == 'showalert_and_reload'){
                             alert(d.result);
                             window.location.reload();
                         }
                         else if(d.success == 'showalert_only'){
                             alert(d.result);
                         }
                     }
                });
            }
            
     });
     
     $('.showhelp').live('focus', function(e){
         var a = $(this).closest('.clview_row').find('.clview_help');
         a.css('opacity', '1');
     });
     
     $('.showhelp').live('blur', function(e){
         var a = $(this).closest('.clview_row').find('.clview_help');
         a.css('opacity', '0');
     });
     
     var countfields = 5;
     
     function addfieldsrow(i, tbl){
         i++;
         var data = '';
         id = tbl.closest('table').attr('id');
         if(id == 'createexams'){
             data = '<tr class="classlevelfield"><td><input type="text" name="sub'+i+'" id="sub'+i+'" class="class_suggest"></td><td><input type="text" name="max'+i+'" id="max'+i+'" size="12"></td><td><input type="text" name="pass'+i+'" id="pass'+i+'" size="12"></td><td><input type="text" class="datepicker" name="date'+i+'" id="date'+i+'" autocomplete="off"></td></tr>';
             focusid = 'sub';
         }
         else if(id == 'addclasses'){
             data = '<tr class="classlevelfield"><td><input value="'+i+'" type="text" name="l'+i+'" id="l'+i+'" size="3" disabled="disabled"></td><td><input type="text" name="n'+i+'" id="n'+i+'" class="classnamefield"/></td><td><input type="text" name="s'+i+'" id="s'+i+'" size="3" class="classnamefield"></td></tr>';
             focusid = 'n';
         }
         else if(id == 'updateexams'){
             data = '<tr class="classlevelfield"><td><input type="text" size="30" name="sub'+i+'" id="sub'+i+'" class="class_suggest"></td><td><input type="text" name="max'+i+'" id="max'+i+'" size="12"></td><td><input type="text" name="pass'+i+'" id="pass'+i+'" size="12"></td><td><input type="text" name="date'+i+'" id="date'+i+'" autocomplete="off" size="12" maxlength="10"></td></tr>';
             focusid = 'sub';
         }
         
         //alert(data);
         countfields = i;
         $(tbl).append(data);
         $('#'+focusid+i).focus();
         $('#date'+i).datepicker('destroy').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-y"
                    });
         $('#sub'+i).autocomplete({
                            source: availableTags
                        });
     }
     
     $('#addfields').live('click', function(){
         alert('hi');
         var tbl = $(this).closest('table').find('tbody');
         
         addfieldsrow(countfields, tbl);
         
     });
     
     $('#addfields').live('focus', function(e){
         
         var tbl = $(this).closest('table').find('tbody');
         countfields = tbl.find('tr').length;
         var lastinput = $(tbl).find('.classlevelfield').last().find('td:first-child').find('input');
         var lastnameinput = $(tbl).find('.classnamefield').last();
         if($(lastnameinput).val() != ''){
             var i = parseInt($(lastinput).val())+1;
             addfieldsrow(countfields, tbl);
         }
         if($(lastnameinput).val() == '' && countfields >= 6){
             $(tbl).find('.classlevelfield').last().remove();
             countfields = countfields-1;
         }
     });
     
     $(".each_notif").live('hover', function(){
         var str = $(this).attr('class');
         if(str.indexOf("unread") >= 0){
             var id = $(this).attr('id');
             $.get('listner.php?page=notifs&pagename='+id, function(data){
                 if(data == 'done'){
                     var count = parseInt($('#notifscountid').html());
                     if(count > 0){
                         $('#notifscountid').html(count - 1);
                     }
                     $('#'+id).removeClass('unread');
                 }
             });
         }
     });

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
                return 'just now';
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

    function getnotifications(){
        $.get('listner.php?page=notifs&checknotifs', function(data){
            //console.log("Data: "+data+" md5id:"+notificationCheckId);
            if(data != notificationCheckId){
                notificationCheckId = data;
                updatenotifs();
            }
        });
        tn = setTimeout('getnotifications()', 3000);
    }

    function updatenotifs(){
        $.get('listner.php?page=notifs&getnotifs', function(data){
            $('#notifs').closest('li').html(data);
        });
    }

    $(document).ready(function(){
        updatetime();
    });
    
    
    function mailpage(){
        mail_str = "mailto:?subject=An interesting article on www.braintouchonline.com"; 
        mail_str += "&body=I thought you might be interested in the article : " + location.href;
        location.href = mail_str; 
    }
    
    
    $('.inputresultbox').live('keyup', function(e){
        resultinputalert(this);
    });
    
    function resultinputalertstart(){
        $('.inputresultbox').each(function() {
            resultinputalert(this);
        });
    }
    
    function resultinputalert(id){
        var marks = parseInt($(id).val());
        var max = parseInt($(id).attr('data-max'));
        var min = parseInt($(id).attr('data-min'));
        var pass = parseInt($(id).attr('data-pass'));
        var submit = $(id).closest('.ajaxsubmitform').find('input[type=submit]');
        if(marks<min){
            $(id).removeClass('studentfailed');
            $(id).addClass('inputcrosslimit');
            disableform = true;
            return false;
        }else if(marks>=min && marks<pass){
            $(id).removeClass('inputcrosslimit');
            $(id).addClass('studentfailed');
            disableform = false;
            return false;
        }else if(marks>=pass && marks <= max){
            $(id).removeClass('inputcrosslimit');
            $(id).removeClass('studentfailed');
            disableform = false;
            return true;
        }else if(marks>max){
            $(id).removeClass('studentfailed');
            $(id).addClass('inputcrosslimit');
            disableform = true;
            return false;
        }
    }
    
    $('#msgtoselector input[type=checkbox]').live('change', function(){
        changeselected(this)
    });
    
    $(document).ready(function(){
        $('#msgtoselector input[type=checkbox]').each(function(){
            changeselected(this)
        });
    });
    
    function toggleselection($selectall){
        var id = $('#msgtoselector input[type=checkbox]');
        $(id).each(function(){
            if($selectall){
                //alert("Got signal to check checkboxes");
                $(this).attr('checked', true);
                changeselected(this)
            }else{
                //alert("Got signal to uncheck checkboxes");
                $(this).attr('checked', false);
                changeselected(this)
            }
        });
    }
    
    function changeselected(id){
        var temp = $(id).closest('label');
        if($(id).attr('checked') == 'checked'){
            $(temp).addClass('selected');
        }else{
            $(temp).removeClass('selected');
        }
    }
    
    function changeallselector(){
        $('#msgtoselector input[type=checkbox]').each(function(){
            changeselected(this)
        });
    }
    
    $('#msgtoselector #selectclass').live('change', function(){
        loadclasses();
    });
    
    function loadclasses(){
        var temp = $('#msgtoselector #selectclass').val();
        $('#msgtoselector #mgs').html("<div class='loading'></div>");
        $.get('listner.php?page=selector&class='+temp, function(data){
            $('#msgtoselector #mgs').html(data);
            changeallselector();
        });
    }
    
    $(document).ready(function() {
      setTimeout(function(){ 
          $('#fadeout').fadeOut('slow');
      }, 3000);
    });
    
    $('a.delfile').live('click', function(e){
        e.preventDefault();
        if(confirm('Are you sure, you want to remove this attachment?')){
        var id = $(this);
        $.get($(this).attr('href'), function(d){
            $(id).parent('div').hide();
        })
        }
    });
 
    function uploadfile(form, action_url) {
        // Create the iframe...
        var iframe = document.createElement("iframe");
        iframe.setAttribute("id", "upload_iframe");
        iframe.setAttribute("name", "upload_iframe");
        iframe.setAttribute("width", "0");
        iframe.setAttribute("height", "0");
        iframe.setAttribute("border", "0");
        iframe.setAttribute("style", "width: 0; height: 0; border: none;");
        
        // Add to document...
        form.parentNode.appendChild(iframe);
        window.frames['upload_iframe'].name = "upload_iframe";
     
        iframeId = document.getElementById("upload_iframe");
     
        // Add event...
        var eventHandler = function () {
                if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
                else iframeId.removeEventListener("load", eventHandler, false);
                // Message from server...
                if (iframeId.contentDocument) {
                    content = iframeId.contentDocument.body.innerHTML;
                } else if (iframeId.contentWindow) {
                    content = iframeId.contentWindow.document.body.innerHTML;
                } else if (iframeId.document) {
                    content = iframeId.document.body.innerHTML;
                }
                // Del the iframe...
                //alert(content);
                $("#uploadingwait").hide();
                disableform = false;
                //alert(content);
                var d = $.parseJSON(content);
                
                $(".attachedfiles").append(d.result);
                $("#datafile").val("");
                setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
            }
        if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
        if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
        // Set properties of form...
        form.setAttribute("target", "upload_iframe");
        form.setAttribute("action", action_url);
        form.setAttribute("method", "post");
        form.setAttribute("enctype", "multipart/form-data");
        form.setAttribute("encoding", "multipart/form-data");
        // Submit the form...
        
        form.submit();
        
        $("#uploadingwait").show();
        disableform = true;
    }
    
    function updatedraft(id, draftid){
        var name = $(id).attr('name');
        var url = 'controller.php?page=mail&ajaxrequest=ajaxrequest&type=draftsave&name='+name+'&id='+draftid+'&value='+$(id).val();
        //alert(url);
        $.get(url, function(data){
            //alert(data);
            var d = $.parseJSON(data);
            $('#autosave_status').html(d.result);
        });
        
    }
    
    $(".class_box_new").hover(function(){
        //$(this).find(".cb_overlay").slideUp("fast");
        var id = $(this).find(".cb_overlay");
        $(id).fadeOut('fast');
    },
    function(){
        //$(this).find(".cb_overlay").slideDown("fast");
        var id = $(this).find(".cb_overlay");
        $(id).fadeIn('fast');
    });
    
    function upnhidebox(id){
        var par = $(id).closest('li');
        $(par).find('a.ajaxify').show();
        $(par).find('div.ajaxresult').hide();
        $(par).find('.tabrowcontentajaxresult').html('');
    }
    