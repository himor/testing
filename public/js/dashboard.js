var answers = $('#answers'),
	answer_radio = $('#answer_radio'),
	answer_checkbox = $('#answer_checkbox'),
	answer_text = $('#answer_text'),
	add = $('#add_answer'),
	num = $('#number_of_answers'),
	count = 0;

/** 
 * Добавление нового вопроса по типу
 *
 * @function _addAnswer
 */
var _addAnswer = function (type) {
	type = (type && typeof type === 'number') ? type : +$('._answer_type:checked').val();

	var newAnswer;

	// Обновляем счетчик
	count++;
	num.val(count);

	switch (type) {
		case 1:
			newAnswer = answer_radio.html();
			break;

		case 2:
			newAnswer = answer_checkbox.html();
			break;

		case 3:
			newAnswer = answer_text.html();
			break;
	}

	answers.append(newAnswer.replace(/\{\$id\}/gi, count));
};

$(function () {
	if (answers.length) {	

		// Клик на удаление имеющегося ответа
		$(document).on('click', '._remove_answer', function (e) {
			if (answers.find('._answer').length > 2) {
				// Удаляем этот ответ
				$(e.target).closest('._answer').remove();
				count--;
				num.val(count);

				// Проставляем новые индексы для имеющихся ответов
				answers.find('._answer').each(function (i, element) {
					var el = $(element);
					el.find('mark').html('Ответ №' + (i+1));
					el.find('input').each(function (n, input) {
						var oldName = input.getAttribute('name');
						input.setAttribute('name', oldName.replace(/[0-9]+/, (i+1)));
					});
				});
			} else {
				alert('Для данного типа вопроса должно быть не менее 2 ответов');
			}
		});

		// Клик по типу вопроса
		$(document).on('click', '._answer_type', function (e) {
			answers.empty();
			count = 0;
			_addAnswer(+e.target.value);

			// Скрываем/показываем кнопку добавления ответа
			if (+e.target.value === 3) {
				add.hide();
			} else {
				_addAnswer(+e.target.value);
				add.show();
			}
		});

		$('._answer_type:checked').click();		

		// Клик на добавление нового ответа
		add.on('click', _addAnswer);
	}
});