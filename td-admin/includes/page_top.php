<? ob_start();	 ?>
<div id="header-cont">
    <div class="head-cont"> <h1>WELCOME!</h1><h2><?=SITE_NAME?> Administrator</h2> </div>
        <div class="log-cont">
        <table width="100%" border="0" cellspacing="0">
        <tr>
            <td class="tp-mnu"><!--<a href="#">HELP</a>-->
                <a href="index.php?action=logout">LOGOUT</a>
                <a href="index.php?module_name=profile_settings">PROFILE</a>
                <a href="index.php?tab=home">HOME</a>
            </td>
            <td align="center" style="width:25px;"><!--<img src="images/mnu-sep.gif" alt="mnu-sep" />--></td>
          <!--  <td class="lang">English (US)<img src="images/lang-icon.gif" alt="lang icon" /></td>-->
            <td class="logo"><a href="index.php?tab=home"><img src="images/logo.png" alt="logo" border="0" /></a></td>
        </tr>
        </table>
        </div>
        <br class="spacer" />
<!--Start Btm Header-->
    <div class="btm-header">
        <ul>
           <li><a href="index.php?module_name=content_management&file_name=manage_contents&tab=content" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "content") )?"class='topmenu_act'":""; ?>>CONTENT PAGES</a></li>
           <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
           
           
		  <li><a href="index.php?module_name=category_management&amp;file_name=manage_categories_retailer&amp;tab=category" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "category")) ? "class='topmenu_act'" : ""; ?>>CATEGORIES</a></li>
		 	<li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>	
            
            <li><a href="index.php?module_name=advert_management&amp;file_name=manage_adverts&amp;tab=adverts" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "adverts")) ? "class='topmenu_act'" : ""; ?>>ADVERTS</a></li>
             <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
             
          
             <li><a href="index.php?module_name=faq_management&amp;file_name=manage_faqs&amp;tab=faq" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "faq")) ? "class='topmenu_act'" : ""; ?>>FAQS</a></li>
            <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li> 

          <li><a href="index.php?module_name=banners_management&file_name=manage_banners&tab=banner" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "banner") )?"class='topmenu_act'":""; ?>>BANNERS</a></li>
           <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>         
           
            <li><a href="index.php?module_name=advertisment_management&amp;file_name=manage_advertisments&amp;tab=advertisment" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "advertisment")) ? "class='topmenu_act'" : ""; ?>>TOP BANNER</a></li>
            
           
            <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
            <li><a href="index.php?module_name=user_management&amp;file_name=manage_users&amp;tab=users" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "users")) ? "class='topmenu_act'" : ""; ?>>USERS</a></li>
             <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li>
            <li><a href="index.php?module_name=order_management&amp;file_name=manage_orders&amp;tab=order" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "order")) ? "class='topmenu_act'" : ""; ?>>ORDERS</a></li>
                      
           <?
			if( $_SESSION['user_admin'] == "titledev" )
			{			
			?>
            <li><span><img src="images/mnu-sep1.gif" alt="sep" /></span></li> 
            <li><a href="index.php?module_name=manage_modules&amp;tab=settings" <? echo ((isset($_REQUEST['tab']) && $_REQUEST['tab'] == "settings")) ? "class='topmenu_act'" : ""; ?>>SETTINGS</a></li>

		<?	}	?>			
        </ul>
        <div class="btm-header2">
        <?
		switch ( $_REQUEST['tab'] )
		{
			case "content":
		?>
            <ul>
        <?
			if( $_SESSION['user_admin'] == "titledev" )
			{			
		?>
                <li><a href="index.php?module_name=content_management&file_name=add_content&tab=content">Add/Edit Content Page</a></li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
       <?	}	?>
                <li><a href="index.php?module_name=content_management&file_name=manage_contents&tab=content">Manage Content Pages</a></li>

            </ul>         
         
				
		
            
          <?
			break;			
			case "adverts":
			?>
				<ul>
				<li>
						<a href="index.php?module_name=advert_management&amp;file_name=manage_adverts&amp;tab=adverts">View Retailers</a>
				</li>
                <li>
						<a href="index.php?module_name=advert_management&amp;file_name=manage_classified_adverts&amp;tab=adverts">View Classifieds</a>
				</li> 
            <li>
						<a href="index.php?module_name=advert_management&amp;file_name=manage_packages&amp;tab=adverts">View Packages</a>
				</li>              
				</ul>   
           <?
			break;			
			case "users":
			?>
				<ul>
				<li>
						<a href="index.php?module_name=user_management&amp;file_name=manage_users&amp;tab=users">View Classified Users</a>
				</li>
                <li>
						<a href="index.php?module_name=user_management&amp;file_name=manage_retailer_users&amp;tab=users">View Retailer Users</a>
				</li>
                
                <li>
						<a href="index.php?module_name=user_management&amp;file_name=manage_users_emails&amp;tab=users">View Emails</a>
				</li>
                
                <li>
						<a href="index.php?module_name=user_management&amp;file_name=display_emails&amp;tab=users">Copy User Emails</a>
				</li>
                
				</ul>  
             <?
			break;			
			case "counties":
			?>
				<ul>
				<li>
						<a href="index.php?module_name=counties_management&amp;file_name=manage_counties&amp;tab=counties">Manage States/Counties</a>
					</li>

				</ul>
            <?
			break;			
			case "category":
			?>
				<ul>
					<li>
						<a href="index.php?module_name=category_management&amp;file_name=manage_categories_retailer&amp;tab=category">Manage Retailer Categories</a>
					</li>
                    
                    <li>
						<a href="index.php?module_name=category_management&amp;file_name=manage_categories&amp;tab=category">Manage Classified Categories</a>
					</li>
                    
				</ul>			
		
			
			<?
			break;			
			case "banner":
			?>
				<ul>
					<li>
						<a href="index.php?module_name=banners_management&amp;file_name=add_banner&amp;tab=banner">Add Banner</a>
					</li>
                    <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
					<li>
						<a href="index.php?module_name=banners_management&amp;file_name=manage_banners&amp;tab=banner">Manage Banner</a>
					</li>

				</ul>			
		<?
            break;
            case "advertisment":
            ?>
            <ul>
                <li>
                    <a href="index.php?module_name=advertisment_management&amp;file_name=add_advertisment&amp;tab=advertisment">Add/Edit Top Banner</a> 
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                <li>
                    <a href="index.php?module_name=advertisment_management&amp;file_name=manage_advertisments&amp;tab=advertisment">Manage Top Banner(s)</a>
                </li>           
            </ul>  	
		<?
			break;
			case "news":
		?>
        	<ul>
                <li>
                    <a href="index.php?module_name=news_n_events_management&amp;file_name=add_news_n_event&amp;tab=news">Add/Edit News/Event(s)</a> 
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                <li>
                    <a href="index.php?module_name=news_n_events_management&amp;file_name=manage_news_n_events&amp;tab=news">Manage News/Event(s)</a>
                </li>
            </ul>	
        <?
			break;
			case "faq":
		?>
        	<ul>
                <li>
                    <a href="index.php?module_name=faq_management&amp;file_name=add_faq&amp;tab=faq">Add/Edit FAQ(s)</a> 
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                <li>
                    <a href="index.php?module_name=faq_management&amp;file_name=manage_faqs&amp;tab=faq">Manage FAQ(s)</a>
                </li>
            </ul> 
        	<?	
	 		break;
				case "newsletter":
		?>
        	<ul>
                <li>
                    <a href="index.php?module_name=newsletter_management&amp;file_name=add_newsletter&amp;tab=newsletter">Send Newsletter</a> 
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                <li>
                    <a href="index.php?module_name=newsletter_management&amp;file_name=manage_newsletter&amp;tab=newsletter">Manage Newsletter(s)</a>
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
								 <li>
                    <a href="index.php?module_name=newsletter_management&amp;file_name=add_email_addresses&amp;tab=newsletter">User Subscription List</a>
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
            </ul> 
            		</ul>			
         <?
			break;
			case "blog":
		?>
        	<ul>
                <li>
                    <a href="index.php?module_name=blog_management&amp;file_name=add_blog&amp;tab=blog">
                    Add/Edit Blog</a> 
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                <li>
                <a href="index.php?module_name=blog_management&amp;file_name=manage_blog&amp;tab=blog">
                Manage Blog(s)</a>
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
                 <li>
                <a href="index.php?module_name=blog_management&amp;file_name=manage_comments&amp;tab=blog">
                Manage Comment(s)</a>
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
            </ul>      	
			 <?
			break;
			
			case "settings";
		?>
        	<ul>
                <li>
                   <a href="index.php?module_name=manage_modules&amp;tab=settings">Manage Modules</a>
                </li>
                <li><span><img src="images/mnu-sep2.gif" alt="sep2" /></span></li>
            </ul>
		<?
			break;
	 	}	//	End of switch ( $_REQUEST['tab'] ) ?>
        </div>
    
    </div>
<!--End Btm Header-->

</div>