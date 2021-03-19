import {addItem, removeFromTable} from './functions.js';

let addRadicalButton = document.querySelector('.radical__add'),
		removeRadicalButton = document.querySelector('.radical__remove'),
		radicalsTable = document.querySelector('.radicals__table'),
		radicalInputs = "<td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='radicalView[]' placeholder='Введи ключ'></td><td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='radicalNumber[]' placeholder='Введи номер'></td><td class='table__cell'><input type='text' class='form__item form__item_no-margin' name='radicalName[]' placeholder='Введи название'></td><td class='table__cell'><button type='button' class='radical__remove manipulate__button'>&times;</button></td>";

if (addRadicalButton) {
	addRadicalButton.addEventListener('click', () => { addItem(radicalsTable, radicalInputs) });
	removeRadicalButton.addEventListener('click', removeFromTable);
}


let changeRadicalButtons = document.querySelectorAll('.radical__change'),
	modal = document.querySelector('.modalRadicals'),
	closeModalButton = document.querySelector('.radical-modal__close');

if (changeRadicalButtons.length) {
	changeRadicalButtons.forEach(item => item.addEventListener('click', showModal ));
	closeModalButton.addEventListener('click', closeModal);
	window.addEventListener('click', (e) => {
		if (e.target == modal || e.target == document.querySelector('.container') || e.target == document.querySelector('.modal__inner')) closeModal();
	});
}

function showModal() {
	let radicalID = this.parentElement.parentElement.children[0].value,
		radicalView = this.parentElement.parentElement.children[1].innerHTML,
		radicalNumber = this.parentElement.parentElement.children[2].innerHTML,
		radicalName = this.parentElement.parentElement.children[3].innerHTML;
	let modalRadicalView = document.querySelector('.modal__radical'),
		modalRadicalNumber = document.querySelector('.modal__number'),
		modalRadicalName = document.querySelector('.modal__name'),
		modalChangeInput = document.querySelector('.changingRadical'),
		modalDeleteInput = document.querySelector('.deletingRadical');

	modal.style.display = "block";

	modalRadicalView.value = radicalView;
	modalRadicalNumber.value = radicalNumber;
	modalRadicalName.value = radicalName;
	modalChangeInput.value = radicalID;
	modalDeleteInput.value = radicalID;
}

function closeModal() {
	modal.style.display = "none";
}