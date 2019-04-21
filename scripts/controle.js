$(".sli").slider();


function adicionarControle(comp, count){
	// console.log(comp);
	let p = '';
	let options = "";
	$("#confirma-btn").prop('disabled', false);
	for(let c of comp){
		options += `<option value="${c.codigo}" data-type="${c.tipo}">${c.nome}</option>`;
	}
	p += 
		`<div class="form-row form-group">
			<div class="col-md-6">
				<label>Controle</label>
				<select id="select-controle-${con++}" class="form-control" onchange="checkControleType(${con})" name="id[]">${options}</select>
			</div>
			<div class="col-md-6">
				<label>Potência</label><br>
				<input id="slider" class="sli" type="text" name="command[]" style="margin-left:5vh;" data-slider-value="0" data-slider-min="0" data-slider-max="255" data-slider-step="1"data-slider-value="0"/>
				<br>
			</div>
		</div>
		<hr>`;
	$('#lista-componentes').append(p);
	$(".sli").slider();
}

function checkControleType(obj){
	console.log($('#select-controle-'+obj).children('option:selected').data('type'));
	if($('#select-controle-'+obj).find(':selected').data('type')){

	}
}