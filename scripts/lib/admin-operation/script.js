function returnNavegation() {
	window.location.href = "main.php";

}

function setOption(value, user){
	window.location.href = "main.php?t="+value+"&u="+user;
}

window.addEventListener("load", () => {
	let reset = {};
	for(let opcao of document.querySelectorAll('.opcao-repeticao')){
		reset[opcao.id] = opcao.value;
	}
	for(let elemento of document.querySelectorAll('.escolha-repeticao')){
		elemento.addEventListener('click', () => {
			for(let input of document.querySelectorAll('.opcao-repeticao')){
				input.disabled = false;
			}
			let disabled = ['semana', 'ano'];
			switch(elemento.id){
				case 'check1': // diario
					disabled.push('dia');
					break;
				case 'check2': // semanal
					disabled = ['dia', 'mes', 'ano'];

				case 'check3': // mensal
					disabled.push('mes');
					break;
				case 'check0': // sem repetição
					disabled = ['semana'];
					break;
			}
			
			for(let id of disabled){
				let d = document.querySelector('#rep-' + id);
				d.value = reset['rep-' + id];
				d.disabled = true;
			}
		});
	}
	document.querySelector('.escolha-repeticao:checked').click();
});
