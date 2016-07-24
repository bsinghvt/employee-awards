/*********************************** */
/*Load the Google Visualization API and the corechart package.*/
/********************************** */
google.charts.load('current', {
   packages: ['corechart', 'bar']
});
/*********************************** */
/*Function to generate charts using Google Charts API*/
/********************************** */
function drawBarChart(dataArray, event) {
   google.charts.setOnLoadCallback(drawBasic);

   function drawBasic() {
      // Set a callback to run when the Google Visualization API is loaded.
      var data = google.visualization.arrayToDataTable(dataArray, false);
      //Options For chart title etc.
      var options = {
         title: event.data.title
         , hAxis: {
            title: event.data.awardHeader
            , minValue: 0
            , format: '0'
         }
         , vAxis: {
            title: event.data.nameHeader
         }
      };
      // Instantiate and draw our chart, passing in some options
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function() {
         document.getElementById('chart_print').outerHTML = '<a href="' + chart.getImageURI() + '" target="_blank" class="btn btn-link btn-block">Printable Chart Version (Not Supported in IE)</a>';
      });
      chart.draw(data, options);
   }
}
/*********************************** */
/*Function add filters to data tabel*/
/********************************** */
function addFilter() {
   //Function to filter usesrs https://datatables.net/examples/api/
   // Setup - add a text input to each footer cell
   $('#displaytable tfoot th').each(function() {
      var title = $(this).text();
      if(title.toUpperCase() === 'UPDATE' || title.toUpperCase() === 'DELETE') {
         $(this).html('<input type="hidden" />');
      } else {
         $(this).html('<input type="text" placeholder="' + title + '" />');
      }
   });
   // DataTable
   var table = $('#displaytable').DataTable({
      "bInfo": true
      , "paging": true
   });
   // Apply the search
   table.columns().every(function() {
      var that = this;
      $('input', this.footer()).on('keyup change', function() {
         if(that.search() !== this.value) {
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
   $("select[name = 'displaytable_length']").append('<option value="100000">100000</option>');
}
/********************************** */
//Function to delete a user
/********************************** */
function deleteNormalUser(username, key, sig, URL) {
   var row = document.getElementById(key);
   $.ajax({
      method: "POST"
      , url: URL
      , data: {
         "uid": key
         , "name": username
         , "sig": sig
      }
      , success: function(data) {
         $("#msg").html(data.msg);
         if(data.success === 'yes') {
            var table = $('#displaytable').DataTable();
            table.row(row).remove().draw();
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
      method: "POST"
      , url: URL
      , data: {
         "id": key
         , "name": username
      }
      , success: function(data) {
         $("#msg").html(data.msg);
         if(data.success === 'yes') {
            var table = $('#displaytable').DataTable();
            table.row(row).remove().draw();
         }
      }
   });
}
/********************************** */
//Function to dynamically filter data with date
/********************************** */
function withDateFilter(event) {
   $.fn.dataTable.ext.search.push(function(settings, oData, dataIndex) {
      var minAward = parseInt($("#minaward").val(), 10);
      var maxAward = parseInt($("#maxaward").val(), 10);
      if(isNaN(minAward)) {
         minAward = 0;
      }
      if(isNaN(maxAward)) {
         maxAward = 10000000;
      }
      var dateArr = ($("#mindate").val()).split('-');
      var minDate = new Date(dateArr[1] + '/' + dateArr[2] + '/' + dateArr[0]).setHours(0, 0, 0, 0);
      var dateArr = ($("#maxdate").val()).split('-');
      var maxDate = new Date(dateArr[1] + '/' + dateArr[2] + '/' + dateArr[0]).setHours(0, 0, 0, 0);
      var num = oData[event.data.awardRow];
      var date = new Date(oData[event.data.dateRow]).setHours(0, 0, 0, 0);
      if(num >= minAward && num <= maxAward && date >= minDate && date <= maxDate) {
         return true;
      }
      return false;
   });
}
/********************************** */
//Function to dynamically filter data without date
/********************************** */
function withoutDateFilter(event) {
   $.fn.dataTable.ext.search.push(function(settings, oData, dataIndex) {
      var minAward = parseInt($("#minaward").val(), 10);
      var maxAward = parseInt($("#maxaward").val(), 10);
      if(isNaN(minAward)) {
         minAward = 0;
      }
      if(isNaN(maxAward)) {
         maxAward = 10000000;
      }
      var num = oData[event.data.awardRow];
      if(num >= minAward && num <= maxAward) {
         return true;
      } else {
         return false;
      }
   });
}
/********************************** */
//Function to dynamically filter data
/********************************** */
function filterData(event) {
   if(event.data.isDateFilter) {
      withDateFilter(event);
   } else {
      withoutDateFilter(event);
   }
   var table = $('#displaytable').DataTable();
   table.draw();
}
/********************************** */
//Function to get table data for chart generation
/********************************** */
function getTableData(event) {
   var table = $("#displaytable tbody");
   var dataArray = [];
   dataArray.push([event.data.nameHeader, event.data.awardHeader]);
   table.find('tr').each(function() {
      var tds = $(this).find('td')
         , name = tds.eq(event.data.nameCol).text()
         , award = tds.eq(event.data.awardCol).text();
      var arr = [];
      if(!isNaN(parseInt(award))) {
         arr.push(name);
         arr.push(parseInt(award));
         dataArray.push(arr);
      }
   });
   if(dataArray.length > 1) {
      $('#chart_div').show();
      $('#chart_div').css({
         "width": "1300px"
         , "height": "800px"
      });
      drawBarChart(dataArray, event);
   } else {
      $('#chart_div').hide();
   }
}
/********************************** */
//Function to display awards based on user input
/********************************** */
function dispOptions(event) {
   var maxDate = "2070-01-01";
   var minDate = "1970-01-01";
   if($.trim($("#mindate").val()) !== "") {
      minDate = $("#mindate").val();
   }

   if($.trim($("#maxdate").val()) !== "") {
      maxDate = $("#maxdate").val();
   }
   var url = event.data.url;
   window.location.href = window.location.href.split('?')[0] + "?disp=" + url + "&mindate=" + minDate + "&maxdate=" + maxDate;
}
/********************************** */
/********************************** */
//OnDocument ready
/********************************** */
/********************************** */
$(document).ready(function() {
   $('#chart_div').hide();
   //Function to export data as excel sheet
   //http://www.jqueryscript.net/table/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel.html
   $(document).on("click", "#exportsheet", function() {
      $("#displaytable").table2excel({
         exclude: ".noExl"
         , name: "Results"
      });
   });

   $(document).on('click', '#dispallawards', {
      url: "all"
   }, dispOptions);
   $(document).on('click', '#dispawardsbyrec', {
      url: 'rec'
   }, dispOptions);
   $(document).on('click', '#dispawardsbygiver', {
      url: 'giv'
   }, dispOptions);
   $(document).on('click', '#dispawardsbytype', {
      url: 'type'
   }, dispOptions);
   //Call function to add filter to data table
   addFilter();
   //Prevent form submission when fields are empty
   $('#userform').submit(function() {
      if($.trim($("#useremail").val()) === "" || $.trim($("#userpwd").val()) === "" ||
         $.trim($("#userfirstname").val()) === "" || $.trim($("#userlastname").val()) === "" ||
         $.trim($("#userjobtitle").val()) === "" || $.trim($("#usersign").val()) === "") {
         alert('Please fill all required fields and upload a valid signature image');
         return false;
      }
   });

   //Function to filter data between dates and min and max awards
   $(document).on("click", "#filterdata", {
      isDateFilter: true
      , dateRow: 4
      , awardRow: 3
   }, filterData);
   //Function to filter data between min and max awards
   $(document).on("click", "#filterdataaward", {
      isDateFilter: false
      , awardRow: 2
   }, filterData);
   //Function to filter data between min and max awards
   $(document).on("click", "#filterdataawardtype", {
      isDateFilter: false
      , awardRow: 1
   }, filterData);

   //Function to listen click event to generate charts for recipient
   $(document).on("click", "#drawchartrec", {
         nameHeader: "Recipient Name"
         , awardHeader: "Total Awards"
         , title: "Recipient Awards Chart"
         , nameCol: 0
         , awardCol: 2
      }
      , getTableData);
   //Function to listen click event to generate charts for Giver
   $(document).on("click", "#drawchartgiv", {
         nameHeader: "Award Giver Name"
         , awardHeader: "Total Awards"
         , title: "Awards Giver Chart"
         , nameCol: 0
         , awardCol: 2
      }
      , getTableData);
   //Function to listen click event to generate charts for award type
   $(document).on("click", "#drawcharttype", {
         nameHeader: "Award Type"
         , awardHeader: "Total Awards"
         , title: "Award Type Chart"
         , nameCol: 0
         , awardCol: 1
      }
      , getTableData);

});
/********************************** */
/********************************** */
//On Window load
/********************************** */
/********************************** */
$(window).load(function() {
   moreOptions();
});