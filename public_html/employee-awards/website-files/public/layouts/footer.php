</div>
        <footer>
            <p >Copyright&copy;&nbsp;<?php echo date("Y", time());?>&nbsp;Green Arrow Consulting</p>
        </footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php if(isset($export_table)){echo $export_table;} ?>" type="text/javascript"></script>
		<script src="<?php if(isset($script)){echo $script;} ?>" type="text/javascript"></script>
    </body>
</html>
<?php 
if(isset($database)) {
    $database->close_connection();
}
?>