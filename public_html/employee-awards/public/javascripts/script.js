 //Function to delete a user
function deleteNormalUser(username, key, URL){
    var row = document.getElementById(key);
    $.ajax({
        method: "POST",
        url: URL,
        data: {
            "uid":key, "name" : username},
        success: function(data){
            $("#msg").html(data.msg);
            if(data.success === 'yes'){
                row.style.display = "none";
            }
        }
    });
}
$(document).ready(function() {
    //Function to export data as excel sheet
    //http://www.jqueryscript.net/table/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel.html
    $('#exportsheet').on('click', function(e){
        $("#displaytable").table2excel({
            exclude: ".noExl",
            name: "Results"
        });
    });
    //Function to filter usesrs https://datatables.net/examples/api/
    // Setup - add a text input to each footer cell
    $('#displaytable tfoot th').each( function () {
        var title = $(this).text();
        if(title.toUpperCase() === 'UPDATE' || title.toUpperCase() === 'DELETE'){
            $(this).html( '<input type="hidden" />' );
        }
        else{
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
    });
    // DataTable
    var table = $('#displaytable').DataTable();
    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if (that.search() !== this.value) {
                that
                .search(this.value)
                .draw();
            }
        });
    });
    //Prevent form submission when fields are empty
    $('#userform').submit(function() {
        if ($.trim($("#useremail").val()) === "" || $.trim($("#userpwd").val()) === ""
            || $.trim($("#userfirstname").val()) === "" || $.trim($("#userlastname").val()) === ""
            || $.trim($("#userjobtitle").val()) === "" || $.trim($("#usersign").val()) === "") {
            alert('Please fill all required fields and upload a valid signature image');
            return false;
        }
    });

    //Function to filter data between dates and min and max awards
    $("#filterdata").click(function(){
        var minAward = "0";
        var maxAward = "50000";
        var maxDate = "01/01/2070";
        var minDate = "01/01/1970";
        if($.trim($("#minaward").val()) !== ""){
            minAward = $("#minaward").val();
        }
    
        if($.trim($("#maxaward").val()) !== ""){
            maxAward = $("#maxaward").val();
        }
    
        if($.trim($("#mindate").val()) !== ""){
            minDate = $("#mindate").val();
        }
    
        if($.trim($("#maxdate").val()) !== ""){
            maxDate = $("#maxdate").val();
        }

        $("tr.odd").each(function(index, element){
            var row = $(element).children();
            if(row[4].textContent >= minAward && row[4].textContent <= maxAward && 
                new Date(row[5].textContent) >= new Date(minDate) && new Date(row[5].textContent) <= new Date(maxDate)){
                $(element).show();
                $(element).removeClass("noExl");
            }
            else{
                $(element).hide();
                 $(element).addClass("noExl");
            }
        });
        $("tr.even").each(function(index, element){
            var row = $(element).children();
            if(row[4].textContent >= minAward && row[4].textContent <= maxAward && 
                new Date(row[5].textContent) >= new Date(minDate) && new Date(row[5].textContent) <= new Date(maxDate)){
                $(element).show();
                $(element).removeClass("noExl");
            }
            else{
                    $(element).hide();
                    $(element).addClass("noExl");
            }
        });
    });
});