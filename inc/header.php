<? $allParentCategories	=	$category_obj-> showParentCategoriesForSearch(); 
	$get_adverts = $advert_obj -> getAllAdvertForSearchPopUp(20);	
	$newArr = '[';

	foreach($get_adverts as $javadate)
	{	
	$newArr .=  '"'.$javadate['advertTitle'].'",';	
	}    
	$newArr = substr($newArr,0,-1);		
	$newArr .= ']';	
?>
<script type="text/javascript">
	$().ready(function() {
//	function log(event, data, formatted) {
		//$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
//	}
	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	
	var newcate 		= <?=$newArr?>;

	$("#txt_advert").focus().autocomplete(newcate);	
	document.getElementById("search-result").focus();
});

function removeSpaces(string) {
  var data;
  date = string.split(' ').join('-');
  return date.split('&').join('(and)');
}

function trim12 (str) {
	var	str = str.replace(/^\s\s*/, ''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

</script>

<? 
	$getAllParentCategoriesHeader	=	$category_obj	-> showRetailerCategories();	

?>  

<script type="text/javascript" src="js/dropdowncontent.js"></script>
<div id="header-cont">
	<div class="logo">
    	<a href="index.php"><img src="images/logo.png" alt="logo" /></a>
    </div>
    
    <div class="hdr-right">
    	<!--Welcome!  <span>Maria</span> -->
        <? if (!isset($_SESSION['login']['candidateId'])){?>
            <div class="log-reg-cont sprite-lgn-reg-bg">
                <a href="register.php" style="font-weight:bold;">Register</a>
                <a href="login.php" style="font-weight:bold;">Login</a>                
            </div>
    	<? }else{ ?>
             Welcome! <?=$_SESSION['login']['candidateName']?></strong>
            <div class="log-reg-cont sprite-lgn-reg-bg">
              <a href="register.php?customerId=<?=$_SESSION['login']['candidateId']?>">Account</a>
              <a href="logout.php">Logout</a>
              
              </div>
        <? } ?>
    
    
    </div>
    <br class="spacer" />
    <div class="hdr-sep"></div>
    <br class="spacer" />
    
    <div class="menu-cont">
    
    <a href="index.php" class="home-width">Home</a>    
    <a href="#" class="retail-width" id="searchlink" rel="subcontent">DIRECTORY</a>
    <div id="subcontent" class="drop-down-div">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/drop-down-top.png" alt="top" /></td>
          </tr>
          <tr>
            <td style="background:#dd39a5;">
            <ul>
            <?
				foreach( $getAllParentCategoriesHeader as $parentCatHead ) { 
			?>
            	<a href="ad-listing.php?category_id=<?=$parentCatHead['category_id']?>">
                	<li><?=$parentCatHead['category_title']?></li>
                 </a>
            <? } ?>
               
            
            </ul>
            </td>
          </tr>
          <tr>
            <td><img src="images/drop-down-btm.png" alt="btm" /></td>
          </tr>
		</table>

	</div>
    
    
    <a href="advertise.php" class="advrt-width">Advertise</a>
    <a href="contact.php" class="advrt-width">Contact Us</a>
    <a href="faq.php" class="about-width">FAQs</a>
    
    </div>
    <br class="spacer" />
    
    <div class="srch-cont">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <form id="frm_search" name="frm_search" action="search_result.php" method="post" autocomplete="off">
           
            <td style="width:391px;"><input  type="text"  name="txt_advert" id="txt_advert" class="txarea1" 
            <? if($_REQUEST['txt_advert'] =='' ||  $_REQUEST['txt_advert'] == 'Product / Services') {?> value="Product / Services" <? } else {?> value="<?=$_REQUEST['txt_advert']?>" <? }?>  onclick="this.value=''" /></td>
            <td class="in-cls">in</td>
            <td style="width:239px;">
            <select name="txt_categories" id="txt_categories"   class="txarea2">
            <option style="padding-left:5px;"   value="">All Categories</option>
            
            <? foreach($allParentCategories as $parentCat){ ?>
            <option style="padding-left:5px;"   <? if($_REQUEST['txt_categories'] == 'parent_'.$parentCat['category_id']) {?> selected="selected" <? }else { ?> value="parent_<?=$parentCat['category_id']?>" <? } ?> >
            <?=$parentCat['category_title']?>
            
            </option>
                                             
           <? } ?> 
            
            </select>
            </td>
            <td><input name="Search" type="submit" value="Search" style="cursor:pointer;" class="srch-btn" /></td>
            </form>
            
            
            
            <td>
			<? if (!isset($_SESSION['login']['candidateId'])){?>
            <a href="login.php?flag=upload-add"><img src="images/post-advert-btn.gif" alt="Post Add" /></a>
            <? }else{ ?>
            <a href="upload-add.php"><img src="images/post-advert-btn.gif" alt="Post Add" /></a>
            <? } ?>            
            </td>
          </tr>
        </table>

    </div>
    
</div>

<script type="text/javascript">
//Call dropdowncontent.init("anchorID", "positionString", glideduration, "revealBehavior") at the end of the page:

dropdowncontent.init("searchlink", "right-bottom", 500, "mouseover")

</script>