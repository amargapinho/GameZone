<?php
use GameZone\Category;
?>
<script>
	$(function () {
		const availableTags = [
			<?php foreach (Category::getAll() as $category):?>
			"<?=$category->getCategoryName()?>",
			<?php endforeach;?>
		];

		function split(val) {
			return val.split(/,\s*/);
		}

		function extractLast(term) {
			return split(term).pop();
		}

		$("#categories")
			// don't navigate away from the field on tab when selecting an item
			.on("keydown", function (event) {
				if (event.keyCode === $.ui.keyCode.TAB &&
					$(this).autocomplete("instance").menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function (request, response) {
					// delegate back to autocomplete, but extract the last term
					response($.ui.autocomplete.filter(
						availableTags, extractLast(request.term)));
				},
				focus: function () {
					// prevent value inserted on focus
					return false;
				},
				select: function (event, ui) {
					const terms = split(this.value);
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push(ui.item.value);
					// add placeholder to get the comma-and-space at the end
					terms.push("");
					this.value = terms.join(", ");
					return false;
				}
			});
	});
</script>

<div class="modal fade" id="gameModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="gameModalTitle">Spiel</h5>
			</div>
			<form method="post" enctype="multipart/form-data" action="?<?= http_build_query($_GET) ?>" id="gameForm">
				<div class="modal-body">
					<div class="form-group" hidden>
						<label for="gameID">Game ID</label>
						<input placeholder="1" type="number" class="form-control" name="gameID" id="gameID">
					</div>
					<div class="form-group">
						<label for="gameName">Titel</label>
						<input placeholder="Name" type="text" class="form-control" name="gameName" id="gameName" required>
					</div>
					<div class="form-group">
						<label for="description">Beschreibung</label>
						<textarea placeholder="Beschreibung" class="form-control" name="description" id="description" required></textarea>
					</div>
					<div class="form-group">
						<label for="releaseDate">Erscheinungsdatum</label>
						<input type="date" class="form-control" name="releaseDate" id="releaseDate" required>
					</div>
					<div class="form-group">
						<label for="price">Preis</label>
						<input placeholder="59.99" type="number" min="0" step="0.01" class="form-control" name="price" id="price" required>
					</div>
					<div class="form-group">
						<label for="review">Bewertung</label>
						<input placeholder="5" type="number" min="1" max="5" step="1" class="form-control" name="review" id="review" required>
					</div>
					<div class="form-group">
						<label for="categories">Kategorien</label>
						<input type="search" class="form-control" name="categories" id="categories">
						
<!--						<select class="select" multiple>
							<option value="1">One</option>
						</select>class="form-control"
						<label for="categories" class="form-label select-label">Kategorien</label>
-->						
						
					</div>
					<div class="form-group">
						<label for="images">Bild</label>
						<input type="file" class="form-control-file" name="images[]" id="images" accept="image/*" multiple>

					</div>
					<div class="form-check">
						<input type="checkbox" class="form-check-input" name="wishlisted" id="wishlisted">
						<label for="wishlisted" class="form-check-label">Wunschliste</label>
					</div>
				</div>
				
				<div class="modal-footer d-flex justify-content-between">
					<button type="submit" class="btn btn-primary" name="action" value="updateGame">
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