<div id="header-cont">

    <div class="head-cont">
    <h1>WELCOME!</h1><h2>PRODUCT NAME CMS</h2>
    </div>
    
        <div class="log-cont">
        <table width="100%" border="0" cellspacing="0">
          <tr>
            <td class="tp-mnu"><a href="#">HELP</a>
            <a href="index.html">LOGOUT</a>
            </td>
            <td align="center" style="width:25px;"><img src="images/mnu-sep.gif" alt="mnu-sep" /></td>
            <td class="lang"><a href="#">English (US)</a><img src="images/lang-icon.gif" alt="lang icon" /></td>
            <td class="logo"><img src="images/logo.gif" alt="logo" /></td>
          </tr>
        </table>
        
        
        </div>
        <br class="spacer" />
<!--Start Btm Header-->
<div class="btm-header">
<ul>
<li><a href="index1.php?active=1" <? echo ((isset($_REQUEST['active']) && $_REQUEST['active'] == "1") || !isset($_REQUEST['active']))?"class='topmenu_act'":""; ?>>HOME</a></li>
<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
<li><a href="editing.php?active=2" <? echo ((isset($_REQUEST['active']) && $_REQUEST['active'] == "2") )?"class='topmenu_act'":""; ?>>EDITING</a></li>
<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
<li><a href="#?active=3" <? echo ((isset($_REQUEST['active']) && $_REQUEST['active'] == "3"))?"class='topmenu_act'":""; ?>>E-PRODUCTS</a></li>
<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
<li><a href="#?active=4" <? echo ((isset($_REQUEST['active']) && $_REQUEST['active'] == "4"))?"class='topmenu_act'":""; ?>>GALLERY</a></li>
<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
<li><a href="#?active=5" <? echo ((isset($_REQUEST['active']) && $_REQUEST['active'] == "5"))?"class='topmenu_act'":""; ?>>SETTING</a></li>
<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
</ul>

<div class="btm-header2">
<ul>
<li><a href="#">ADD NEW PAGE</a></li>
<li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
<li><a href="#">EDIT PAGE</a></li>
<li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
<li><a href="#">DELETE PAGE</a></li>

</ul>
</div>

</div>
<!--End Btm Header-->

</div>