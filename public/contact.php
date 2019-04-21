<div class="container bg-white">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h1>Entre em contato conosco</h1>
			<p class="lead">Preencha os campos do formulário e clique no botão enviar. Entraremos em contato o mais
				rápido possível.</p>
			<form id="contact-form" method="post" action="public/index-panel/contact-us/feedback_envio.php">
				<div class="controls">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="form_name">Primeiro nome *</label>
								<input id="form_name" type="text" name="name" class="form-control" placeholder="Por favor, insira seu primeiro nome *" required="required" data-error="O primeiro nome � obrigat�rio.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="form_lastname">Sobrenome *</label>
								<input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Por favor, insira seu sobrenome *" required="required" data-error="O sobrenome � obrigat�rio.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="form_email">E-mail *</label>
								<input id="form_email" type="email" name="email" class="form-control" placeholder="Por favor, insira o seu e-mail *" required="required" data-error="� necess�rio inserir um e-mail v�lido.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="form_phone">Telefone</label>
								<input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Por favor, insira seu telefone">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="form_message">Menssagem *</label>
								<textarea id="form_message" name="message" class="form-control" placeholder="Escreva para nós *" rows="4" required="required" data-error="Por favor, nos deixe uma mensagem."></textarea>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-md-12">
							<input type="submit" id="alert" class="btn btn-success btn-send" value="Enviar mensagem">


						</div>

					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<p class="text-muted"><strong>*</strong> Esses campos são obrigatórios.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>