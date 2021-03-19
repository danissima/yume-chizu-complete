import {addItem, removeFromTable} from './functions.js';

let addWordButton = document.querySelector('.word__add'),
		removeWordButton = document.querySelector('.word__remove'),
		wordsTable = document.querySelector('.words__table'),
		wordInputs = "<td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='wordKanji[]' placeholder='Введи слово'></td><td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='wordKana[]' placeholder='Введи написание азбукой'></td><td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='wordTranslation[]' placeholder='Введи перевод'></td><td class='table__cell'><button type='button' class='radical__remove manipulate__button'>&times;</button></td>";
if (addWordButton) {
	addWordButton.addEventListener('click', () => { addItem(wordsTable, wordInputs) });
	removeWordButton.addEventListener('click', removeFromTable);
}

let changeWordButtons = document.querySelectorAll('.word__change'),
	modal = document.querySelector('.modalWords'),
	closeModalButton = document.querySelector('.words-modal__close');

if (changeWordButtons.length) {
	changeWordButtons.forEach(item => item.addEventListener('click', showModal ));
	closeModalButton.addEventListener('click', closeModal);
	window.addEventListener('click', (e) => {
		if (e.target == modal || e.target == document.querySelector('.container') || e.target == document.querySelector('.modal__inner')) closeModal();
	});
}

function showModal() {
	let wordId = this.parentElement.parentElement.children[0].value,
			wordKanji = this.parentElement.parentElement.children[1].innerHTML,
			wordKana = this.parentElement.parentElement.children[2].innerHTML,
			wordTranslation = this.parentElement.parentElement.children[3].innerHTML,
			wordFrom = this.parentElement.parentElement.children[5].value;
	let modalWordKanji = document.querySelector('.modal__word'),
			modalWordKana = document.querySelector('.modal__kana'),
			modalWordTranslation = document.querySelector('.modal__translation'),
			modalDeleteInput = document.querySelector('.deletingWord'),
			modalChangeInput = document.querySelector('.changingWord'),
			modalFromInputs = document.querySelectorAll('.from');

	modal.style.display = "block";

	modalWordKanji.value = wordKanji;
	modalWordKana.value = wordKana;
	modalWordTranslation.value = wordTranslation;
	modalDeleteInput.value = wordId;
	modalChangeInput.value = wordId;
	modalFromInputs.forEach(item => item.value = wordFrom);
}

function closeModal() {
	modal.style.display = "none";
}