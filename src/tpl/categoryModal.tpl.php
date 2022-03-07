<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="gameModalTitle">Kategorie</h5>
			</div>
			<form method="post" id="categoryForm">
				<div class="modal-body">
					<div class="form-group" hidden>
						<label for="categorieID">Category ID</label>
						<input type="number" class="form-control" id="categorieID" name="categorieID">
					</div>
					<div class="form-group">
						<label for="categoryName">Name</label>
						<input type="text" class="form-control" id="categoryName" name="categoryName" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button
						type="submit"
						name="action"
						value="saveCategory"
						class="btn btn-primary">
						Speichern
					</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Abbrechen
					</button>
				</div>
			</form>
		</div>
	</div>
</div>