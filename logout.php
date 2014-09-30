<?
		ob_start();
		session_start();
		include("inc/ini.php");
			
		$_SESSION['login']['candidateId'] = NULL;
		unset($_SESSION['login']['candidateId']);
		session_unregister($_SESSION['login']['candidateId']);
		
		$_SESSION['login']['candidateName'] = NULL;
		unset($_SESSION['login']['candidateName']);
		session_unregister($_SESSION['login']['candidateName']);
		
		$_SESSION['login']['isvalidlogin'] = NULL;
		unset($_SESSION['login']['isvalidlogin']);
		session_unregister($_SESSION['login']['isvalidlogin']);
		//session_destroy();
		// $content_obj->Redirect("client-area.php");
		header("Location:	index.php"); exit(0);
?>