<script id="answer_radio" type="text/template">
	<div class="_answer">
		<h5><mark>Ответ №{$id}</mark> <button type="button" class="btn btn-danger btn-xs _remove_answer">Удалить</button></h5>
		<div class="form-group">
			<label>Текст ответа</label>
			<textarea name="a_{$id}_text" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label>Вес ответа</label>
			<input type="text" name="a_{$id}_weight" value="0" class="form-control" />
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="a_0_correct" value="{$id}" class="_correct" /> Правильный ответ
			</label>
		</div>
		<hr />
	</div>
</script>
<script id="answer_checkbox" type="text/template">
	<div class="_answer">
		<h5><mark>Ответ №{$id}</mark> <button type="button" class="btn btn-danger btn-xs _remove_answer">Удалить</button></h5>
		<div class="form-group">
			<label>Текст ответа</label>
			<textarea name="a_{$id}_text" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label>Вес ответа</label>
			<input type="text" name="a_{$id}_weight" value="0" class="form-control" />
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="a_{$id}_correct" class="_correct" /> Правильный ответ
			</label>
		</div>
		<hr />
	</div>
</script>
<script id="answer_text" type="text/template">
	<div class="_answer">
		Для текстового вопроса не предусмотрены варианты ответа
	</div>
</script>