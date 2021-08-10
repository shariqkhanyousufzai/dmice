<?php
set_time_limit(3000);
// set up basic connection
$ftp_host = "4.79.60.130";
$ftp_user = "97812";
$ftp_password = "gBT97812Rfs";

//Connect
// echo "<br />Connecting to $ftp_host via FTP...";
$conn = ftp_connect($ftp_host);
$login = ftp_login($conn, $ftp_user, $ftp_password);

//
//Enable PASV ( Note: must be done after ftp_login() )
//
$mode = ftp_pasv($conn, TRUE);

//Login OK ?
if ((!$conn) || (!$login) || (!$mode)) {
   die("FTP connection has failed !");
}
// echo "<br />Login Ok.<br />";

//
//Now run ftp_nlist()
//
$file_list = ftp_nlist($conn, "Archive");
//getting the latest file
$latest_file =  end($file_list);
$contents = file_get_contents("ftp://$ftp_user:$ftp_password@$ftp_host/Archive/$latest_file");
file_put_contents("file/$latest_file",$contents);
//close
ftp_close($conn);
