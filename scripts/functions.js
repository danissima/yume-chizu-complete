export function addItem(table, inputs) {
	let newRow = document.createElement('tr');
	newRow.classList.add('table__row');
	newRow.innerHTML = inputs;
	table.append(newRow);
	newRow.lastChild.firstChild.addEventListener('click', removeFromTable);
}
export function removeFromTable() {
	if (this.parentElement.parentElement.parentElement.children.length == 1) {
		for(let i = 0; i < this.parentElement.parentElement.children.length - 1; i++) {
			this.parentElement.parentElement.children.item(i).children.item(0).innerHTML = '';
			this.parentElement.parentElement.children.item(i).children.item(0).value = '';
		}
	} else {
		this.parentElement.parentElement.remove();
	}
}
	