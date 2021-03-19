import {addItem, removeFromTable} from './functions.js';

let addCombinationButton = document.querySelector('.combinations__add'),
		removeCombinationButtons = document.querySelectorAll('.combination__remove'),
		combinationsTable = document.querySelector('.combinations__table'),
		combinationsInputs = "<td class='table__cell'><input placeholder='Введи сочетание' type='text' class='form__item form__item_no-margin' name='combinationsKanji[]'></td><td class='table__cell'><input placeholder='Введи написание азбукой' type='text' class='form__item form__item_no-margin' name='combinationsKana[]'></td><td class='table__cell'><input placeholder='Введи перевод' type='text' class='form__item form__item_no-margin' name='combinationsTranslation[]'></td><td class='table__cell'><button type='button' class='combination__remove manipulate__button'>&times;</button></td>";
let addOnsButton = document.querySelector('.ons__add'),
		removeOnButtons = document.querySelectorAll('.on__remove'),
		onsTable = document.querySelector('.ons__table'),
		onsInputs = "<td class='table__cell'><textarea placeholder='Введи он' name='newKanjiOnsReading[]' class='form__textarea form__item form__item_no-margin'></textarea></td><td class='table__cell'><textarea placeholder='Введи значение' name='newKanjiOnsMeaning[]' class='form__textarea form__item form__item_no-margin'></textarea></td><td class='table__cell'><button type='button' class='on__remove manipulate__button'>&times;</button></td>";
let addKunsButton = document.querySelector('.kuns__add'),
		removeKunButtons = document.querySelectorAll('.kun__remove'),
		kunsTable = document.querySelector('.kuns__table'),
		kunsInputs = "<td class='table__cell'><textarea placeholder='Введи кун' name='newKanjiKunsReading[]' class='form__textarea form__item form__item_no-margin'></textarea></td><td class='table__cell'><textarea placeholder='Введи значение' name='newKanjiKunsMeaning[]' class='form__textarea form__item form__item_no-margin'></textarea></td><td class='table__cell'><button type='button' class='kun__remove manipulate__button'>&times;</button></td>";


addCombinationButton.addEventListener('click', () => { addItem(combinationsTable, combinationsInputs) });
removeCombinationButtons.forEach(button => button.addEventListener('click', removeFromTable));
addOnsButton.addEventListener('click', () => { addItem(onsTable, onsInputs) });
removeOnButtons.forEach(button => button.addEventListener('click', removeFromTable));
addKunsButton.addEventListener('click', () => { addItem(kunsTable, kunsInputs) });
removeKunButtons.forEach(button => button.addEventListener('click', removeFromTable));

