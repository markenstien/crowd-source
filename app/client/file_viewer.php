<?php require_once('../dependencies.php')?>
<?php require_once('functions/main.php')?>

<?php build('content')?>
	
	<div style="margin-top: 50px"></div>
	<div class="card">
		<div class="card-header">
			<h4>File Viewer</h4>
		</div>
		<div class="card-body">
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
						<embed src="<?php echo URL.DS.'public/assets/'.$file?>" style="width: 100%; min-height: 100vh"></embed>
					<?php
				}
			?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('orbit/app')?>