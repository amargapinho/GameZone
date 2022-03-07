<?php
use GameZone\Category;
include TPL.'categoryModal.tpl.php'
?>

<script src="/src/js/categories.js"></script>
<script>
	$(document).ready(function () {
		startTable();
	});
</script>

<div class="container py-5" style="margin-top: 20px">
	<button
		type="button"
		class="btn btn-primary"
		data-toggle="modal"
		data-target="#categoryModal"
		onclick="document.getElementById('categoryForm').reset()">
		Neue Kategorie hinzufügen
	</button>

	<table class="table dataTable table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th data-orderable="false"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach (Category::getAll() as $category): ?>
				<tr>
					<th><?= $category->getCategoryName() ?></th>
					<th>
						<button
							type="button"
							class="btn btn-primary"
							data-toggle="modal"
							data-target="#categoryModal"
							onclick="getCategory(<?= $category->getCategoryID() ?>)"
							data-toggle="tooltip"
							title="Kategorie bearbeiten">
							<i class="fa-solid fa-pen-to-square"></i>
						</button>
						<button
							type="button"
							class="btn btn-danger"
							id="deleteButton<?= $category->getCategoryID() ?>"
							onclick="deleteCategory(<?= $category->getCategoryID() ?>)
							data-toggle="tooltip"
							title="Löschen"">
							<i class="fa-regular fa-trash-can"></i>
						</button>
					</th>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>