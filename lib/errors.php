<?php if (count($errors) > 0): ?>
	<div id="modal" class="modal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content bg-dark-x">
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title fw-bold text-white">Error</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger pt-0 pb-0 pl-1 pr-1" role="alert">
						<?php foreach ($errors as $error): ?>
							<p class="pt-3"><?php echo $error ?></p>
						<?php endforeach?>
					</div>
				</div>
				<div class="modal-footer border-top-0">
					<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tancar</button>
				</div>
			</div>
		</div>
	</div>
<?php endif?>