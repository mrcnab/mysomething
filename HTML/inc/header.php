<script type="text/javascript" src="js/dropdowncontent.js"></script>
<div id="header-cont">
	<div class="logo">
    	<a href="#"><img src="images/logo.png" alt="logo" /></a>
    </div>

    <div class="hdr-right">
    	<!--Welcome!  <span>Maria</span> -->
        <div class="log-reg-cont sprite-lgn-reg-bg">
        <a href="#">Login</a>
        <a href="#">Register</a>
        </div>
    </div>
    <br class="spacer" />
    <div class="hdr-sep"></div>
    <br class="spacer" />

    <div class="menu-cont">

    <a href="#" class="home-width">Home</a>
    <a href="#" class="about-width">About Us</a>
    <a href="#" class="retail-width" id="searchlink" rel="subcontent">DIRECTORY</a>
    <div id="subcontent" class="drop-down-div">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/drop-down-top.png" alt="top" /></td>
          </tr>
          <tr>
            <td style="background:#dd39a5;">
            <ul>
            	<li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>
                <li><a href="#">Sed adipiscing lorem non</a></li>

            </ul>
            </td>
          </tr>
          <tr>
            <td><img src="images/drop-down-btm.png" alt="btm" /></td>
          </tr>
		</table>

	</div>


    <a href="#" class="advrt-width">Advertise</a>
    <a href="#" class="advrt-width">Contact Us</a>

    </div>
    <br class="spacer" />

    <div class="srch-cont">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:391px;"><input name="search" class="txarea1" value="Product / Services" type="text" /></td>
            <td class="in-cls">in</td>
            <td style="width:239px;">
            <select name="list" class="txarea2">
            <option>All Categories</option>

            </select>
            </td>
            <td><input name="Search" type="submit" value="Search" class="srch-btn" /></td>
            <td><input name="advert" type="submit" value="Post an Advertisement" class="advert-btn" /></td>
          </tr>
        </table>

    </div>

</div>

<script type="text/javascript">
//Call dropdowncontent.init("anchorID", "positionString", glideduration, "revealBehavior") at the end of the page:

dropdowncontent.init("searchlink", "right-bottom", 500, "mouseover")

</script>