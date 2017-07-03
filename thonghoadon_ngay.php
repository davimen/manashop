<?php
include ("index_table.php");
date_default_timezone_set('Asia/Bangkok');
//echo $_SESSION["user_login"]["role_id"];
if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
  $info_hoadon = $dbf->getInfoColum("hoadon", (int) $_GET["edit"]);
  if ($info_hoadon == - 1) {
    $html->redirectURL("/hoadon.php");
  }
  else {
    $ngay = $info_hoadon["ngay"];
    $thang = $info_hoadon["thang"];
    $nam = $info_hoadon["nam"];
    $giotao = $info_hoadon["giotao"];
    $sohoadon = $info_hoadon["sohoadon"];
    $fullname_sell = $info_hoadon["fullname_sell"];
    $khachang_id = $info_hoadon["khachang_id"];
    $fullname_dv = $info_hoadon["fullname_dv"];
    $address = $info_hoadon["address"];
    $mst = $info_hoadon["mst"];
    $thanhtoan_id = $info_hoadon["thanhtoan_id"];
    $datcoc = $info_hoadon["datcoc"];
    $nhanvien_id = $info_hoadon["nhanvien_id"];
    $nhanvien_quay_id = $info_hoadon["nhanvien_quay_id"];
    $array_mathang_id = explode("|o0o|", $info_hoadon["array_mathang_id"]);
    $array_item_code = explode("|o0o|", $info_hoadon["array_item_code"]);
    $array_is_dichvu = explode("|o0o|", $info_hoadon["array_is_dichvu"]);
    $array_hanghoa = explode("|o0o|", $info_hoadon["array_hanghoa"]);
    $array_donvitinh = explode("|o0o|", $info_hoadon["array_donvitinh"]);
    $array_soluong = explode("|o0o|", $info_hoadon["array_soluong"]);
    $array_dongia = explode("|o0o|", $info_hoadon["array_dongia"]);
    $array_giamgia = explode("|o0o|", $info_hoadon["array_giamgia"]);
    $array_ghichu = explode("|o0o|", $info_hoadon["array_ghichu"]);
    $array_khogiay_id = explode("|o0o|", $info_hoadon["array_khogiay_id"]);
    $array_dientich = explode("|o0o|", $info_hoadon["array_dientich"]);
    $tax = $info_hoadon["tax"];
    $tienthueGTGT_thuc = $info_hoadon["tienthueGTGT"];
    $tongthanhtien_thuc = $info_hoadon["tongsotien"];
    $tienbangchu = $info_hoadon["tienbangchu"];
    $status = $info_hoadon["status"];
    $number_field_dichvu = count($array_soluong);
    $number_field_dichvu = $number_field_dichvu - 1;
    $order_week = $info_hoadon["order_week"];
    if ((int) $order_week == 0) {
      $order_week = date('W');
    }
  }
}else {
  $sohoadon = '';
  $yy = date('y');
  $m = date('M');
  $ww = date('W');
  $d = date('N');
  $xx = ($dbf->totalRows($dbf->getDynamic("hoadon", "order_week = '" . $ww . "'", ""))) + 1;
  if ($xx < 10) {
    $xx = "0" . $xx;
  }
  $sohoadon = $yy . $m[0] . $ww . $d . $xx;
  $code_order = '';
  $ngay = date('d');
  $thang = date('m')-1;
  $nam = date('y');
  $giotao = date('H') . ":" . date('i') . ":" . date('s');
//$sohoadon          = $code_order;
  $fullname_sell = "";
  $khachang_id = "";
  $fullname_dv = "";
  $address = "";
  $mst = "";
  $thanhtoan_id = "";
  $datcoc = 0;
  $array_mathang_id = "";
  $array_item_code = "";
  $array_is_dichvu = "";
  $array_hanghoa = "";
  $array_donvitinh = "";
  $array_soluong = "";
  $array_dongia = "";
  $array_giamgia = "";
  $array_ghichu = "";
  $array_khogiay_id = "";
  $array_dientich = "";
  $tax = 0;
  $congtienhang_thuc = 0;
  $tienthueGTGT_thuc = 0;
  $tongthanhtien_thuc = 0;
  $tienbangchu = "";
  $status = 1;
  $number_field_dichvu = 1;
  $order_week = date('W');
}if (isset ($_POST["subinsert"])) {
  $_SESSION['flashMessenger'] = '';
  $ngay = $_POST["ngay"];
  $thang = $_POST["thang"];
  $nam = $_POST["nam"];
  $giotao = $_POST["giotao"];
  $sohoadon = $_POST["sohoadon"];
  $fullname_sell = $_POST["fullname_sell"];
  $khachang_id = $_POST["khachang_id"];
  $data_khachang = explode("|o0o|", $khachang_id);
  $fullname_dv = $_POST["fullname_dv"];
  $address = $_POST["address"];
  $mst = $_POST["mst"];
  $nhanvien_id = $_POST["nhanvien_id"];
  $nhanvien_quay_id = $_POST["nhanvien_quay_id"];
  $thanhtoan_id = $_POST["thanhtoan_id"];
  $datcoc = $_POST["datcoc"];
  $array_mathang_id = $_POST["array_mathang_id"];
  $array_item_code = $_POST["array_item_code"];
  $array_is_dichvu = $_POST["array_is_dichvu"];
  $array_hanghoa = $_POST["array_hanghoa"];
  $array_donvitinh = $_POST["array_donvitinh"];
  $array_soluong = $_POST["array_soluong"];
  $array_dongia = $_POST["array_dongia"];
  $array_giamgia = $_POST["array_giamgia"];
  $array_khogiay_id = $_POST["array_khogiay_id"];
  $array_dientich = $_POST["array_dientich"];
  $array_ghichu = $_POST["array_ghichu"];
  $number_field_dichvu = $_POST["number_field_dichvu"];
  $tax = $_POST["tax"];
  $congtienhang_thuc = $_POST["congtienhang_thuc"];
  $tienthueGTGT_thuc = $_POST["tienthueGTGT_thuc"];
  $tongthanhtien_thuc = $_POST["tongthanhtien_thuc"];
  $tienbangchu = $_POST["tienbangchu"];
  $status = $_POST["status"];
  $order_week = date('W');
  $datecreated = strtotime($nam . "-" . $thang . "-" . $ngay);
  $mathang_id = '';
  $item_codes_mathang = '';
  $is_dichvu_mathang = '';
  $hanghoa = '';
  $donvitinh = '';
  $soluong = '';
  $dongia = '';
  $giamgia = '';
  $ghichu = '';
  $khogiay_id = '';
  $dientich = '';
  $valid = true;
  if (empty ($data_khachang[0])) {
    $str_flashMessenger .= 'Vui lòng chọn khách hàng!<!0o0!>';
    $valid = false;
  }
  if (empty ($nhanvien_id)) {
    $str_flashMessenger .= 'Vui lòng chọn nhân viên xuất hình!<!0o0!>';
    $valid = false;
  }
  if (empty ($nhanvien_quay_id)) {
    $str_flashMessenger .= 'Vui lòng chọn nhân viên nhận hình!<!0o0!>';
    $valid = false;
  }
  if (empty ($thanhtoan_id)) {
    $str_flashMessenger .= 'Vui lòng chọn hình thức thanh toán!<!0o0!>';
    $valid = false;
  }
  if (empty ($array_mathang_id[0])) {
    $str_flashMessenger .= 'Mặt hàng chưa được chọn!';
    $valid = false;
  }
  if ($valid) {
    for ($i = 0; $i < $number_field_dichvu; $i++) {
      $mathang_id .= $array_mathang_id[$i] . "|o0o|";
      $item_codes_mathang .= $array_item_code[$i] . "|o0o|";
      $is_dichvu_mathang .= $array_is_dichvu[$i] . "|o0o|";
      $hanghoa .= $array_hanghoa[$i] . "|o0o|";
      $donvitinh .= $array_donvitinh[$i] . "|o0o|";
      $soluong .= $array_soluong[$i] . "|o0o|";
      $dongia .= $array_dongia[$i] . "|o0o|";
      $giamgia .= $array_giamgia[$i] . "|o0o|";
      $ghichu .= $array_ghichu[$i] . "|o0o|";
      $khogiay_id .= $array_khogiay_id[$i] . "|o0o|";
      $dientich .= $array_dientich[$i] . "|o0o|";

      // update soluong mat hang
      if ((int)$array_is_dichvu[$i] == 0) {
        $dbf->updateTable("mathang", array("quantity" => "quantity-" . $array_soluong[$i] . ""), "id = " . $array_mathang_id[$i]);
      }

      if ((int)$array_khogiay_id[$i] != 0 && (int)$array_dientich[$i] != 0) {
        //$dbf->updateTable("mathang", array("quantity" => "quantity-" . $array_soluong[$i] . ""), "id = " . $array_mathang_id[$i]);
        $dientich_h = $array_dientich[$i] * $array_soluong[$i];
        $dbf->updateTable("khogiay", array("quantity" => "quantity-" . $dientich_h . ""), "id = " . $array_khogiay_id[$i]);
        //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id[$i], "dientich" => $array_dientich[$i] * $array_soluong[$i], "datecreated" => $datecreated));
      }
    }
    $array_col = array("ngay" => $ngay, "thang" => $thang, "nam" => $nam, "giotao" => $giotao, "sohoadon" => $sohoadon, "fullname_sell" => $fullname_sell, "khachang_id" => $data_khachang[0], "fullname_dv" => $fullname_dv, "address" => $address, "mst" => $mst, "thanhtoan_id" => $thanhtoan_id, "datcoc" => $datcoc, "nhanvien_id" => $nhanvien_id, "nhanvien_quay_id" => $nhanvien_quay_id, "array_mathang_id" => $mathang_id, "array_item_code" => $item_codes_mathang, "array_hanghoa" => $hanghoa, "array_is_dichvu" => $is_dichvu_mathang, "array_donvitinh" => $donvitinh, "array_soluong" => $soluong, "array_dongia" => $dongia, "array_giamgia" => $giamgia, "array_ghichu" => $array_ghichu, "array_khogiay_id" => $khogiay_id, "array_dientich" => $dientich, "tongtiendonvi" => $congtienhang_thuc, "tax" => $tax, "tienthueGTGT" => $tienthueGTGT_thuc, "tongsotien" => $tongthanhtien_thuc, "tienbangchu" => $tienbangchu, "order_week" => $order_week, "datecreated" => $datecreated, "status" => $status);
    if ($mathang_id != '') {
      $affect = $dbf->insertTable("hoadon", $array_col);
    }
    else {
      $str_flashMessenger .= 'Vui lòng kiểm tra lại mặt hàng vì chưa được chọn!';
      $_SESSION['flashMessenger'] = $str_flashMessenger;
      $html->redirectURL("themhoadon.php?msg=error");
      exit ();
    }
    if ($affect) {
      $last_patient_id = mysql_insert_id();
      ?>

     <script language="JavaScript" type="text/javascript">
     /*<![CDATA[*/
       openBox('inhoadon.php?id=<?php echo $last_patient_id ?>',240,400);
     /*]]>*/
     </script>
                                  <?php
                            //$html->redirectURL("themhoadon.php");
                                  $sohoadon = '';
                                  $yy = date('y');
                                  $m = date('M');
                                  $ww = date('W');
                                  $d = date('N');
                                  $xx = ($dbf->totalRows($dbf->getDynamic("hoadon", "order_week = '" . $ww . "'", ""))) + 1;
                                  if ($xx < 10) {
                                    $xx = "0" . $xx;
                                  }
                                  $sohoadon = $yy . $m[0] . $ww . $d . $xx;
                                  $code_order = '';
                                  $ngay = date('d');
                                  $thang = date('m')-1;
                                  $nam = date('y');
                                  $giotao = date('H') . ":" . date('i') . ":" . date('s');
                                  $fullname_sell = "";
                                  $khachang_id = "";
                                  $data_khachang = "";
                                  $fullname_dv = "";
                                  $address = "";
                                  $mst = "";
                                  $nhanvien_id = "";
                                  $nhanvien_quay_id = "";
                                  $thanhtoan_id = "";
                                  $datcoc = "";
                                  $array_mathang_id = "";
                                  $array_item_code = "";
                                  $array_is_dichvu = "";
                                  $array_hanghoa = "";
                                  $array_donvitinh = "";
                                  $array_soluong = "";
                                  $array_dongia = "";
                                  $array_giamgia = "";
                                  $array_ghichu = "";
                                  $array_khogiay_id = "";
                                  $array_dientich = "";
                                  $number_field_dichvu = "";
                                  $mathang_id = '';
                                  $item_codes_mathang = '';
                                  $is_dichvu_mathang = '';
                                  $hanghoa = '';
                                  $donvitinh = '';
                                  $soluong = '';
                                  $dongia = '';
                                  $giamgia = '';
                                  $ghichu = '';
                                  $khogiay_id = '';
                                  $dientich = '';
                                  $tienbangchu = '';
                                  $order_week = date('W');
                                }
                                else {
                                  $html->redirectURL("themhoadon.php?msg=error");
                                }
                              }
                              else {
                                $_SESSION['flashMessenger'] = $str_flashMessenger;
                                $html->redirectURL("themhoadon.php?msg=error");
                              }
                            }
                            if (isset ($_POST["subupdate"])) {
                              $_SESSION['flashMessenger'] = '';
                              $ngay = $_POST["ngay"];
                              $thang = $_POST["thang"];
                              $nam = $_POST["nam"];
                              $giotao = $_POST["giotao"];
                              $datecreated = strtotime($nam . "-" . $thang . "-" . $ngay);
                              $sohoadon = $_POST["sohoadon"];
                              $fullname_sell = $_POST["fullname_sell"];
                              $khachang_id = $_POST["khachang_id"];
                              $data_khachang = explode("|o0o|", $khachang_id);
                              $fullname_dv = $_POST["fullname_dv"];
                              $address = $_POST["address"];
                              $mst = $_POST["mst"];
                              $thanhtoan_id = $_POST["thanhtoan_id"];
                              $datcoc = $_POST["datcoc"];
                              $nhanvien_id = $_POST["nhanvien_id"];
                              $nhanvien_quay_id = $_POST["nhanvien_quay_id"];
                              $array_mathang_id = $_POST["array_mathang_id"];
                              $array_mathang_id_goc = $_POST["array_mathang_id_goc"];
                              $array_item_code = $_POST["array_item_code"];
                              $array_is_dichvu = $_POST["array_is_dichvu"];
                              $array_hanghoa = $_POST["array_hanghoa"];
                              $array_donvitinh = $_POST["array_donvitinh"];
                              $array_soluong = $_POST["array_soluong"];
                              $array_soluong_goc = $_POST["array_soluong_goc"];
                              $array_dongia = $_POST["array_dongia"];
                              $array_giamgia = $_POST["array_giamgia"];
                              $array_ghichu = $_POST["array_ghichu"];
                              $number_field_dichvu = $_POST["number_field_dichvu"];
                              $array_khogiay_id = $_POST["array_khogiay_id"];
                              $array_dientich = $_POST["array_dientich"];
                              $array_khogiay_id_goc = $_POST["array_khogiay_id_goc"];
                              $array_dientich_goc = $_POST["array_dientich_goc"];
                            //print_r($array_dientich_goc);
                            //print_r($array_soluong_goc);
                            //exit;
                              $valid = true;
                              if (empty ($data_khachang[0])) {
                                $str_flashMessenger .= 'Vui lòng chọn khách hàng!<!0o0!>';
                                $valid = false;
                              }
                              if (empty ($nhanvien_id)) {
                                $str_flashMessenger .= 'Vui lòng chọn nhân viên xuất hình!<!0o0!>';
                                $valid = false;
                              }
                              if (empty ($nhanvien_quay_id)) {
                                $str_flashMessenger .= 'Vui lòng chọn nhân viên nhận hình!<!0o0!>';
                                $valid = false;
                              }
                              if (empty ($thanhtoan_id)) {
                                $str_flashMessenger .= 'Vui lòng chọn hình thức thanh toán!<!0o0!>';
                                $valid = false;
                              }
                            //echo $array_mathang_id;
                            //print_r($array_mathang_id);
                            //exit();
                              if (empty ($array_mathang_id[0])) {
                                $str_flashMessenger .= 'Mặt hàng chưa được chọn!';
                                $valid = false;
                              }
                              if ($valid) {
                                $mathang_id = '';
                                $item_codes_mathang = '';
                                $is_dichvu_mathang = '';
                                $hanghoa = '';
                                $donvitinh = '';
                                $soluong = '';
                                $dongia = '';
                                $giamgia = '';
                                $ghichu = '';
                                $khogiay_id = '';
                                $dientich = '';
                            //die($number_field_dichvu);
                                for ($i = 0; $i < $number_field_dichvu; $i++) {
                                  $mathang_id .= $array_mathang_id[$i] . "|o0o|";
                                  $item_codes_mathang .= $array_item_code[$i] . "|o0o|";
                                  $is_dichvu_mathang .= $array_is_dichvu[$i] . "|o0o|";
                                  $hanghoa .= $array_hanghoa[$i] . "|o0o|";
                                  $donvitinh .= $array_donvitinh[$i] . "|o0o|";
                                  $soluong .= $array_soluong[$i] . "|o0o|";
                                  $dongia .= $array_dongia[$i] . "|o0o|";
                                  $giamgia .= $array_giamgia[$i] . "|o0o|";
                                  $ghichu .= $array_ghichu[$i] . "|o0o|";
                                  $khogiay_id .= $array_khogiay_id[$i] . "|o0o|";
                                  $dientich .= $array_dientich[$i] . "|o0o|";
                                }
                            // update dat mat hang
                                $array_mathang_id_tk = array_unique($array_mathang_id_thuc);
                                $array_mathang_id_goc_tk = array_unique($array_mathang_id_goc);
                                if (count($array_mathang_id_tk) > count($array_mathang_id_goc_tk)) {
                                  $loop = count($array_mathang_id_tk);
                                }
                                else {
                                  $loop = count($array_mathang_id_goc_tk);
                                }
                                for ($i = 0; $i < $loop; $i++) {

                                  if (($array_mathang_id[$i] == $array_mathang_id_goc[$i]) && $array_mathang_id[$i] != '') {
                                    if ($array_is_dichvu[$i] == 0) {
                                      if ($array_soluong_goc[$i] > $array_soluong[$i]) {
                                        $quanty_current_edit = $array_soluong_goc[$i] - $array_soluong[$i];
                                        $dbf->updateTable("mathang", array("quantity" => "quantity+" . $quanty_current_edit . ""), "id = " . $array_mathang_id[$i]);
                                      }
                                      else
                                        if ($array_soluong_goc[$i] < $array_soluong[$i]) {
                                          $quanty_current_edit = $array_soluong[$i] - $array_soluong_goc[$i];
                                          $dbf->updateTable("mathang", array("quantity" => "quantity-" . $quanty_current_edit . ""), "id = " . $array_mathang_id[$i]);
                                        }
                                        else {
                                      }
                                    }
                            // xy ly kho giay
                                    if ((int) $array_khogiay_id[$i] != 0) {
                                      if ($array_soluong_goc[$i] > $array_soluong[$i]) {
                                        $dientich = ($array_soluong_goc[$i] * $array_dientich[$i]) - ($array_soluong[$i] * $array_dientich[$i]);
                            //$dientich_h = $array_dientich[$i] * $array_soluong[$i];
                                        $dbf->updateTable("khogiay", array("quantity" => "quantity+" . $dientich . ""), "id = " . $array_khogiay_id[$i]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id[$i], "dientich" => $dientich, "datecreated" => $datecreated));
                                      }
                                      else
                                        if ($array_soluong_goc[$i] < $array_soluong[$i]) {
                                          $dientich = ($array_soluong[$i] * $array_dientich[$i]) - ($array_soluong_goc[$i] * $array_dientich[$i]);
                                          $dbf->updateTable("khogiay", array("quantity" => "quantity-" . $dientich . ""), "id = " . $array_khogiay_id[$i]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id[$i], "dientich" => $dientich, "datecreated" => $datecreated));
                                        }
                                        else {
                                      }
                                    }
                                  }
                                  else {
                                    if ($array_mathang_id[$i] != '') {
                                      $result = in_array($array_mathang_id[$i], $array_mathang_id_goc);
                                      if ($result) {
                            //lay quantyti hien tai
                                        for ($ll = 0; $ll < count($array_mathang_id_goc); $ll++) {
                                          if ($result == $array_mathang_id_goc[$ll]) {
                            //echo $result.'<br/>.';
                            //print_r($array_mathang_id_goc)."pre";
                                            if ($array_soluong_goc[$ll] > $array_soluong[$i]) {
                            //echo "1:".$array_soluong_goc[$ll];
                                              $quanty_current_edit = $array_soluong_goc[$ll] - $array_soluong[$i];
                                              $dbf->updateTable("mathang", array("quantity" => "quantity+" . $quanty_current_edit . ""), "id = " . $array_mathang_id[$ll]);
                            //cap nhat giay
                                              if ((int) $array_khogiay_id_goc[$ll] != 0) {
                                                $dientich = ($array_soluong_goc[$ll] * $array_dientich_goc[$ll]) - ($array_soluong[$i] * $array_dientich[$i]);
                                                $dbf->updateTable("khogiay", array("quantity" => "quantity+" . $dientich . ""), "id = " . $array_khogiay_id_goc[$ll]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id_goc[$ll], "dientich" => $dientich, "datecreated" => $datecreated));
                                              }
                                            }
                                            else
                                              if ($array_soluong_goc[$ll] < $array_soluong[$i]) {
                            //echo "2:".$array_soluong[$i]."goc:".$array_soluong_goc[$ll];
                                                $quanty_current_edit = $array_soluong[$i] - $array_soluong_goc[$ll];
                                                $dbf->updateTable("mathang", array("quantity" => "quantity-" . $quanty_current_edit . ""), "id = " . $array_mathang_id[$ll]);

                                                if ((int) $array_khogiay_id_goc[$ll] != 0) {
                                                  $dientich = ($array_soluong[$i] * $array_dientich[$i]) - ($array_soluong_goc[$ll] * $array_dientich_goc[$ll]);
                                                  $dbf->updateTable("khogiay", array("quantity" => "quantity-" . $dientich . ""), "id = " . $array_khogiay_id_goc[$ll]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id_goc[$ll], "dientich" => $dientich, "datecreated" => $datecreated));
                                                }

                                              }
                                              else {
                            // khong thuc hien
                                            }
                            //echo $array_soluong_goc[$ll]."hientai".$array_soluong[$i]."<br/>";
                            //echo $array_mathang_id_goc[$ll];
                            //exit;
                                          }
                                        }
                                      }
                                      else {
                                        if ($array_mathang_id[$i] != '' && $array_is_dichvu[$i] == 0) {
                                          $dbf->updateTable("mathang", array("quantity" => "quantity-" . $array_soluong[$i] . ""), "id = " . $array_mathang_id[$i]);
                                          if ((int) $array_khogiay_id[$i] != 0) {
                                            $dientich = $array_soluong[$i] * $array_dientich[$i];
                                            $dbf->updateTable("khogiay", array("quantity" => "quantity-" . $dientich . ""), "id = " . $array_khogiay_id[$i]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id[$i], "dientich" => $dientich, "datecreated" => $datecreated));
                                          }
                                        }
                                        if ($array_mathang_id_goc[$i] != '') {
                                          $dbf->updateTable("mathang", array("quantity" => "quantity+" . $array_soluong_goc[$i] . ""), "id = " . $array_mathang_id_goc[$i]);
                                          if ((int) $array_khogiay_id_goc[$i] != 0) {
                                            $dientich = ($array_soluong_goc[$i] * $array_dientich_goc[$i]);
                            //$dbf->insertTable("log_khogiay", array('khogiay_id' => $array_khogiay_id_goc[$i], "dientich" => $dientich, "datecreated" => $datecreated));
                                            $dbf->updateTable("khogiay", array("quantity" => "quantity+" . $dientich . ""), "id = " . $array_khogiay_id_goc[$i]);
                                          }
                                        }
                                      }
                                    }
                                  }
                                }
                            //die();
                                $tax = $_POST["tax"];
                                $congtienhang_thuc = $_POST["congtienhang_thuc"];
                                $tienthueGTGT_thuc = $_POST["tienthueGTGT_thuc"];
                                $tongthanhtien_thuc = $_POST["tongthanhtien_thuc"];
                                $tienbangchu = $_POST["tienbangchu"];
                                $status = $_POST["status"];
                                $datecreated = strtotime($nam . "-" . $thang . "-" . $ngay);
                                $array_col = array("ngay" => $ngay, "thang" => $thang, "nam" => $nam, "giotao" => $giotao, "sohoadon" => $sohoadon, "fullname_sell" => $fullname_sell, "khachang_id" => $data_khachang[0], "fullname_dv" => $fullname_dv, "address" => $address, "mst" => $mst, "thanhtoan_id" => $thanhtoan_id, "datcoc" => $datcoc, "nhanvien_id" => $nhanvien_id, "nhanvien_quay_id" => $nhanvien_quay_id, "array_mathang_id" => $mathang_id, "array_item_code" => $item_codes_mathang, "array_hanghoa" => $hanghoa, "array_is_dichvu" => $is_dichvu_mathang, "array_donvitinh" => $donvitinh, "array_soluong" => $soluong, "array_dongia" => $dongia, "array_giamgia" => $giamgia, "array_ghichu" => $array_ghichu, "array_khogiay_id" => $khogiay_id, "array_dientich" => $dientich, "tongtiendonvi" => $congtienhang_thuc, "tax" => $tax, "tienthueGTGT" => $tienthueGTGT_thuc, "tongsotien" => $tongthanhtien_thuc, "tienbangchu" => $tienbangchu, "order_week" => $order_week, "datecreated" => $datecreated, "status" => $status);
                                $affect = $dbf->updateTable("hoadon", $array_col, " id='" . (int) $_GET["edit"] . "'");
                                if ($affect) {
                            //$html->redirectURL("hoadon.php");
                                  $last_patient_id = (int) $_GET["edit"]
                                  ?>
     <script language="JavaScript" type="text/javascript">
   /*<![CDATA[*/
      openBox('inhoadon.php?id=<?php echo $last_patient_id ?>',240,400);
     /*]]>*/
     </script>
                       <?php
                            }
                            else {
                              $html->redirectURL("themhoadon.php?msg=error");
                            }
                          }
                          else {
                            $_SESSION['flashMessenger'] = $str_flashMessenger;
                            $edit = $_GET['edit'];
                            $html->redirectURL("themhoadon.php?edit=" . $edit . "&msg=error");
                          }
                        }
                        ?>

<style type="text/css">
/*<![CDATA[*/
.mathang {
  font-size: 11px;
  border: 0px solid red;
}

.mathang option {
  border-top: 1px solid #ccc;
  padding: 2px 0px 2px;
}
/*]]>*/
</style>

<script language="JavaScript" src="js/docso.js" type="text/javascript"></script>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Hóa Đơn Giá Trị Gia Tăng</div></td></tr></tbody></table>
<div>
<script language="javascript">
function huy()
{
    window.location='hoadon.php';
}
</script>
<form id="frm" class="" onsubmit="" enctype="application/x-www-form-urlencoded" action="" method="post" name="frm"><div class="panelForm" id="panelForm">
<table cellspacing="1" cellpadding="1" class="mainForm" id="mainForm">
<tbody>
   <tr>
      <td colspan="2" class="boxGrey2">
        <?php
        if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
        ?>
         <input type="submit" value="Cập nhật" id="subupdate" name="subupdate">
         <input onclick="openBox('inhoadon.php?id=<?php echo (int) $_GET["edit"] ?>',240,380);" type="button" value="In phiếu" id="inphieu" name="cmdinphieu">
                   <?php
                  }
                  else {
                    ?>
                    <input type="submit" value="Thêm mới" id="subinsert" name="subinsert">
                <?php }?>
        <input type="reset" value="Nhập lại" name="reset">
        <input type="button" value="Trở lại" onclick="javascript:huy();" id="btnhuy" name="btnhuy">
        </td>
    </tr>
  <tr>
     <td class="txtdo" colspan="4">
     <?php
     if (isset ($_GET["msg"]) && $_GET["msg"] == 'error') {
       if (!empty ($_SESSION['flashMessenger'])) {
         echo "<h3>Đã bị lỗi. Vui lòng thực hiện lại</h3>";
         $array_error = explode("<!0o0!>", $_SESSION['flashMessenger']);
         for ($i = 0; $i < count($array_error); $i++) {
           echo "<h4>" . $array_error[$i] . "</h4>";
         }
       }
     }
     ?>
     </td>
  </tr>
<tr>
<td class="boxGrey">Ngày</td>
<td class="boxGrey2">
<input type="text" value="<?php echo $ngay;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="ngay" name="ngay" style="width:40px;"> /
<input type="text" value="<?php echo $thang;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="thang" name="thang" style="width:40px;">/
<input type="text" value="<?php echo $nam;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="nam" name="nam" style="width:40px;">
<span>Giờ bán:</span>
<input type="text" value="<?php echo $giotao;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="giotao" name="giotao" style="width:80px;">
</td>
</tr>
<tr>
<td class="boxGrey">Số Hóa Đơn</td>
<td class="boxGrey2">
<input type="text" value="<?php echo $sohoadon;?>"  class="nd2" onblur="lo(this);" onfocus="fo(this);" id="sohoadon" name="sohoadon" style="width:150px;">
</td>
</tr>
<tr>
<td class="boxGrey">Khách hàng</td>
<td class="boxGrey2">
<input type="text" value="<?php echo $fullname_dv;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="fullname_dv" name="fullname_dv">
 Hoặc chọn khách hàng
<select name="khachang_id" id="khachang_id" style="width:180px;" onchange="chonkhachhang(this.value)">
<option value="">-- Chọn khách hàng -- </option>
<?php
      $rst_khachhang = $dbf->getDynamic("khachang", "status=1", "title asc");
      $toal_khachhang = $dbf->totalRows($rst_khachhang);
      if ($toal_khachhang > 0) {
        while ($rows_khachhang = $dbf->nextdata($rst_khachhang)) {
          $id_khachhang = $rows_khachhang['id'];
          $title_khachhang = stripcslashes($rows_khachhang['title']);
          $tinhthanh_id_khachhang = stripcslashes($rows_khachhang['tinhthanh_id']);
          $address_khachhang = stripcslashes($rows_khachhang['address']);
          $mst_khachhang = stripcslashes($rows_khachhang['mst']);
          $email_khachhang = stripcslashes($rows_khachhang['email']);
          //check khachhang co no kong
         /*
          $rst_khachhang_no = $dbf->getDynamic("hoadon", "khachang_id=" . $id_khachhang . " and thanhtoan_id=6", "");
          $total_no = $dbf->totalRows($rst_khachhang_no);
          if ($total_no > 0) {
            $tienno_k = 0;
            while ($rows_khachhang_no = $dbf->nextdata($rst_khachhang_no)) {
              $tienno_k += $rows_khachhang_no["tongsotien"];
            }
          }
          $rst_khachhang_datcoc = $dbf->getDynamic("hoadon", "khachang_id=" . $id_khachhang . " and thanhtoan_id=8", "");
          $total_datcoc = $dbf->totalRows($rst_khachhang_datcoc);
          if ($total_datcoc > 0) {
            $tiendatcoc_k = 0;
            while ($rows_khachhang_datcoc = $dbf->nextdata($rst_khachhang_datcoc)) {
              $tiendatcoc_k += $rows_khachhang_datcoc["datcoc"];
            }
          }
          ' . (($total_no > 0) ? " => Đang nợ: " . $total_no . " hóa đơn (" . $utl->format($tienno_k) . ")" : "") . '' . (($total_datcoc > 0) ? " => Đặt cọc: " . $total_datcoc . " hóa đơn :(" . $utl->format($tiendatcoc_k) . ")" : "") . '
          */
          echo '<option ' . (($id_khachhang == $khachang_id) ? "selected" : "") . ' value="' . $id_khachhang . '|o0o|' . $title_khachhang . '|o0o|' . $mst_khachhang . '|o0o|' . $address_khachhang . '">' . $title_khachhang . '</option>';
        }
      }
      ?>
</select>
</td>
</tr>
<tr>
<td class="boxGrey">Địa chỉ</td>
<td class="boxGrey2">
    <input type="text" value="<?php echo $address;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="address" name="address" style="width:600px; height: 50px;">
</td>
</tr>
<tr>
<td class="boxGrey">Mã số thuế</td>
<td class="boxGrey2">
    <input type="text" value="<?php echo $mst;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="mst" name="mst">
</td>
</tr>
<?php
if ($_SESSION["user_login"]["role_id"] == 12 && isset ($_GET["edit"])) {
  ?>

<tr>

<td class="boxGrey">Hình thức thanh toán</td>
<td class="boxGrey2">

      <input type="hidden" name="thanhtoan_id" value="<?php echo $thanhtoan_id;?>">

               <?php
               $thanhtoan = $dbf->getInfoColum("thanhtoan", $thanhtoan_id);
               echo "<b>" . $thanhtoan['title'] . "<b/>";
               ?>

</td>

</tr>

        <?php
      }
      else {
        ?>
<tr>

<td class="boxGrey">Hình thức thanh toán</td>
<td class="boxGrey2">
    <select name="thanhtoan_id" id="thanhtoan_id" onchange="chonthanhtoan(this.value)" style="width:220px;">
  	<option value="">-- Chọn hình thức thanh toán -- </option>
              <?php
              $rst_thanhtoan = $dbf->getDynamic("thanhtoan", "status=1", "title asc");
              $toal_thanhtoan = $dbf->totalRows($rst_thanhtoan);
              if ($toal_thanhtoan > 0) {
                while ($rows_thanhtoan = $dbf->nextdata($rst_thanhtoan)) {
                  $id = $rows_thanhtoan['id'];
                  $title = stripcslashes($rows_thanhtoan['title']);
                  echo '<option ' . (($id == $thanhtoan_id) ? "selected" : "") . ' value="' . $id . '">' . $title . '</option>';
                }
              }
              ?>
  </select>
 <div class="div_datcoc" style="display: <?=(($thanhtoan_id == 8) ? "block" : "none") ?>"> <input onkeypress="return nhapso(event,'datcoc')" type="text" name="datcoc" id="datcoc" value="<?php echo $datcoc;?>" /> VNĐ </div>
</td>

</tr>
        <?php
      }
      ?>
<?php
if ($_SESSION["user_login"]["role_id"] == 12 && isset ($_GET["edit"])) {
  ?>
<tr>
<td class="boxGrey">Nhân viên xuất hàng</td>
<td class="boxGrey2">
    <input type="hidden" name="nhanvien_id" value="<?php echo $nhanvien_id;?>">
                <?php
                $nhanvienxh = $dbf->getInfoColum("nhanvien", $nhanvien_id);
                echo "<b>" . $nhanvienxh['title'] . "<b/>";
                ?>
</td>
</tr>
<tr>
<td class="boxGrey">Nhân viên nhận hình</td>
<td class="boxGrey2">
    <input type="hidden" name="nhanvien_quay_id" value="<?php echo $nhanvien_quay_id;?>">
                <?php
                $nhanviennh = $dbf->getInfoColum("nhanvien", $nhanvien_quay_id);
                echo "<b>" . $nhanviennh['title'] . "</b>";
                ?>
</td>
</tr>
          <?php
        }
        else {
          ?>
<tr>
<td class="boxGrey">Nhân viên xuất hàng</td>
<td class="boxGrey2">
    <select name="nhanvien_id" id="nhanvien_id" style="width:220px;">
  	<option value="">-- Chọn nhân viên -- </option>
                <?php
                $rst_nhanvien = $dbf->getDynamic("nhanvien", "status=1 and is_nvxh=1", "title asc");
                $toal_nhanvien = $dbf->totalRows($rst_nhanvien);
                if ($toal_nhanvien > 0) {
                  while ($rows_nhanvien = $dbf->nextdata($rst_nhanvien)) {
                    $id = $rows_nhanvien['id'];
                    $title = stripcslashes($rows_nhanvien['title']);
                    echo '<option ' . (($id == $nhanvien_id) ? "selected" : "") . ' value="' . $id . '">' . $title . '</option>';
                  }
                }
                ?>
  </select>
</td>
</tr>
<tr>
<td class="boxGrey">Nhân viên nhận hình</td>
<td class="boxGrey2">
    <select name="nhanvien_quay_id" id="nhanvien_quay_id" style="width:220px;">
  	<option value="">-- Chọn nhân viên -- </option>
                <?php
                $rst_nhanvien = $dbf->getDynamic("nhanvien", "status=1 and is_nvquay=1", "title asc");
                $toal_nhanvien = $dbf->totalRows($rst_nhanvien);
                if ($toal_nhanvien > 0) {
                  while ($rows_nhanvien = $dbf->nextdata($rst_nhanvien)) {
                    $id = $rows_nhanvien['id'];
                    $title = stripcslashes($rows_nhanvien['title']);
                    echo '<option ' . (($id == $nhanvien_quay_id) ? "selected" : "") . ' value="' . $id . '">' . $title . '</option>';
                  }
                }
                ?>
  </select>
</td>
</tr>
          <?php
        }
        ?>
<tr>
<td style="padding: 10px" class="boxGrey" colspan="2">
    <table style="background: #ccc">
        <tr style="color: #F9545E">
        <td width="15" style="padding: 1px; height: 40px; text-align: center"><b>STT</b></td>
        <td width="200" style="padding: 1px; height: 40px; text-align: center"><b>Mã Hàng</b></td>
        <td width="80" style="padding: 1px;height: 40px; text-align: center"><b>Tên mặt hàng</b></td>
        <td width="30" style="padding: 1px;height: 40px; text-align: center"><b>ĐVT</b></td>
        <td width="30" style="padding: 1px;height: 40px; text-align: center"><b>Số lượng</b></td>
        <td width="100" style="padding: 1px;height: 40px; text-align: center"><b>Đơn giá (VNĐ)</b></td>
        <td width="50" style="padding: 1px;height: 40px; text-align: center"><b>Giảm giá (VNĐ)</b></td>
        <td width="50" style="padding: 1px;height: 40px; text-align: center"><b>Thành tiền</b></td>
        <td width="80" style="padding: 1px;height: 40px; text-align: center"><b>Ghi chú</b></td>
        <td width="120" style="padding: 1px;text-align: center">
            <span style="float: left; margin-left: 10px;">
            <input type="button" name="buton_add" id="buton_add" value="Thêm" />
            </span>
            <span id="xoa_colum" style="<?php echo ((isset ($_GET["edit"]) && $_GET["edit"] != '') ? 'display: block' : 'display: none');?>; float:left">
                <input type="button" name="buton_delete" id="buton_delete" value="Xóa" />
            </span>
            <div class="clear"></div>
        </td>
        </tr>
        <?php

        $rs_khogiay = $dbf->getDynamic("khogiay","status=1 ","id desc");
        while($row_khogiay=$dbf->nextData($rs_khogiay)){
           $khogiaythuc[$row_khogiay['id']] = $row_khogiay['quantity'];
        }


        $stt = 1;
        //load otion hang hoa
        $str_mathang = "";
        $rst_mathang = $dbf->getDynamic("mathang", "status=1", "item_code asc");
        $toal_mathang = $dbf->totalRows($rst_mathang);
        if ($toal_mathang > 0) {
          while ($rows_mathang = $dbf->nextdata($rst_mathang)) {
            $id = $rows_mathang['id'];
            $item_code = stripcslashes($rows_mathang['item_code']);
            $item_name = stripcslashes($rows_mathang['item_name']);
            $unit = stripcslashes($rows_mathang['unit']);
            $quantity = stripcslashes($rows_mathang['quantity']);
            $price_mathang = stripcslashes($rows_mathang['price']);
            $price_mathang_format = $utl->format($price_mathang);
            $is_dichvu = $rows_mathang['is_dichvu'];
            $dientich = $rows_mathang['dientich'];
            $khogiay_id = $rows_mathang['khogiay_id'];
            $quantity_tk = $quantity;

            if ((int) $khogiay_id != 0) {
              //$khogiaythuc = $dbf->getInfoColum("khogiay", $khogiay_id);
              $quantity_tk = $utl->format($khogiaythuc[$khogiay_id]) . " cm2";
            }
            $str_mathang .= '<option value="' . $id . '|o0o|' . $item_code . '|o0o|' . $item_name . '|o0o|' . $unit . '|o0o|' . $price_mathang . '|o0o|' . $is_dichvu . '|o0o|' . $khogiay_id . '|o0o|' . $dientich . ' ">' . $item_code . '&nbsp;|&nbsp;' . $item_name . '&nbsp;|&nbsp;' . $price_mathang_format . '&nbsp;|&nbsp;' . $quantity_tk . '</option>';
          }
        }
        for ($i = 0; $i < 10; $i++) {
          if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
            $congtienhang_thuc += ($array_soluong[$i] * $array_dongia[$i]) - $array_giamgia[$i];
            if ($i < $number_field_dichvu) {
              $style = '';
            }
            else {
              $style = 'display:none';
            }
          }
          else {
            if ($i == 0) {
              $style = '';
            }
            else {
              $style = 'display:none';
            }
          }
          ?>
              <tr id="field_<?php echo $i;?>" style="<?php echo $style;?>" >
              <td style="width:15px;"><?php echo $stt;?></td>
              <td>
              <select class="mathang" id="array_mahang<?php echo $i;?>" name="array_mahang[]" style="width:200px;" onchange="chonmathang(this.value,'<?php echo $i;?>')">
  	                <option value="">-- Chọn mặt hàng -- </option>
                    <?php echo $str_mathang;?>
              </select>
              <input id="array_mathang_id<?php echo $i;?>" name="array_mathang_id[]" type="hidden" value="<?php echo $array_mathang_id[$i];?>" />
              <input id="array_item_code<?php echo $i;?>" name="array_item_code[]" type="hidden" value="<?php echo $array_item_code[$i];?>" />
              <input id="array_is_dichvu<?php echo $i;?>" name="array_is_dichvu[]" type="hidden" value="<?php echo $array_is_dichvu[$i];?>" />
              <input id="array_khogiay_id<?php echo $i;?>" name="array_khogiay_id[]" type="hidden" value="<?php echo $array_khogiay_id[$i];?>" />
              <input id="array_dientich<?php echo $i;?>" name="array_dientich[]" type="hidden" value="<?php echo $array_dientich[$i];?>" />
              <input id="array_mathang_id_goc<?php echo $i;?>" name="array_mathang_id_goc[]" type="hidden" value="<?php echo $array_mathang_id[$i];?>" />
              <input id="array_soluong_goc<?php echo $i;?>" name="array_soluong_goc[]" type="hidden" value="<?php echo $array_soluong[$i];?>" />
              <input id="array_khogiay_id_goc<?php echo $i;?>" name="array_khogiay_id_goc[]" type="hidden" value="<?php echo $array_khogiay_id[$i];?>" />
              <input id="array_dientich_goc<?php echo $i;?>" name="array_dientich_goc[]" type="hidden" value="<?php echo $array_dientich[$i];?>" />              </td>
              <td><input style="width:80px;padding: 1px;" type="text" value="<?php echo $array_hanghoa[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_hanghoa<?php echo $i;?>" name="array_hanghoa[]"></td>
              <td><input style="width:30px;padding: 1px;" type="text" value="<?php echo $array_donvitinh[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_donvitinh<?php echo $i;?>" name="array_donvitinh[]"></td>
              <td><input onkeypress="return nhapso(event,'array_soluong<?php echo $i;?>')" onchange="thanhtien(this.value,'array_dongia<?php echo $i;?>','thanhtien<?php echo $i;?>','thanhtien_<?php echo $i;?>','array_giamgia<?php echo $i;?>')"  style="width:30px;padding: 1px;" type="text" value="<?php echo (int) $array_soluong[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_soluong<?php echo $i;?>" name="array_soluong[]"></td>
              <td><input onkeypress="return nhapso(event,'array_dongia<?php echo $i;?>')" onchange="thanhtien(this.value,'array_soluong<?php echo $i;?>','thanhtien<?php echo $i;?>','thanhtien_<?php echo $i;?>','array_giamgia<?php echo $i;?>')" style="width:50px;padding: 1px;" type="text" value="<?php echo $array_dongia[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_dongia<?php echo $i;?>" name="array_dongia[]"></td>
              <td><input onkeypress="return nhapso(event,'array_giamgia<?php echo $i;?>')" onchange="thanhtien_giamgia(this.value,'array_soluong<?php echo $i;?>','thanhtien<?php echo $i;?>','thanhtien_<?php echo $i;?>','array_dongia<?php echo $i;?>')" style="width:50px;padding: 1px;" type="text" value="<?php echo (int) $array_giamgia[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_giamgia<?php echo $i;?>" name="array_giamgia[]"></td>
              <td style="padding: 1px;text-align: center">
                  <span style="width:150px;"  class='price' id="thanhtien<?php echo $i;?>"><?php echo $utl->format(($array_soluong[$i] * $array_dongia[$i]) - $array_giamgia[$i]);?></span>
                  <input type="hidden" name="thanhtien_<?php echo $i;?>" id="thanhtien_<?php echo $i;?>" value="<?php echo (($array_soluong[$i] * $array_dongia[$i]) - $array_giamgia[$i]);?>" />
              </td>
              <td><input style="width:80px;padding: 1px;" type="text" value="<?php echo $array_ghichu[$i];?>" onblur="lo(this);" onfocus="fo(this);" id="array_ghichu<?php echo $i;?>" name="array_ghichu[]"></td>
              <td style="padding: 1px;text-align: center"></td>
              </tr>
                        <?php
                        $stt++;
                      }
                      ?>
        <input type="hidden" name="number_field_dichvu" id="number_field_dichvu" value="<?php echo $number_field_dichvu;?>" />
    </table>
    <script language="JavaScript" type="text/javascript">
    /*<![CDATA[*/
    $("#buton_add").click(function(){
        var field_colum = $("#number_field_dichvu").val();
        $("#field_"+field_colum).show();
        field_colum = parseInt(field_colum) + 1;
        $("#xoa_colum").show();
        if(field_colum>9)
        {
           field_colum=9;
           alert("Hóa đơn chỉ thêm nhập được tối đa 10 dịch vụ");
        }
        document.getElementById('number_field_dichvu').value= field_colum;
        //alert(field_colum);
    });
    $("#buton_delete").click(function(){
        var field_colum = $("#number_field_dichvu").val();
        //alert(field_colum);
        field_colum = parseInt(field_colum) - 1;
        $("#field_"+field_colum).hide();
        // xoa du  lieu khong can thiet
        $("#thanhtien_"+field_colum).val(0);
        $("#array_hanghoa"+field_colum).val('');
        $("#array_donvitinh"+field_colum).val('');
        $("#array_soluong"+field_colum).val('');
        $("#array_dongia"+field_colum).val('');
        $("#array_giamgia"+field_colum).val('');
        $("#array_is_dichvu"+field_colum).val();
        $("#array_khogiay_id"+field_colum).val();
        $("#array_dientich"+field_colum).val();
        $("#thanhtien"+field_colum).html('');
        tongthanhtien(field_colum);
        if(field_colum<2)
        {
           field_colum=1;
           $("#xoa_colum").hide();
        }
        document.getElementById('number_field_dichvu').value= field_colum;
        //alert(field_colum);
    });    /*]]>*/
    </script>
</td>
</tr>
<tr style="line-height: 170%">
<td class="boxGrey">Thuế suất thuế GTGT <input onchange="tongthanhtien2()" name="tax" readonly id="tax" type="text" value="<?php echo $tax;?>" size="10" onkeypress="return nhapso(event,'tax')" />% </td>
<td class="boxGrey2">
  (1) Cộng Tiền Hàng: <span id="congtienhang" class="price"><?php echo ((isset ($_GET["edit"]) && $_GET["edit"] != '') ? $utl->format($congtienhang_thuc) . " VNĐ" : "");?></span><br/>
   <input type="hidden" id="congtienhang_thuc" name="congtienhang_thuc" value="<?php echo $congtienhang_thuc;?>" />
  (2) Tiền thuế GTGT: <span id="tienthueGTGT" class="price"><?php echo ((isset ($_GET["edit"]) && $_GET["edit"] != '') ? $utl->format($tienthueGTGT_thuc) . " VNĐ" : "");?></span><br/>
   <input type="hidden" id="tienthueGTGT_thuc" name="tienthueGTGT_thuc" value="<?php echo $tienthueGTGT_thuc;?>" />
   Tổng cộng tiền thanh toán (1+2): <span id="tongthanhtien" class="price"><?php echo ((isset ($_GET["edit"]) && $_GET["edit"] != '') ? $utl->format($tongthanhtien_thuc) . " VNĐ" : "");?></span><br/>
   <input type="hidden" id="tongthanhtien_thuc" name="tongthanhtien_thuc" value="<?php echo $tongthanhtien_thuc;?>" />
</td>
</tr><tr>
<td class="boxGrey">Bằng chữ</td>
<td class="boxGrey2">
    <input type="text" style="width:600px; height: 40px;" value="<?php echo $tienbangchu;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="tienbangchu" name="tienbangchu">
</td>
</tr>
<tr><td class="boxGrey">Trạng thái</td><td class="boxGrey2"><input type="hidden" value="<?php echo $status;?>" id="status" name="status"><input type="checkbox" class="" style="" checked="checked" onclick="if(this.checked){document.getElementById('status').value=1;} else{document.getElementById('status').value=0;}" value="1" id="chk_tmp[]" name="chk_tmp[]"> </td></tr>
<tr>
  <td colspan="2" class="boxGrey2">
        <?php
        if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
          ?>
         <input type="submit" value="Cập nhật" id="subupdate" name="subupdate">
         <input onclick="openBox('inhoadon.php?id=<?php echo (int) $_GET["edit"] ?>',240,380);" type="button" value="In phiếu" id="inphieu" name="cmdinphieu">
        <?php }else {?>
        <input type="submit" value="Thêm mới" id="subinsert" name="subinsert">
        <?php }?>
    <input type="reset" value="Nhập lại" name="reset">
    <input type="button" value="Trở lại" onclick="javascript:huy();" id="btnhuy" name="btnhuy">
  </td>
</tr></tbody>
</table>
</div>
<script language="javascript">
    jQuery(function() {
    var v = jQuery("#frm").validate({
                debug: false,
                errorElement: "em",
                success: function(label) {
        				label.text("!ok").addClass("success");
        		},
                rules: {
                 sohoadon:
                 {
                   required: true
                 },
                 fullname_dv:
                 {
                   required: true
                 },
                 khachang_id:
                 {
                   required: true
                 },
                 thanhtoan_id:
                 {
                   required: true
                 },
                 nhanvien_id:
                 {
                   required: true
                 },
                 nhanvien_quay_id:
                 {
                   required: true
                 },
                 tienbangchu:
                 {
                   required: true
                 }
        		},
                messages:
                {
                  sohoadon:
                 {
                   required: "Vui lòng nhập số hóa đơn"
                 },
                 fullname_dv:
                 {
                   required: "Vui lòng nhập tên đơn vị"
                 },
                 khachang_id:
                 {
                   required: "Vui lòng chọn khách hàng"
                 },
                 thanhtoan_id:
                 {
                   required: "Vui lòng chọn hình thức thanh toán"
                 },
                  nhanvien_id:
                 {
                   required: "Vui lòng chọn nhân viên xuất hàng"
                 },
                 nhanvien_quay_id:
                 {
                   required: "Vui lòng chọn nhân viên quầy"
                 },
                 tienbangchu:
                 {
                   required: "Vui lòng nhập số tiền bằng chữ"
                 }
                }
        });
    });
    function chonkhachhang(id){
        if(id!='')
        {
            var data = id.split("|o0o|");
            $("#fullname_dv").val(data[1]);
            $("#mst").val(data[2]);
            $("#address").val(data[3]);
        }else
        {
            $("#fullname_dv").val("");
            $("#mst").val("");
            $("#address").val("");
        }
    }
    function chonthanhtoan(id){
       //alert(id);
       if(id==8) {
         $(".div_datcoc").show();
       }else
       {
          $("#datcoc").val(0);
          $(".div_datcoc").hide();
       }
    }
    function chonmathang(id,index){
        var data = id.split("|o0o|");
        $("#array_mathang_id"+index).val(data[0]);
        $("#array_item_code"+index).val(data[1]);
        $("#array_hanghoa"+index).val(data[2]);
        $("#array_donvitinh"+index).val(data[3]);
        $("#array_dongia"+index).val(data[4]);
        $("#array_is_dichvu"+index).val(data[5]);
        $("#array_khogiay_id"+index).val(data[6]);
        $("#array_dientich"+index).val(data[7]);
        thanhtien_chonhang(index);
    }
    function FormatNumber(obj) {
        var strvalue;
        if (eval(obj))
            strvalue = eval(obj).value;
        else
            strvalue = obj;
        var num;
            num = strvalue.toString().replace(/\$|\./g,'');
            if(isNaN(num))
            num = "";
            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num*100+0.50000000001);
            num = Math.floor(num/100).toString();
            for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
            num = num.substring(0,num.length-(4*i+3))+'.'+
            num.substring(num.length-(4*i+3));
            //return (((sign)?'':'-') + num);
            eval(obj).value = (((sign)?'':'-') + num);
}
    function formatCurrency(num)
    {
        //num = num.toString().replace(/\$|\./g,'');
        if(isNaN(num))
        num = "0";
        sign = (num == (num = Math.abs(num)));
        num = Math.floor(num*100+0.50000000001);
        num = Math.floor(num/100).toString();
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+','+
        num.substring(num.length-(4*i+3));
        return (((sign)?'':'-') + num);
    }
    function thanhtien_chonhang(index)
    {
       if(index!='')
       {
       var soluong = $('#array_soluong'+index).val();
       var dongia = $('#array_dongia'+index).val();
       var giamgia = $('#array_giamgia'+index).val();
       var thanhtien1 = ((parseInt(soluong) * parseInt(dongia)) - parseInt(giamgia));
       $('#thanhtien_'+index).val(thanhtien1);       var dinhdangthanhtien = formatCurrency(thanhtien1);
       $('#thanhtien'+index).html(dinhdangthanhtien);
       var field_colum = $('#number_field_dichvu').val();
       tongthanhtien(field_colum);
       }
    }
    function thanhtien(value,soluong,thanhtien,thanhtien_thuc,giamgia)
    {
       if(value=='')
       {
         value =0;
       }
       var soluong1 = $('#'+soluong).val();
       var giamgia1 = $('#'+giamgia).val();
       var thanhtien1 = ((parseInt(soluong1) * parseInt(value)) - parseInt(giamgia1));
       $('#'+thanhtien_thuc).val(thanhtien1);
       var dinhdangthanhtien = formatCurrency(thanhtien1);
       $('#'+thanhtien).html(dinhdangthanhtien);
       var field_colum = $('#number_field_dichvu').val();
       tongthanhtien(field_colum);
    }
    function thanhtien_giamgia(value,soluong,thanhtien,thanhtien_thuc,dongia)
    {
       if(value=='')
       {
         value =0;
       }
       var soluong1 = $('#'+soluong).val();
       var dongia1 = $('#'+dongia).val();
       var thanhtien1 = ((parseInt(soluong1) * parseInt(dongia1)) - parseInt(value));
       $('#'+thanhtien_thuc).val(thanhtien1);
       var dinhdangthanhtien = formatCurrency(thanhtien1);
       $('#'+thanhtien).html(dinhdangthanhtien);
       var field_colum = $('#number_field_dichvu').val();
       tongthanhtien(field_colum);
    }
    function tongthanhtien(field_colum){
      var tongthanhtien_colum =0;
      for (var i = 0; i <= field_colum; i++)
      {
          tongthanhtien_colum+= parseInt($("#thanhtien_"+i).val());
      }
      //Cộng Tiền Hàng
      $("#congtienhang_thuc").val(tongthanhtien_colum);
      var dinhdangcongtienhang = formatCurrency(tongthanhtien_colum);
      $("#congtienhang").html(dinhdangcongtienhang +" VNĐ");
      //Tiền thuế GTGT
      var tax           =  parseInt($("#tax").val());
      var tienthueGTGT  =  (tax * tongthanhtien_colum)/100;
      $("#tienthueGTGT_thuc").val(tienthueGTGT);
      var dinhdang_tienthueGTGT = formatCurrency(tienthueGTGT);
      $("#tienthueGTGT").html(dinhdang_tienthueGTGT +" VNĐ");
      //Tổng cộng tiền thanh toán
      var tongthanhtien = parseInt(tienthueGTGT) + parseInt(tongthanhtien_colum);
      $("#tongthanhtien_thuc").val(tongthanhtien);
      var dinhdang_tongthanhtien = formatCurrency(tongthanhtien);
      $("#tongthanhtien").html(dinhdang_tongthanhtien +" VNĐ");
      var doctien = DocTienBangChu(tongthanhtien);
      $('#tienbangchu').val(doctien + " đồng");
    }
    function tongthanhtien2()
    {
       var field_colum = $('#number_field_dichvu').val();
       tongthanhtien(field_colum);
    }
</script>
</form>
</div>