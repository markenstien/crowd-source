<?php if(Session::get('auth') === 'company') :?>
	<?php include_once APPROOT.DS.'templates/user/sidebars/company.php';?>
<?php endif;?>

<?php if(Session::get('auth') === 'vendor') :?>
	<?php include_once APPROOT.DS.'templates/user/sidebars/admin.php';?>
<?php endif;?>
