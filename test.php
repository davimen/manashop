<script src="js/jquery-1.3.2.min.js"></script>
<input type="text" id="price" name="price" value="" />

<script>
  function format(x) {
    if(isNaN(x))return "";
    n= x.toString().split('.');
    return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(n.length>1?"."+n[1]:"");
  }

  $("#price").change(function(){
    var price = $("#price").val();
    price = format(price);
    confirm(price+" đ ?");
  })
</script>