<?php 
$tbsolicitacao = new TbSolicitacao();

$dados = $tbsolicitacao->getFormAssentamento(base64_decode($_SESSION['valorform']));


?>

<form name="cadastrar/Assentamento" id="Assentamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
<fieldset>
	<legend><b>Assentamento</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Descri��o do Chamado:</th>
      <td>
      	<?php echo($dados[1]); ?>
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Assentamento:</th>
      <td>
      <textarea name="ass_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/Assentamento']['ass_descricao']); ?></textarea> 
      <input type="hidden" name="sol_codigo" value="<?php echo($dados[0]); ?>">	
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status do Chamado:</th>
      <td>
      <?php 
      	$tbstatus = new TbStatus();
      	FormComponente::selectOption('sta_codigo', $tbstatus->selectStatusNaoAberto(),false,$dados[2]);
      ?>
	  </td>
    </tr>    
    <tr>
      <th nowrap="nowrap">Atendente do Chamado:</th>
      <td>
      <?php 
      	$tbatendente = new TbAtendenteSolicitacao();
      	$atendente = $tbatendente->getNomeAtendente($dados[0]);
    
      	$tbusuario = new TbUsuario();
      		#Verifica se h� um atendente e n�o houver, � mostrado o $name
      		#Caso contrario lista os nomes sem o $name
     	  	if($atendente)
   			{$valor = false;}
   			else
   			{FormComponente::$name = 'N�o h� atendentes';
   			$valor = true;}
      	FormComponente::selectOption('usu_codigo_atendente',$tbusuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']),$valor,$atendente);
      
      ?>
	  </td>
    </tr>
    
        <tr>
		    <th nowrap="nowrap">Enviar e-mail para:</th>
		    	<td nowrap="nowrap"> 
		    		Departamento Atendente: <input type="checkbox" name="Departamento" checked="checked" value="1" >
		    		|
		    		Usu�rio Solicitante: <input type="checkbox" name="Solicitante" checked="checked" value="1" >
		    	</td>
    	</tr>    
            
    <tr>
      <td colspan="2" align="left">
			&nbsp;
	  </td>
	</tr>
	<tr>
      <td colspan="2" align="left">
	      <input type="submit" name="alterar" class="button-tela" value=" Salvar " />
	  </td>
    </tr>
  </table>
</form>
<hr>
  	<?php 
  	
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($dados[0]);
	
	  	$cabecalho = array('Descri��o','Data','Editor');
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Assentameto(s)';
	  	$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 </fieldset>
<?php 
unset($_SESSION['cadastrar/Assentamento']);?>