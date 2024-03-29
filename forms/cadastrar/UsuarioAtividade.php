<?php 
Sessao::validarForm('cadastrar/UsuarioAtividade'); 

$tbAtividade =  new TbAtividade();

$_SESSION['alterar/Atividade'] = $tbAtividade->getFormAlteracao(base64_decode($_SESSION['valorform'])); 

?>

<fieldset>
	<legend><?php echo($_SESSION['config']['usuario']);?> Atividade:</legend>

<fieldset id="telausuarioatividade">
	<legend><a href="#"><span id="usuarioatividade">Informa��es da Atividade [Ocultar]</span></a></legend>
			
  <table border="0" cellspacing="5" id="esconder">
	<tr>
		<th nowrap="nowrap">Projeto:</th>
		<td>
	    <?php 
		$tbProjeto = new TbProjeto();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('pro_codigo', $tbProjeto->listarProjetoAtivo(),true,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>
	
	<tr>
		<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Executor:</th>
		<td>
	    <?php 
		$tbUsuario = new TbUsuario();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('usu_codigo_responsavel', $tbUsuario->selectUsuarios(),true,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>
	<tr>
		<th nowrap="nowrap">Status:</th>
		<td>
	    <?php 
		$tbStatusAtividade = new TbStatusAtividade();
		FormComponente::selectOption('sta_codigo', $tbStatusAtividade->listarStatusAtividade(),false,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>     
     
     <tr>
       <th width="119" align="left" nowrap="nowrap">Previs�o Inicio:</th>
     	<td> 	
      		<input type="text" id="data-id" class="data" name="at_previsao_inicio" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Atividade']['at_previsao_inicio'])); ?>"  />
     	</td>
     </tr>
     
      <tr>
       <th width="119" align="left" nowrap="nowrap">Previs�o Fim:</th>	
      	<td>
      		<input type="text" id="data" class="data" name="at_previsao_fim" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Atividade']['at_previsao_fim'])); ?>"  />
     	</td>
     </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Descri��o:</th>
      <td>
      	<textarea name="at_descricao" rows="5" cols="32"><?php echo($_SESSION['alterar/Atividade']['at_descricao']); ?></textarea>
      </td>
    </tr>
	</table>
</fieldset>

<form name="UsuarioAtividade" id="UsuarioAtividade" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/atividade.php">
<fieldset>
	<legend>Cadastrar <?php echo($_SESSION['config']['usuario']); ?> Atividade</legend>
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="5" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['mensagem']);
      		  Texto::mostrarMensagem(Erro::verificarErro($_SESSION['erro'])); ?>
   		<input name="at_codigo" type="hidden" value="<?php echo($_SESSION['alterar/Atividade']['at_codigo']); ?>" />     	       	
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap"><?php echo($_SESSION['config']['usuario']); ?>:</th>
      
      <td>
		<?php 
			$tbUsuario = new TbUsuario();
			#Retorna os dados da Atividade, Atividade, Projeto, usuario_sol e usuario_responsavel
			$dadosAtividade = $tbAtividade->getUsuarioAtividadeProjeto($_SESSION['alterar/Atividade']['at_codigo']);
			
			FormComponente::$name = 'Selecione...';
			FormComponente::selectOption('usu_codigo', $tbUsuario->selectUsuariosAtividade($dadosAtividade),true,$_SESSION['cadastrar/UsuarioAtividade']);
		?>
	  </td>
      
      <th align="left" nowrap="nowrap">Tipo de <?php echo($_SESSION['config']['usuario']); ?>:</th>
	      <td>
  		   <?php 
		       $tbTipoUsuarioAtividade = new TbTipoUsuarioAtividade();
		       FormComponente::selectOption('tua_codigo',$tbTipoUsuarioAtividade->listar(),true,$_SESSION['cadastrar/UsuarioAtividade']);
		   ?>
		 </td>

      <td colspan="2" align="left">
	      <input type="submit" name="cadastrar" value="Salvar" />
	  </td>
	  <td>
	      <a href="./action/formcontroler.php?<?php echo(base64_encode('alterar/Atividade').'='.base64_encode($_SESSION['alterar/Atividade']['at_codigo']));?>">
						<img src="./css/images/voltar.png" title="Voltar para Atividade">
					</a>
      </td>
    </tr>

  </table>
</fieldset>
</form>
<?php 

$tbUsuarioAtividade = new TbUsuarioAtividade();

$DataGridAtividade = new DataGrid(array($_SESSION['config']['usuario'],'Tipo '.$_SESSION['config']['usuario']), 
										$tbUsuarioAtividade->listar($_SESSION['alterar/Atividade']['at_codigo']));

$DataGridAtividade->titulofield = $_SESSION['config']['usuario'].'e(s)';										
$DataGridAtividade->acao = 'alterar/UsuarioAtividade';										
$DataGridAtividade->colunaoculta = 1;										
$DataGridAtividade->mostrarDatagrid(1);

unset($_SESSION['cadastrar/UsuarioAtividade']);
?>
</fieldset>