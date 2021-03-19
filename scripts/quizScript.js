quizResults = quizResults.split(', ');
quizResults.splice(0, 1);
let ons = quizResults.filter(item => /[ア-ン]+/.test(item)),
	kuns = quizResults.filter(item => /[あ-ん]+/.test(item)),
	meanings = quizResults.filter(item => /[а-я]+/.test(item));

let checkButton = document.querySelector('.buttons__check-answers'),
	showResultsButton = document.querySelector('.buttons__show-results');

function isAnswerCorrect(arrayValues, arrayCorrectValues, answerField) {
	if (arrayValues.every(item => arrayCorrectValues.includes(item)) && arrayCorrectValues.every(item => arrayValues.includes(item))) {
		answerField.style.borderColor = 'lightgreen';
	} else if (arrayValues.some(item => arrayCorrectValues.includes(item))) {
		answerField.style.borderColor = 'orange';
	} else {
		answerField.style.borderColor = 'red';
	}
}

function howToSplit(input) {
	if (input.split('').includes(',')) { return input.split(', '); } 
	else if (input.split('').includes('、')) { return input.split('、'); }
	else if (input.split('').includes('　')) { return input.split('　'); }
	else { return input.split(' '); }
}

function checkAnswers() {
	let answerFieldOns = document.getElementById('answer-field__item-ons'),
			answerFieldKuns = document.getElementById('answer-field__item-kuns'),
			answerFieldMeanings = document.getElementById('answer-field__item-meanings');
	let quizAnswerOns = howToSplit(answerFieldOns.value),
		quizAnswerKuns = howToSplit(answerFieldKuns.value),
		quizAnswerMeanings = howToSplit(answerFieldMeanings.value.toLowerCase());
	
		isAnswerCorrect(quizAnswerOns, ons, answerFieldOns);
		isAnswerCorrect(quizAnswerKuns, kuns, answerFieldKuns);
		isAnswerCorrect(quizAnswerMeanings, meanings, answerFieldMeanings);
}

function showResults() {
	let resultsOns = document.querySelector('.results__ons'),
		resultsKuns = document.querySelector('.results__kuns'),
		resultsMeanings = document.querySelector('.results__meanings'),
		quizResultsBlock = document.querySelector('.quiz__results');
	
	resultsOns.append('Онные чтения: ' + ons.join('、'));
	resultsKuns.append('Кунные чтения: ' + kuns.join('、'));
	resultsMeanings.append('Значения: ' + meanings.join(', '));
	
	quizResultsBlock.style.display = 'block';
	this.removeEventListener('click', showResults);
}
checkButton.addEventListener('click', checkAnswers);
showResultsButton.addEventListener('click', showResults);


