<?php

class TbProjeto extends Banco
{

	private $tabela = 'tb_projeto';

	private $pro_codigo = 'pro_codigo';
	private $pro_cod_projeto = 'pro_cod_projeto';
	private $pro_titulo = 'pro_titulo';
	private $usu_codigo_solicitante = 'usu_codigo_solicitante';
	private $pro_previsao_inicio = 'pro_previsao_inicio';
	private $pro_previsao_fim = 'pro_previsao_fim';
	private $stp_codigo = 'stp_codigo';
	private $pro_descricao = 'pro_descricao';
	private $usu_codigo_criador = 'usu_codigo_criador';
	private $pro_data_cadastro = 'pro_data_cadastro';
	private $dep_codigo = 'dep_codigo';


	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->pro_cod_projeto, $this->pro_titulo, $this->usu_codigo_solicitante, $this->pro_previsao_inicio, 
					$this->pro_previsao_fim, $this->stp_codigo, $this->pro_descricao, $this->usu_codigo_criador, $this->dep_codigo)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
						
					$this->usu_codigo_criador = $_SESSION['usu_codigo'];


					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_cod_projeto],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->pro_titulo],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
						$stmt->bindParam(4,$dados[$this->pro_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->pro_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(6,$dados[$this->stp_codigo],PDO::PARAM_INT);
						$stmt->bindParam(7,$dados[$this->pro_descricao],PDO::PARAM_STR);
						$stmt->bindParam(8,$this->usu_codigo_criador,PDO::PARAM_INT);
						$stmt->bindParam(9,$dados[$this->dep_codigo],PDO::PARAM_INT);						
							
						$stmt->execute();

						$this->pro_codigo = $this->conexao->lastInsertId();

						return($this->pro_codigo);

					}
					catch (PDOException $e)
					{
						throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
					}

	}

	public function codigoProjeto()
	{
		$query = ("SELECT max($this->pro_codigo) 
					FROM $this->tabela");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();
			$valor = $stmt->fetch();
			
			$ano = date("Y");
			$mes = date("m");
			$dia = date("d");

			$codigo_projeto = $ano.$mes."00".$valor[0];

			return($codigo_projeto);
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function selectMeusProjetosAndamento($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 2");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosCancelados($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 3");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosConcluidos($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 4");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosAprovacao($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 1");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function aprovarProjeto($dados)
	{
		$query = ("UPDATE $this->tabela
						SET $this->stp_codigo = ? 
						WHERE $this->pro_codigo = ? ");
		$dados['stp_codigo'] = 2;

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1, $dados['stp_codigo'], PDO::PARAM_INT);
			$stmt->bindParam(2, $dados['pro_codigo'], PDO::PARAM_INT);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function listarProjeto($dados)
	{
		$query = ("SELECT pro_codigo, pro_cod_projeto, pro_titulo,
			        	(SELECT usu_nome FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante) AS Usuario,
			        	date_format(pro_previsao_inicio,'%d/%m/%Y') AS pro_previsao_inicio, 
			        	date_format(pro_previsao_fim,'%d/%m/%Y') AS pro_previsao_fim,
			        	(SELECT stp_descricao FROm tb_status_projeto WHERE stp_codigo = PRO.stp_codigo) AS stp_descricao
					FROM tb_projeto AS PRO
					WHERE stp_codigo LIKE ?
					AND pro_titulo LIKE ?
					AND pro_descricao LIKE ?
					AND dep_codigo = ?
					ORDER BY 1 DESC"
					);

					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->execute(array("{$dados[$this->stp_codigo]}",
								 			"%{$dados[$this->pro_titulo]}%",
								 			"%{$dados[$this->pro_descricao]}%",
								  			 "{$dados[$this->dep_codigo]}"
											 )
									   );

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(),$e->getCode());
					}
	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->pro_titulo = ?,
					$this->usu_codigo_solicitante = ?,
					$this->pro_previsao_inicio = ?,
					$this->pro_previsao_fim = ?,
					$this->stp_codigo = ?,
					$this->pro_descricao = ?
					
					WHERE $this->pro_codigo = ? ");
						
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_titulo],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->pro_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->pro_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->stp_codigo],PDO::PARAM_INT);
						$stmt->bindParam(6,$dados[$this->pro_descricao],PDO::PARAM_STR);
						$stmt->bindParam(7,$dados[$this->pro_codigo],PDO::PARAM_INT);
							
						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(),$e->getCode());
					}

	}

	public function getFormAlteracao($pro_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getStatusProjeto($pro_codigo)
	{
		$query = ("SELECT $this->stp_codigo 
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados[0]);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarProjetoAtivo($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE stp_codigo = 2
					AND dep_codigo = ?
					ORDER BY pro_titulo");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Utilizado na tela de pesquisar Atividade
	public function listarProjetoTodos($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE stp_codigo != 1
					AND dep_codigo = ?
					ORDER BY pro_titulo
				 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarProjetoAlteracaoAtividade($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE stp_codigo != 1
					AND dep_codigo = ?
					ORDER BY 1 DESC
				 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Usado no Painel de Projetos
	public function listarProjetosPainel($dados)
	{
		
		$query = ("SELECT pro_codigo, pro_titulo FROM tb_projeto
					WHERE dep_codigo = ?
					AND stp_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$dados[$this->dep_codigo]}",
					 			 "{$dados[$this->stp_codigo]}"
								 )
						   );

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	#Usado no Painel de Projetos
	public function totalProjetosPainel($dados)
	{
		
		$query = ("SELECT count(pro_codigo) 
					FROM tb_projeto
					WHERE dep_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$dados[$this->dep_codigo]}"
								 )
						   );

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	
}
?>