<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="gameModalTitle">Rubrik Bearbeiten</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group">
						<label for="categoryID" hidden></label>
						<input type="number" class="form-control" id="categoryID" name="categoryID" hidden>
					</div>
					<div class="form-group">
						<label for="categoryName">Rubrik Name</label>
						<input type="text" class="form-control" id="categoryName" name="categoryName">
					</div>
					<button type="submit" name="action" value="saveCategory">Speichern</button>
				</form>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
			</div>
		</div>
	</div>
</div>