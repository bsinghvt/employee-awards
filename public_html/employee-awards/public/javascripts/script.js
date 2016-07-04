//Function to delete a user
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

//Function to filter usesrs https://datatables.net/examples/api/
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#displaytable tfoot th').each( function () {
        var title = $(this).text();
        if(title.toUpperCase() === 'ACTION'){
            $(this).html( '<input type="hidden" />' );
        }
        else{
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
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