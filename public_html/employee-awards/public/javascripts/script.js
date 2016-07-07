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
    }});
}

//Function to filter usesrs https://datatables.net/examples/api/
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#displaytable tfoot th').each( function () {
        var title = $(this).text();
        if(title.toUpperCase() === 'UPDATE' || title.toUpperCase() === 'DELETE'){
            $(this).html( '<input type="hidden" />' );
        }
        else{
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
        
    } );
 
    // DataTable
    var table = $('#displaytable').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );

//Function to export data as excel sheet
//http://www.jqueryscript.net/table/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel.html
$("#exportsheet").click(function(){
  $("#displaytable").table2excel({
    exclude: ".noExl",
    name: "Data"
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