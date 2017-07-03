<?php
include ("index_table.php");
?>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Thống kê hàng tồn</div></td></tr></tbody></table>

<!--<div class="panelAction" id="panelAction" style="min-height: 3550px;"> !-->

<table cellspacing="1" cellpadding="1" id="mainTable" style="width: 100%">
<tbody>
    <tr class="titleBottom">
        <td class="itemText">STT</td>
        <td class="itemText">Mã Hàng</td>
        <td class="itemText">Tên Hàng</td>
        <td class="itemCenter">ĐVT</td>
        <td class="itemCenter">SL hàng tồn kho chính</td>
        <td class="itemCenter">SL hàng tồn kho phụ</td>
        <td class="itemCenter">SL hàng tồn 2 kho</td>
        <td class="itemText">Giá sản phẩm</td>
        <td class="itemCenter">Thành tiền giá bán kho chính</td>
        <td class="itemCenter">Thành tiền giá bán kho phụ</td>

    </tr>

        <?php
        $rst_category = $dbf->getDynamic("mathang_category", "status=1", "id asc");


        $tongtien = 0;
        $tongtien_giagoc = 0;
        $thanhtien_giagoc = 0;

        $tongtien2 = 0;
        $tongtien_giagoc2 = 0;
        $thanhtien_giagoc2 = 0;
        while ($rows_category = $dbf->nextdata($rst_category)) {
            $id_cat = $rows_category["id"];
            $title_cat = $rows_category["title"];
            ?>
              <tr class="cell2" >
                  <td class="itemText" colspan="10"><span style="color: red;"><b><?php echo $title_cat; ?></b></span></td>
               </tr>
            <?php
            $rst_hangton = $dbf->getDynamic("mathang", "type_id=".$id_cat." and is_dichvu=0 and status=1", "id asc");
            $i = 1;

             $tiencatchinh = 0;
             $tienchatphu = 0;

            while ($rows_hangton = $dbf->nextdata($rst_hangton)) {
              $id = $rows_hangton['id'];
              $item_code = stripcslashes($rows_hangton['item_code']);
              $item_name = stripcslashes($rows_hangton['item_name']);
              $unit = stripcslashes($rows_hangton['unit']);
              $price = stripcslashes($rows_hangton['price']);
              $price_trietkhau = stripcslashes($rows_hangton['price_trietkhau']);
              $quantity = stripcslashes($rows_hangton['quantity']);
              $quantity2 = stripcslashes($rows_hangton['quantity2']);

              $thanhtien_giagoc = $quantity * $price;
              $thanhtien = $quantity * ($price + $price_trietkhau);
              $tongtien += $quantity * ($price + $price_trietkhau);
              $tongtien_giagoc += $quantity * $price;


              $thanhtien_giagoc2 = $quantity2 * $price;
              $thanhtien2 = $quantity2 * ($price + $price_trietkhau);
              $tongtien2 += $quantity2 * ($price + $price_trietkhau);
              $tongtien_giagoc2 += $quantity2 * $price;

              $tiencatchinh+= $quantity * $price;
              $tienchatphu += $quantity2 * $price;
              ?>

              <tr class="cell2" id="colum_<?php echo $id; ?>">
                <td class="itemText"><?php echo $i; ?></td>
                <td class="itemText"><a target="_parent" href="mngMain.php?edit=<?php echo $id; ?>&table_name=mathang&table_return=hangton"><?php echo $item_code; ?></a></td>
                <td class="itemText"><a target="_parent" href="mngMain.php?edit=<?php echo $id; ?>&table_name=mathang&table_return=hangton"><?php echo $item_name; ?></a></td>
                <td class="itemCenter"><a target="_parent" href="mngMain.php?edit=<?php echo $id; ?>&table_name=mathang&table_return=hangton"><?php echo $unit; ?></a></td>
                <td class="itemCenter"><a target="_parent" href="mngMain.php?edit=<?php echo $id; ?>&table_name=mathang&table_return=hangton"> <?php echo $utl->format($quantity); ?></a></td>
                <td class="itemCenter"><a target="_parent" href="mngMain.php?edit=<?php echo $id; ?>&table_name=mathang&table_return=hangton"> <?php echo $utl->format($quantity2); ?></a></td>
                <td class="itemText"><?php echo $utl->format($quantity+$quantity2) ?></td>
                <td class="itemText"><?php echo $utl->format($price) ?></td>
                <td class="itemText"><?php echo $utl->format($thanhtien_giagoc) ?></td>
                <td class="itemText"><?php echo $utl->format($thanhtien_giagoc2) ?></td>

            </tr>
              <?php
              $i++;
        }
            ?>
              <tr class="cell2">
                    <td colspan="8" style="text-align: right"> Tổng cộng:</td>
                    <td colspan="1" style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tiencatchinh) ?> </b><sup>đ</sup></td>

                    <td colspan="1" style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tienchatphu) ?> </b><sup>đ</sup></td>

                </tr>
            <?php
    }
    ?>

    <tr class="cell2">
        <td colspan="8" style="text-align: right"> Tổng số tiền:</td>
        <td colspan="1" style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongtien_giagoc) ?> </b><sup>đ</sup></td>

        <td colspan="1" style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongtien_giagoc2) ?> </b><sup>đ</sup></td>

    </tr>
</tbody>
</table>
<div id="clear" style="clear: both"></div>
<!--</div>!-->