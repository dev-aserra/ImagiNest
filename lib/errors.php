<?php if (count($errors) > 0): ?>
  <div class="alert alert-danger pt-0 pb-0 pl-1 pr-1" role="alert">
  	<?php foreach ($errors as $error): ?>
  	  <p class="pt-3"><?php echo $error ?></p>
  	<?php endforeach?>
  </div>
<?php endif?>