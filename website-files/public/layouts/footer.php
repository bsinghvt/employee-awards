</div>
        <footer>
            <p >Copyright&copy;&nbsp;<?php echo date("Y", time());?>&nbsp;Baljot Singh</p>
        </footer>
    </body>
</html>
<?php 
if(isset($database)) {
    $database->close_connection();
}
?>