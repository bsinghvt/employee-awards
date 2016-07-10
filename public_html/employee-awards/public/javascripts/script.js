/*********************************** */
/*Function add filters to data tabel*/
/********************************** */
function addFilter() {
    //Function to filter usesrs https://datatables.net/examples/api/
    // Setup - add a text input to each footer cell
    $('#displaytable tfoot th').each(function() {
        var title = $(this).text();
        if (title.toUpperCase() === 'UPDATE' || title.toUpperCase() === 'DELETE') {
            $(this).html('<input type="hidden" />');
        } else {
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });
    // DataTable
    var table = $('#displaytable').DataTable();
    // Apply the search
    table.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });
}
/********************************** */
//Function to append more options for how many records to display
/********************************** */
function moreOptions() {
    $("select[name = 'displaytable_length']").append('<option value="500">500</option>');
    $("select[name = 'displaytable_length']").append('<option value="1000">1000</option>');
    $("select[name = 'displaytable_length']").append('<option value="5000">5000</option>');
    $("select[name = 'displaytable_length']").append('<option value="10000">10000</option>');
}
/********************************** */
//Function to delete a user
/********************************** */
function deleteNormalUser(username, key, URL) {
    var row = document.getElementById(key);
    $.ajax({
        method: "POST",
        url: URL,
        data: {
            "uid": key,
            "name": username
        },
        success: function(data) {
            $("#msg").html(data.msg);
            if (data.success === 'yes') {
                row.style.display = "none";
                row.remove();
            }
        }
    });
}
/********************************** */
//Function to delete a user
/********************************** */
function deleteAdmin(username, key, URL) {
    var row = document.getElementById(key);
    $.ajax({
        method: "POST",
        url: URL,
        data: {
            "id": key,
            "name": username
        },
        success: function(data) {
            $("#msg").html(data.msg);
            if (data.success === 'yes') {
                row.style.display = "none";
                row.remove();
            }
        }
    });
}
/********************************** */
//Function to dynamically filter data with date
/********************************** */
function withDateFilter(event, minAward, maxAward, minDate, maxDate) {
    $("tr.odd").each(function(index, element) {
        var row = $(element).children();
        if (row[event.data.awardRow].textContent >= minAward && row[event.data.awardRow].textContent <= maxAward &&
            new Date(row[event.data.dateRow].textContent).setHours(0, 0, 0, 0) >= new Date(minDate).setHours(0, 0, 0, 0) &&
            new Date(row[event.data.dateRow].textContent).setHours(0, 0, 0, 0) <= new Date(maxDate).setHours(0, 0, 0, 0)) {
            $(element).show();
            $(element).removeClass("noExl");
        } else {
            $(element).hide();
            $(element).addClass("noExl");
        }
    });
    $("tr.even").each(function(index, element) {
        var row = $(element).children();
        if (row[event.data.awardRow].textContent >= minAward && row[event.data.awardRow].textContent <= maxAward &&
            new Date(row[event.data.dateRow].textContent).setHours(0, 0, 0, 0) >= new Date(minDate).setHours(0, 0, 0, 0) &&
            new Date(row[event.data.dateRow].textContent).setHours(0, 0, 0, 0) <= new Date(maxDate).setHours(0, 0, 0, 0)) {
            $(element).show();
            $(element).removeClass("noExl");
        } else {
            $(element).hide();
            $(element).addClass("noExl");
        }
    });
}
/********************************** */
//Function to dynamically filter data without date
/********************************** */
function withoutDateFilter(event, minAward, maxAward) {
    $("tr.odd").each(function(index, element) {
        var row = $(element).children();
        if (row[event.data.awardRow].textContent >= minAward && row[event.data.awardRow].textContent <= maxAward) {
            $(element).show();
            $(element).removeClass("noExl");
        } else {
            $(element).hide();
            $(element).addClass("noExl");
        }
    });
    $("tr.even").each(function(index, element) {
        var row = $(element).children();
        if (row[event.data.awardRow].textContent >= minAward && row[event.data.awardRow].textContent <= maxAward) {
            $(element).show();
            $(element).removeClass("noExl");
        } else {
            $(element).hide();
            $(element).addClass("noExl");
        }
    });
}
/********************************** */
//Function to dynamically filter data
/********************************** */
function filterData(event) {
    var minAward = 0;
    var maxAward = 50000;
    var maxDate = "01/01/2070";
    var minDate = "01/01/1970";
    if ($.trim($("#minaward").val()) !== "" && !isNaN($("#minaward").val())) {
        minAward = parseInt($("#minaward").val());
    }

    if ($.trim($("#maxaward").val()) !== "" && !isNaN($("#maxaward").val())) {
        maxAward = parseInt($("#maxaward").val());
    }

    if ($.trim($("#mindate").val()) !== "") {
        var dateArr = ($("#mindate").val()).split('-');
        minDate = dateArr[1] + '/' + dateArr[2] + '/' + dateArr[0];
    }

    if ($.trim($("#maxdate").val()) !== "") {
        var dateArr = ($("#maxdate").val()).split('-');
        maxDate = dateArr[1] + '/' + dateArr[2] + '/' + dateArr[0];
    }
    if (event.data.isDateFilter) {
        withDateFilter(event, minAward, maxAward, minDate, maxDate);
    } else {
        withoutDateFilter(event, minAward, maxAward);
    }
}
/********************************** */
//Function to display awards based on user input
/********************************** */
function dispOptions(event) {
    var maxDate = "2070-01-01";
    var minDate = "1970-01-01";
    if ($.trim($("#mindate").val()) !== "") {
        minDate = $("#mindate").val();
    }

    if ($.trim($("#maxdate").val()) !== "") {
        maxDate = $("#maxdate").val();
    }

    $.ajax({
        method: "POST",
        url: event.data.url,
        data: {
            "mindate": minDate,
            "maxdate": maxDate
        },
        complete: function(r) {
            $("#awards").html(r.responseText);
            addFilter();
            moreOptions();
        }
    });
}
/********************************** */
/********************************** */
//OnDocument ready
/********************************** */
/********************************** */
$(document).ready(function() {
    //Function to export data as excel sheet
    //http://www.jqueryscript.net/table/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel.html
    $(document).on("click", "#exportsheet", function() {
        $("#displaytable").table2excel({
            exclude: ".noExl",
            name: "Results"
        });
    });

    $(document).on('click', '#dispallawards', {
        url: "../website-files/public/layouts/dispallawards.php"
    }, dispOptions);
    $(document).on('click', '#dispawardsbyrec', {
        url: '../website-files/public/layouts/dispawardsbyrec.php'
    }, dispOptions);
    $(document).on('click', '#dispawardsbygiver', {
        url: '../website-files/public/layouts/dispawardsbygiver.php'
    }, dispOptions);

    //Call function to add filter to data table
    addFilter();
    //Prevent form submission when fields are empty
    $('#userform').submit(function() {
        if ($.trim($("#useremail").val()) === "" || $.trim($("#userpwd").val()) === "" ||
            $.trim($("#userfirstname").val()) === "" || $.trim($("#userlastname").val()) === "" ||
            $.trim($("#userjobtitle").val()) === "" || $.trim($("#usersign").val()) === "") {
            alert('Please fill all required fields and upload a valid signature image');
            return false;
        }
    });

    //Function to filter data between dates and min and max awards
    $(document).on("click", "#filterdata", {
        isDateFilter: true,
        dateRow: 5,
        awardRow: 4
    }, filterData);
    //Function to filter data between min and max awards
    $(document).on("click", "#filterdataaward", {
        isDateFilter: false,
        awardRow: 2
    }, filterData);

});
/********************************** */
/********************************** */
//On Window load
/********************************** */
/********************************** */
$(window).load(function() {
    moreOptions();
});