<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		
		<?php 
			$file = $_GET['filename'];
			$fileExplode = explode('.', $_GET['filename']);
			$ext  = end($fileExplode);

			if(in_array($ext, ['jpeg' , 'jpg' , 'png' , 'bitmap'])){
				?> 
					<img src="<?php echo URL.DS.'public/assets/'.$file?>" style="width: 700px;">
				<?php
			}
			else
			{
				?> 
					<embed src="<?php echo URL.DS.'public/assets/'.$file?>" style="width: 1300px; min-height: 100vh"></embed>
				<?php
			}
		?>
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>