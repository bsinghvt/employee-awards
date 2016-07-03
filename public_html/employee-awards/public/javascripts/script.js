function deleteNormalUser(key, URL){
    var row = document.getElementById(key);
    $.ajax({url: URL,
            data: {"uid":key},
            success: function(data){
                $("#msg").html(data.msg);
                if(data.success === 'yes'){
                    row.style.display = "none";
                }
    }});
}