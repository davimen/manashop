<?php
include("index_table.php");

if(isset($_POST['cmdLogDoanhThu']))
{
  $ngay  = date('d');
  $thang = date('m');
  $nam   = date('y');
  $date_bangiao = strtotime($nam . "-" . $thang . "-" . $ngay);
  $giotao = date('H') . ":" . date('i') . ":" . date('s');
  $dbf->deleteDynamic("log_doanhthu","datecreated=".$date_bangiao."");

  $rst_group =$dbf->getDynamic("city_vietnam","status=1","");
  $total_group = $dbf->totalRows($rst_group);
  if($total_group >0)
  {
     $array_group = array();
     while($rows_group = $dbf->nextdata($rst_group))
     {
          //khoi tao
          $array_group[$rows_group["id"]]["title"] = $rows_group['title'];
          $array_group[$rows_group["id"]]["tongsotienthongke"]=0;
          $array_group[$rows_group["id"]]["tienmat"]=0;
          $array_group[$rows_group["id"]]["tiendatcoc"]=0;
          $array_group[$rows_group["id"]]["tienno"]=0;

          $rst_khachhang=$dbf->getDynamic("khachang","tinhthanh_id=".(int)$rows_group["id"]." and status=1","id asc");
          $toal_khachhang = $dbf->totalRows($rst_khachhang);
          if($toal_khachhang >0)
          {
              $tongsotienthongke_all=0;
              while($rows_khachhang= $dbf->nextdata($rst_khachhang))
               {
                    $id_khachhang    = $rows_khachhang['id'];
                    $title_khachhang = stripcslashes($rows_khachhang['title']);

                    $rst=$dbf->getDynamic("hoadon","((ngay=".$ngay." and thang=".$thang." and nam=".$nam.") or dateupdated = ".$date_bangiao.") and khachang_id=".$id_khachhang."","");
                    $total = $dbf->totalRows($rst);
                    if($total >0)
                    {
                      while($rows = $dbf->nextdata($rst))
                      {
                         $tongsotien = stripcslashes($rows['tongsotien']);

                         if($rows['dateupdated']==$rows['datecreated'] || (int)$rows['dateupdated']==0 )
                         {
                            $array_group[$rows_group["id"]]["tongsotienthongke"]+= $tongsotien;
                         }

                         if($rows["thanhtoan_id"]==5){

                            if($rows['dateupdated']>0)
                            {
                                $array_group[$rows_group["id"]]["tienmat"]+= ($tongsotien - $rows['datoc']);
                            }else
                            {
                                $array_group[$rows_group["id"]]["tienmat"]+= $tongsotien;
                            }

                         }else if($rows["thanhtoan_id"]==8)
                         {
                            $array_group[$rows_group["id"]]["tiendatcoc"]+= $rows['datoc'];
                         }else
                         {
                            $array_group[$rows_group["id"]]["tienno"]+= $tongsotien;
                         }

                         //$array_col = array("hoadon_id" => $rows_no_datcoc["id"],"ngay" => $rows_no_datcoc["ngay"], "thang" => $rows_no_datcoc["thang"], "nam" => $rows_no_datcoc["nam"], "giotao" => $rows_no_datcoc["giotao"], "sohoadon" => $rows_no_datcoc["sohoadon"], "fullname_sell" => $rows_no_datcoc["fullname_sell"], "khachang_id" => $rows_no_datcoc["khachang_id"], "fullname_dv" => $rows_no_datcoc["fullname_dv"], "address" => $rows_no_datcoc["address"], "mst" => $rows_no_datcoc["mst"], "thanhtoan_id" => $rows_no_datcoc["thanhtoan_id"], "datcoc" => $rows_no_datcoc["datcoc"], "nhanvien_id" => $rows_no_datcoc["nhanvien_id"], "nhanvien_quay_id" => $rows_no_datcoc["nhanvien_quay_id"], "array_mathang_id" => $rows_no_datcoc["array_mathang_id"], "array_item_code" => $rows_no_datcoc["array_item_code"], "array_hanghoa" => $rows_no_datcoc["array_hanghoa"], "array_is_dichvu" => $rows_no_datcoc["array_is_dichvu"], "array_donvitinh" => $rows_no_datcoc["array_donvitinh"], "array_soluong" => $rows_no_datcoc["array_soluong"], "array_dongia" => $rows_no_datcoc["array_dongia"], "array_giamgia" => $rows_no_datcoc["array_giamgia"], "array_ghichu" => $rows_no_datcoc["array_ghichu"], "array_khogiay_id" => $rows_no_datcoc["array_khogiay_id"], "array_dientich" => $rows_no_datcoc["array_dientich"], "tongtiendonvi" => $rows_no_datcoc["tongtiendonvi"], "tax" => $rows_no_datcoc["tax"], "tienthueGTGT" => $rows_no_datcoc["tienthueGTGT"], "tongsotien" => $rows_no_datcoc["tongsotien"], "tienbangchu" => $rows_no_datcoc["tienbangchu"], "order_week" => $rows_no_datcoc["order_week"], "datecreated" => $rows_no_datcoc["datecreated"], "status" => $rows_no_datcoc["status"],"date_bangiao"=>$date_bangiao);
                         //$dbf->insertTable("bangiao", $array_col);
                         //unset($array_col);
                      }

                      $msg = "Ghi Log doanh thu thành công";
                    }
                  } //end while
              }// end khach hang
       }//end while group
   }//end group khach hang

     $str ="<table id='mainTable' cellspacing='1' cellpadding='1'>";
     $str.="<tr class='titleBottom' ><td class='itemText'>Tên Group</td><td class='itemText'>Tổng Doanh Thu</td><td class='itemText'>Tiền Mặt</td><td class='itemText'>Tiền Đặt Cọc</td><td class='itemText'>Tiền Nợ</td></tr>";
     $i=0;
     $stt=1;
     foreach($array_group as $value)
     {
        if($i%2==0)
        {
          $stt=1;
        }else
        {
          $stt=2;
        }
        $str.="<tr class='cell".$stt."'><td class='itemText'>".$value["title"]."</td><td class='itemText'>".$utl->format($value["tongsotienthongke"])."</td><td class='itemText'>".$utl->format($value["tienmat"])."</td><td class='itemText'>".$utl->format($value["tiendatcoc"])."</td><td class='itemText'>".$utl->format($value["tienno"])."</td></tr>";
        $i++;
     }
     $str.="</table>";

     $array_col = array("content_log" => $str,"datecreated"=>$date_bangiao,"thoigian"=>$giotao);
     $dbf->insertTable("log_doanhthu", $array_col);
     unset($array_col);

}

?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Ghi Log Doanh Thu</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 620px">
            <legend style="color: #000080"><b>Ghi Log Doanh Thu</b></legend>
            <?php if($msg!='') echo "<h4 style='color:red'>".$msg."</h4>";?>
       <br />Ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>

       &nbsp;&nbsp;Đến ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="denngay" name="denngay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#denngay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>

        <br/><br/><input type="submit" name="cmdLogDoanhThu" id="cmdLogDoanhThu" value="Ghi Log Doanh Thu Hôm nay" />
        <input type="button" name="cmdChitietLogDoanhThu" id="cmdChitietLogDoanhThu" value="Xem Lại Log Doanh Thu" />
        </fieldset>


   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/



$('#cmdChitietLogDoanhThu').click(function (){
    var tungay       = $('#tungay').val();
    var denngay      = $('#denngay').val();
    openBox('chitiet_logdoanhthu.php?ngay='+tungay+'&denngay='+denngay+'',792,650);
});
/*]]>*/
</script>