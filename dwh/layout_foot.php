	</div>
	<!-- /container -->

<!-- jQuery library -->
<script src="<?php echo $home_url; ?>libs/js/jquery.js"></script>

<!-- our custom JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/custom-script.js"></script>

<!-- bootstrap JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $home_url; ?>libs/js/bootstrap/docs-assets/js/holder.js"></script>

<!-- bootstrap image gallery JavaScript -->
<script src="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo $home_url; ?>libs/js/Bootstrap-Image-Gallery-3.1.1/js/bootstrap-image-gallery.min.js"></script>
		<link rel="stylesheet" href="<?php echo $home_url; ?>libs/js/jQuery.filer-1.3.0/js/jquery.filer.min.js"></script>">

<script>
// jQuery codes 
$(document).ready(function(){

	// add to cart button listener
	$('.add-to-cart-form').on('submit', function(){

		// get basic information for adding to cart
		var id = $(this).closest('tr').find('.product-id').text();
		var name = $(this).closest('tr').find('.product-name').text();
		var quantity = $(this).closest('tr').find('input').val();

		// redirect to add_to_cart.php, with parameter values to process the request
		window.location.href = "<?php echo $home_url; ?>add_to_cart.php?id=" + id + "&name=" + name + "&quantity=" + quantity;
		return false;
	});

	// update quantity button listener
	$('.update-quantity-form').on('submit', function(){

		// get basic information for updating the cart
		var id = $(this).closest('tr').find('.product-id').text();
		var name = $(this).closest('tr').find('.product-name').text();
		var quantity = $(this).closest('tr').find('input').val();

		// redirect to update_quantity.php, with parameter values to process the request
		window.location.href = "<?php echo $home_url; ?>update_quantity.php?id=" + id + "&name=" + name + "&quantity=" + quantity;
		return false;
	});

	// catch the submit form, used to tell the user if password is good enough
	$('#register, #change-password').submit(function(){

		var password_strenght=$('#passwordStrength').text();

		if(password_strenght!='Good Password!'){
			alert('Password not strong enough');
			return false;
		}

		return true;
	});

});
</script>


<script type="text/javascript">
function AjaxFunction()
{
	 //var cat_id=document.getElementById('s1').value;
	 //alert(cat_id);

var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
//alert(httpxml.responseText);
var myarray = JSON.parse(httpxml.responseText);
// Remove the options from 2nd dropdown list 
for(j=document.testform.subcat.options.length-1;j>=0;j--)
{
document.testform.subcat.remove(j);
}


for (i=0;i<myarray.data.length;i++)
{
var optn = document.createElement("OPTION");
optn.text = myarray.data[i].fname;
optn.value = myarray.data[i].id;  // You can change this to subcategory 
document.testform.subcat.options.add(optn);

} 
      }
    } // end of function stateck
	var url="dd.php";
var cat_id=document.getElementById('s1').value;
url=url+"?cat_id="+cat_id;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
//alert(url);
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>

<!-- end HTML page -->
</body>
</html>
