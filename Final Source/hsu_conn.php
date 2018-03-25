<?php
    function hsu_conn($usr, $pwd)
    {
        // set up db connection string

        $db_conn_str = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        // let's try to log on using this string!

        $connctn = oci_connect($usr, $pwd, $db_conn_str);

        // CAN I complain and exit from HERE if fails?

        if (! $connctn)
        {
        ?>
            <p> Could not log into Oracle, sorry. </p>
</body>
</html>
            <?php
            exit;
        }

        return $connctn;
    }
?>