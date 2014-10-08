var answers = $('#answers'),
	answer_radio = $('#answer_radio'),
	answer_checkbox = $('#answer_checkbox'),
	answer_text = $('#answer_text'),
	add = $('#add_answer'),
	num = $('#number_of_answers'),
	count = +num.val();

/**
 * Сохраненные ответы для предыдущего типа, чтобы не терялись
 * при переключении на текстовый ответ и обратно. 
 */
var _saved = [];

/**
 * Добавление нового варианта ответа по типу вопроса.
 *
 * @function _addAnswer
 *
 * @param type [integer] - Тип вопроса.
 * @param onlyNode [boolean] - Вернуть ли сам контейнер или просто добавить в ответы.
 */
var _addAnswer = function (type, onlyNode) {
	onlyNode = onlyNode || false;
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

	if (onlyNode) {
		return $(newAnswer.replace(/\{\$id\}/gi, count));
	} else {
		answers.append(newAnswer.replace(/\{\$id\}/gi, count));
	}
};

/**
 * Удаление варианта ответа.
 *
 * @function _deleteAnswer
 *
 * @param e [object] Event.
 */
var _deleteAnswer = function (e) {
	if (answers.find('._answer').length > 2) {
		// Удаляем этот ответ
		$(e.target).closest('._answer').remove();
		count--;
		num.val(count);

		// Проставляем новые индексы для имеющихся ответов
		answers.find('._answer').each(function (i, element) {
			var el = $(element);
			el.find('mark').html('Ответ №' + (i+1));
			el.find('input, textarea').each(function (n, input) {
                if ( $(input).attr('type') === 'radio' ) {
                    $(input).val(i+1);
                } else {
                    var oldName = input.getAttribute('name');
                    input.setAttribute('name', oldName.replace(/[0-9]+/, (i+1)));
                }
			});
		});
	} else {
		alert('Для данного типа вопроса должно быть не менее 2 ответов');
	}
};

/**
 * Отправляет форму с новым вопросом на сервер.
 *
 * @function _sendQuestion
 *
 * @param e [object] Event.
 */
var _sendQuestion = function (e) {
	if (answers.find('._correct').length) {
		var tempAnswers = answers.find('._answer:not(.empty)'),
			hasCorrect  = 0;

		// Проверка на наличие верных ответов
		for (var i = 0, len = tempAnswers.length; i < len; i++) {
			var item = $(tempAnswers[i]);

			if (item.find('._correct:checked').length) {
				hasCorrect++;
			}
		}

		if (!hasCorrect) {
			e.preventDefault();
			e.stopPropagation();

			alert('Нет верных ответов!');
		}
	}
};

/** 
 * Меняет тип вопроса, сохраняя ответы для предыдущего типа (если есть).
 *
 * @function _changeType
 *
 * @param e [object] Event.
 */
var _changeType = function (e) {
	var answersExist = (_saved.length) ? _saved : [];

	if (!answersExist.length) {
		if (answers.find('._answer').length > 1) {
			answers.find('._answer').each(function (i, j) {
				var node = $(j);

				answersExist.push({
					number: i + 1,
					value: node.find('textarea').val(),
					weight: +node.find('input[type="text"]').val(),
					correct: node.find('._correct').prop('checked')
				});
			});
		}
	}

	answers.empty();
	count = 0;
	
	if (!answersExist.length || +e.target.value === 3) {
		_addAnswer(+e.target.value);
	} else {
		for (var i = 0, len = answersExist.length; i < len; i++) {
			var answ = _addAnswer(+e.target.value, true);

			answ.find('textarea').val(answersExist[i].value);
			answ.find('input[type="text"]').val(answersExist[i].weight);
			answ.find('._correct').prop('checked', answersExist[i].correct);
			answers.append(answ);
		}
	}

	if (+e.target.value === 3) {
		if (answersExist.length) {
			_saved = answersExist;
		}				

		add.hide();
	} else {
		if (!answersExist.length) {
			_addAnswer(+e.target.value);
		}

		_saved.length = 0;

		add.show();
	}
};

$(function () {
	if (answers.length) {
		// Клик на удаление имеющегося ответа
		$(document).on('click', '._remove_answer', _deleteAnswer);

		// Клик по типу вопроса
		$(document).on('click', '._answer_type', _changeType);

		// Submit формы
		$(document).on('click', '._submit', _sendQuestion);

		if (!answers.hasClass('edit')) {
			$('._answer_type:checked').click();
		}

		// Клик на добавление нового ответа
		add.on('click', _addAnswer);
	}
});