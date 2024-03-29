<?php
class Email extends PHPMailer
{

	public $mensagem;
	public $cabecalho;

	public $erro;

	public function enviarEmail()
	{
		date_default_timezone_set('America/Sao_Paulo');

		$this->IsSMTP();
		$this->IsHTML();

		$this->Host = '172.22.0.31';
/*
		$this->Port = 25;
		$this->SMTPAuth = true;
		$this->Username = 'marcio.santos@ceadis.org.br';
		$this->Password = 'q1w2e3mrs3';
		$this->IsHTML(true);
*/
		$this->From = 'sga@ceadis.org.br';

		$this->FromName = 'SISTEMA DE GEST�O DE ATIVIDADES';


		$this->Subject = $this->cabecalho;

		$this->Body = $this->mensagem;

		$this->Send();

		$this->erro = $this->ErrorInfo;

	}


	public function setMensagem($mensagem)
	{
		$this->mensagem = $mensagem;
	}

	public function setCabecalho($cabecalho)
	{
		$this->cabecalho = $cabecalho;
	}

	public function aberturaChamado($dados)
	{
		$tbusuario = new TbUsuario();
		$email = $tbusuario->getUsuario($dados['usu_codigo_solicitante']);

		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($dados['dep_codigo_solicitado']);

		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($dados['pro_codigo']);

				
		$this->cabecalho = 'Abertura de Chamado: '.$dados['sol_codigo'];

		$this->mensagem = 'O Chamado de n�mero: '.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= 'Foi aberto com sucesso por: '.$email['usu_email'].' e logo um t�cnico ir� atende-lo <br/>';
		$this->mensagem .= 'Contato:  '.$email['usu_nome'].' - Tel / '.$_SESSION['config']['ramal'].': '.$email['usu_ramal'].'<br/>';
		$this->mensagem .= $_SESSION['config']['problema'].': '.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= 'Descri��o do '.$_SESSION['config']['problema'].': '.$dados['sol_descricao_solicitacao'].'<br/>';
		
		
		#E-mail de envido do usuario
		if($dados['Solicitante'])
		{
			$this->AddAddress($email['usu_email']);
		}
		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}

		$this->enviarEmail();

	}

	public function interacaoAssentamento($dados)
	{

		#Instancia da Classe TbSolicitacao
		$tbsolcitacao = new TbSolicitacao();

		#pega o c�digo do solicitante do chamado
		$usuSolicitante = $tbsolcitacao->getUsuarioSolicitante($dados['sol_codigo']);
		
		#Pego e-mail de quem fez o assentamento informa��es do usuarios
		$tbusuario = new TbUsuario();
		$email = $tbusuario->getUsuario($dados['usu_codigo']);
		
		#Pegao o e-mail do solicitante
		$emailSolicitante = $tbusuario->getUsuario($usuSolicitante);

		#Pego informacoes da solicitacao, Codigo do problema
		#Pego o codigo do problema
		$pro_codigo = $tbsolcitacao->getProblema($dados['sol_codigo']);
		#Pego o codigo do DEPTO solicitado
		$dep_codigo_solicitado = $tbsolcitacao->getCodigoDepartamentoSolicitado($dados['sol_codigo']);

		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($dep_codigo_solicitado);

		#Pego a descri��o do problema
		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($pro_codigo);

		$tbstatus = new TbStatus();
		$sta_descricao = $tbstatus->getDescricao($dados['sta_codigo']);

		$this->cabecalho = 'Assentamento do chamado: '.$dados['sol_codigo'];

		$this->mensagem = 'Houve uma intera��o no chamado: '.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= 'Assentamento criado por: '.$email['usu_email'].'<br/>';
		$this->mensagem .= $_SESSION['config']['problema'].': '.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= 'Foi adicionado o seguinte assentamento: '.$dados['ass_descricao'].'<br/><br/>';
		$this->mensagem .= 'Status do chamado: '.$sta_descricao;
		
		
		#E-mail de envido do usuario
		if($dados['Solicitante'])
		{
			$this->AddAddress($emailSolicitante['usu_email']);
		}
		
		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}
		
		$this->enviarEmail();

	}


}
