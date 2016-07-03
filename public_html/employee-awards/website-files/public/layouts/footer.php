</div>
        <footer>
            <p >Copyright&copy;&nbsp;<?php echo date("Y", time());?>&nbsp;Green Arrow Consulting</p>
        </footer>
		<script src="<?php if(isset($script)){echo $script;} ?>" type="text/javascript"></script>
    </body>
</html>
<?php 
if(isset($database)) {
    $database->close_connection();
}
?>