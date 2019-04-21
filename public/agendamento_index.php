<div class="row">
<div class="col-lg-8 col-lg-offset-2">
    <h1>Entre em contato conosco</h1>
    <p class="lead">Preencha os campos do formulário e clique no botão enviar. Entraremos em contato o mais
        rápido possível.</p>
    <form id="contact-form" method="post" action="public/agendamento.php">
        <div class="controls">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_name">Status *</label>
                        <input id="form_name" type="text" name="status" class="form-control" placeholder="Por favor, insira o status" required="required" data-error="O status é obrigatório.">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_lastname">Dia *</label>
                        <input id="form_lastname" type="date" name="dias" class="form-control" placeholder="Por favor, insira o dia para agendar *" required="required" data-error="O dia é obrigatório.">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_email">Hora *</label>
                        <input id="form_email" type="time" name="hora" class="form-control" placeholder="Por favor, insira a hora para agendar *" required="required" data-error="A hora é obrigatório.">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
             </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_phone">Descrição </label>
                        <textarea id="form_phone" placeholder="Sua descrição."  name="descricao" class="form-control" rows="4" ></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código usuário *</label>
                        <select id="agendamento" name="cod_usuario" class="form-control" required="required" data-error="O código do usuário é necessário.">
                            <?php    
                                $conexao = pg_connect("host=localhost port=5432 dbname=houzion user=houzion password=bj2fF4");
                                if(!$conexao)
                                {
                                        echo "Não foi possível conectar com o banco de dados";
                                }
                                else
                                {
                                    $sql1="SELECT codigo FROM usuario WHERE exclusao IS NULL ORDER BY codigo";
                                    $resultado=pg_query($conexao,$sql1); 
                                    $qtde=pg_num_rows($resultado);

                                    if($qtde > 0)
                                    {       
                                        while($linha = pg_fetch_array($resultado))
                                    {
                                        echo "<option value=".$linha['codigo'].">";
                                        echo $linha['codigo'];
                                        echo "</option>";
                                    }
                                    }else
                                    {
                                        echo "<option>Não há código registrado</option>";
                                    }
                                        
                                }
                                pg_close($conexao);

                            ?>   
                        
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                
                <!-- codigo coontrole -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código controle *</label>
                        <select id="agendamento" name="cod_controle" class="form-control" required="required" data-error="O código de controle é necessário.">
                        <?php
                            $conexao = pg_connect("host=localhost port=5432 dbname=houzion user=houzion password=bj2fF4");
                            if(!$conexao)
                            {
                                echo "Não foi possivel se conectar com o banco de dados";
                            }
                            else
                            {
                                $sql2="SELECT codigo FROM controle ORDER BY codigo";
                                $resultado=pg_query($conexao,$sql2); 
                                $qtde=pg_num_rows($resultado);
                    
                                if($qtde > 0)
                                {       
                                    while($linha = pg_fetch_array($resultado))
                                {
                                    echo "<option value=".$linha['codigo'].">";
                                    echo $linha['codigo'];
                                    echo "</option>";
                                }
                                }else
                                {
                                    echo "<option>Não há código registrado</option>";
                                }
                            }
                            pg_close($conexao);
                        ?>
                        
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="submit" id="alert" class="btn btn-success btn-send" value="Enviar ">
                                   
                
                </div>
                
            </div> <!-- row-->
          
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