<?php
set_time_limit(3000);
ini_set('memory_limit', '4095M');
require_once "config.php";
//get the latest file from our directory 
$files = glob('file/*', GLOB_BRACE);
$get_latest_file = end($files);
// now read the file
// $row = 1;
// $csv = array_map('str_getcsv', file("$get_latest_file"));
// for ($i=1; $i < count($csv); $i++) {
// 	//getting main cat
// 	$query = "SELECT MainCatName FROM csv_products_category where MainCatCode = '".$csv[$i][4]."' ";
// 	$result = mysqli_query($conn, $query);
// 	$row = mysqli_fetch_assoc($result);
// 	$mainCatName = $row['MainCatName'];

// 	//getting the sub cat
// 	$query = "SELECT SubCatName FROM csv_products_category where SubCatCode = '".$csv[$i][9]."' ";
// 	$result = mysqli_query($conn, $query);
// 	$row = mysqli_fetch_assoc($result);
// 	$subCatName = $row['SubCatName'];

// 	//insert record to db
// 	$sqlInsert = "INSERT INTO `csv_products`(`SKU`, `ITEMID`, `DESCRIPTION`, `VENDOR`, `CAT`, `PRICE`, `Weight`, `SIZE`, `UNIT`, `SUB-CATEGORY`, `STATUS`, `FR`, `LA`, `AT`, `CH`, `DA`, `HO`, `KA`, `NJ`, `TA`, `MI`, `PO`, `MH`) VALUES ('".$csv[$i][0]."','".$csv[$i][1]."','".$csv[$i][2]."','".$csv[$i][3]."','".$mainCatName."','".$csv[$i][5]."','".$csv[$i][6]."','".$csv[$i][7]."','".$csv[$i][8]."','".$subCatName."','".$csv[$i][10]."','".$csv[$i][11]."','".$csv[$i][12]."','".$csv[$i][13]."','".$csv[$i][14]."','".$csv[$i][15]."','".$csv[$i][16]."','".$csv[$i][17]."','".$csv[$i][18]."','".$csv[$i][19]."','".$csv[$i][20]."','".$csv[$i][21]."','".$csv[$i][22]."')";
// 	if (mysqli_query($conn, $sqlInsert)) {
// 	} else {
// 		echo "Error creating table: <br>" .$sqlInsert. "<br> at row: ".$excelrow." <hr>";
// 	}
// }
//save the file to directory
$filename = 'product_csv';
$csv_filename = $filename."_".date("Y-m-d_H-i",time()).".csv";
$output = fopen ('generated/'.$csv_filename, "w");
fputcsv($output, array('SKU', 'Name', 'Description', 'Stock', 'Weight (kg)', 'Categories', 'images')); 

$query = "SELECT `SKU`,`ITEMID`,`DESCRIPTION`,(SUM(`FR`)+SUM(`LA`)+SUM(`AT`)+SUM(`CH`)+SUM(`DA`)+SUM(`HO`)+SUM(`KA`)+SUM(`NJ`)+SUM(`TA`)+SUM(`MI`)+SUM(`PO`)+SUM(`MH`)) AS stock,`Weight`,GROUP_CONCAT(`CAT`,'>',`SUB-CATEGORY`),GROUP_CONCAT('images/',SKU,'.jpg') AS images FROM csv_products GROUP BY SKU"; 

$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result))  
{  
	fputcsv($output, $row);  
}
fclose($output);




