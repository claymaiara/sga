<?php 
Sessao::validarForm('cadastrar/Atividade'); 
?>

<fieldset>
				<legend>Nova Atividade</legend>
<form name="projeto" id="atividade" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/atividade.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>     
     <tr>
      
     	<th>
      		<input name="pro_cod_projeto" type="hidden" value="<?php ?>" />     	 
     	</th>
     </tr>
	
	<tr>
		<th nowrap="nowrap">Projeto:</th>
		<td>
	    <?php 
		$tbProjeto = new TbProjeto();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('pro_codigo', $tbProjeto->listarProjetoAtivo($_SESSION['dep_codigo']),true,$_SESSION['cadastrar/Atividade']);
		?>
		</td>
     </tr>
	
	<tr>
		<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Executor:</th>
		<td>
	    <?php 
		$tbUsuario = new TbUsuario();
		FormComponente::$name = 'Selecione...';
		$_SESSION['cadastrar/Atividade']['usu_codigo_responsavel'] = ($_SESSION['cadastrar/Atividade']['usu_codigo_responsavel'] == '') ? $_SESSION['usu_codigo'] : $_SESSION['cadastrar/Atividade']['usu_codigo_responsavel'];
		FormComponente::selectOption('usu_codigo_responsavel', $tbUsuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']),true,$_SESSION['cadastrar/Atividade']);
		?>
		</td>
     </tr>
	<tr>
		<th nowrap="nowrap">Status:</th>
		<td>
	    <?php 
		$tbStatusAtividade = new TbStatusAtividade();
		FormComponente::selectOption('sta_codigo', $tbStatusAtividade->listarStatusAtividade(),false,$_SESSION['cadastrar/Atividade']);
		?>
		</td>
     </tr>     
     
     <tr>
       <th width="119" align="left" nowrap="nowrap">Previs�o Inicio:</th>
     	<td> 	
      		<input type="text" id="data-id" class="data" name="at_previsao_inicio" value="<?php echo($_SESSION['cadastrar/Atividade']['at_previsao_inicio']); ?>"  />
     	</td>
     </tr>
     
      <tr>
       <th width="119" align="left" nowrap="nowrap">Previs�o Fim:</th>	
      	<td>
      		<input type="text" id="data" class="data" name="at_previsao_fim" value="<?php echo($_SESSION['cadastrar/Atividade']['at_previsao_fim']); ?>"  />
     	</td>
     </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Descri��o:</th>
      <td>
      	<textarea name="at_descricao" rows="5" cols="32"><?php echo($_SESSION['cadastrar/Atividade']['at_descricao']); ?></textarea>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Observa��o:</th>
      <td>
      	<textarea name="at_observacao" rows="5" cols="32"><?php echo($_SESSION['cadastrar/Atividade']['at_observacao']); ?></textarea>
      </td>
    </tr>    
    
    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="cadastrar" class="button-tela" value="Salvar" />
      </td>
    </tr>
    
  </table>
</form>
</fieldset>
<?php unset($_SESSION['cadastrar/Atividade']);?>