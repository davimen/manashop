<?php
include("index_table.php");
?>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">IMPORT THANH VIEN THAM GIA</div></td></tr></tbody></table>
<?php


		// import
		if (isset($_POST['submit'])) {

			// check
		   $file_import = $_POST["file_import"];
			if ($file_import=="") {
			 	$arr['errorMsg'] = 'Upload Failed! Check file name, or capacity';
			} else {
					// read file
					try {

					     /** Include PHPExcel */
                        require_once 'PHPExcel/Classes/PHPExcel.php';

						$objReader = PHPExcel_IOFactory::createReader('Excel5');
                        $file_name = $_SERVER["DOCUMENT_ROOT"].$file_import;
						$objPHPExcel = $objReader->load($file_name);

						$objPHPExcel->setActiveSheetIndex(0);
						$sheet = $objPHPExcel->getActiveSheet();

						$rowStart = 2;
						$batchLimit = 10000;
						$i = $rowStart;
						$dupCustomer = 0;
						while (1) {
							$item_code      = $sheet->getCell('B' . $i)->getValue();
							$item_name      = $sheet->getCell('C' . $i)->getValue();
                            $dang           = $sheet->getCell('D' . $i)->getValue();
                            $bao_kg         = $sheet->getCell('E' . $i)->getValue();
                            $unit           = $sheet->getCell('F' . $i)->getValue();
                            $quantity       = $sheet->getCell('G' . $i)->getValue();
							$price          = $sheet->getCell('H' . $i)->getValue();
                            $price_trietkhau= $sheet->getCell('I' . $i)->getValue();
                            $dateupdated    = date("d-m-Y",time());

                            $isDuplicate = $dbf->checkDuplicateImportMathang($item_code, $bao_kg);
							$dupCustomer += $isDuplicate;

							if (!$isDuplicate && !empty($item_code) && !empty($bao_kg))
                            {
                                 // will optimize later
                                $sql.="INSERT INTO mathang(item_code,item_name,dang,bao_kg,unit,quantity,price,price_trietkhau,dateupdated) VALUES ('".$item_code."','".$item_name."','".$dang."','".$bao_kg."','".$unit."',".(int)$quantity.",".(int)$price.",".(int)$price_trietkhau.",'".strtotime($dateupdated)."'); ";
                            }

							if (empty($item_code) && empty($bao_kg))
                            {
								break;
							}

                            if (($i%$batchLimit == 0) && $sql!="")
                            {
							    // Create connection
                                $conn = new mysqli(HOSTADDRESS, DBACCOUNT, DBPASSWORD,DBNAME);
                                // Check connection
                                $conn->set_charset("utf8");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                if ($conn->multi_query($sql) === TRUE) {
                                    //echo "New records created successfully";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }

                                $conn->close();
								$sql ="";
							}
							$i++;
						}

						if (!empty($sql)) {
                             // Create connection
                                $conn = new mysqli(HOSTADDRESS, DBACCOUNT, DBPASSWORD,DBNAME);
                                // Check connection
                                 $conn->set_charset("utf8");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                if ($conn->multi_query($sql) === TRUE) {
                                    //echo "New records created successfully";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }

                                $conn->close();
						}
						$arr['sucessMsg'] = 'Import '.($i - $dupCustomer - $rowStart).' row(s) successfully! ' . $dupCustomer . " row(s) duplicated!";
					} catch (Exception $ex) {
						$arr['errorMsg'] = 'Upload Failed!' . $ex->getMessage();
					}

			}
		}

    ?>
<div class="is_bg" style="border: 0px solid red; text-align: left; padding: 20px;">
<form role="form" action="" method="post" enctype="multipart/form-data">
  <div class="form-group" style="float:left; width: 400px;">
  	<div class="alert alert-warning">
      <span style="color: red">
      <b><?php echo $arr['sucessMsg'];?>
      <?php echo $arr['errorMsg'];?></b>
      </span><br/>

	  <strong>Chú ý !</strong> Chỉ chấp nhập file excel (*.xls), đúng định dạng <u><i data-toggle="tooltip" title="Colum A:Mã mặt hàng,Colum B:Tên mặt hàng,Colum C:Giá">Rê chuột vào để biết thêm chi tiết</i></u>
	</div>
    <label for="fName">File Name:</label>
    <span class="btn btn-primary btn-file">
        <!--Browse <input type="file" id="fName" name="fName">!-->
         <table border="0" cellpadding="0" cellspacing="0">
          <tbody><tr><td width="20%">
                <input onfocus="this.select()" name="file_import" value="" type="text" class="" id="file_import">
				</td>
				<td valign="bottom" style="padding-left:5px;">
					<input name="btn1" class="btncenter" type="button" onclick="modelessDialogShow('<?php echo Editor;?>ffilter=all&amp;object1=file_import&amp;type=2','auto','auto');" id="btn1" value="Browse...">
				</td>
				</tr>
				</tbody>
          </table>


    </span>
    <button type="submit" class="btn btn-default" name="submit" value="Submit">Import</button>
  </div>
   <div style="float:left; padding: 50px; border-left:1px solid #f1f1f1; margin-left: 50px; ">
          <div class="clear"></div>
          <button type="button" id="export_mathang" class="btn btn-default" name="export" value="Export">Export mặt hàng</button>
   </div>
   <div class="clear"></div>
</form>
</div>

<script>
$( "#export_mathang" ).click(function() {
    openBox('export.php',792,650);
});
</script>