<?php
/**
 * Modelo Conselheiro
 * @author Equipe RUP - Politec
 * @since 29/03/2010
 * @version 1.0
 * @package application
 * @subpackage application.models
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */

class Conselheiro extends Zend_Db_Table
{
	protected $_name = 'AGENTES.dbo.Agentes'; // nome da tabela



	/**
	 * M�todo para buscar proponentes
	 * @access public
	 * @param integer $id (c�digo do proponente)
	 * @param string $cpf (cpf do proponente)
	 * @return object $db->fetchAll($sql)
	 */
	public static function buscar($id = null, $cpf = null)
	{
		$sql = "SELECT A.idAgente, ";
		$sql.= "	A.CNPJCPF CPF, ";
		$sql.= "	N.Descricao Nome, ";
		$sql.= "	E.Cep CEP, ";
		$sql.= "	E.UF, ";
		$sql.= "	U.Sigla dsUF, ";
		$sql.= "	E.Cidade, ";
		$sql.= "	M.Descricao dsCidade, ";
		$sql.= "	E.TipoEndereco, ";
		$sql.= "	VE.Descricao dsTipoEndereco, ";
		$sql.= "	E.TipoLogradouro, ";
		$sql.= "	VL.Descricao dsTipoLogradouro, ";
		$sql.= "	E.Logradouro, ";
		$sql.= "	E.Numero, ";
		$sql.= "	E.Complemento, ";
		$sql.= "	E.Bairro, ";
		$sql.= "	T.stTitular, ";
		$sql.= "	E.Divulgar DivulgarEndereco, ";
		$sql.= "	E.Status EnderecoCorrespondencia, ";
		$sql.= "	T.cdArea, ";
		$sql.= "	SA.Descricao dsArea, ";
		$sql.= "	T.cdSegmento, ";
		$sql.= "	SS.Descricao dsSegmento ";
		$sql.= "FROM AGENTES.dbo.Agentes A, ";
		$sql.= "	AGENTES.dbo.Nomes N, ";
		$sql.= "	AGENTES.dbo.EnderecoNacional E, ";
		$sql.= "	AGENTES.dbo.Municipios M, ";
		$sql.= "	AGENTES.dbo.UF U, ";
		$sql.= "	AGENTES.dbo.Verificacao VE, ";
		$sql.= "	AGENTES.dbo.Verificacao VL, ";
		$sql.= "	AGENTES.dbo.tbTitulacaoConselheiro T, ";
		$sql.= "	AGENTES.dbo.Visao V, ";
		$sql.= "	SAC.dbo.Area SA, ";
		$sql.= "	SAC.dbo.Segmento SS ";
		$sql.= "WHERE V.idAgente = A.idAgente ";
		$sql.= "	AND V.Visao = 210 ";
		$sql.= "	AND N.idAgente = A.idAgente ";
		$sql.= "	AND E.idAgente = A.idAgente ";
		$sql.= "	AND VE.idVerificacao = E.TipoEndereco ";
		$sql.= "	AND VL.idVerificacao = E.TipoLogradouro ";
		$sql.= "	AND U.idUF = E.UF ";
		$sql.= "	AND M.idMunicipioIBGE = E.Cidade ";
		$sql.= "	AND T.idAgente = A.idAgente ";
		$sql.= "	AND SA.Codigo = T.cdArea ";
		$sql.= "	AND SS.Codigo = T.cdSegmento ";

		if (!empty($id)) // busca pelo id
		{
			$sql.= "AND A.idAgente = '" . $id . "' ";
		}
		if (!empty($cpf)) // busca pelo cpf
		{
			$sql.= "AND A.CNPJCPF = '" . $cpf . "' ";
		}

		$sql.= "ORDER BY N.Descricao;";

		try
		{
			$db  = Zend_Registry::get('db');
			$db->setFetchMode(Zend_DB::FETCH_OBJ);
		}
		catch (Zend_Exception_Db $e)
		{
			$this->view->message = "Erro ao buscar Proponente: " . $e->getMessage();
		}

		return $db->fetchAll($sql);
	} // fecha buscar();

	
	public function alterar($sql = array (), $cond) {
            $db = Zend_Registry :: get('db');
            $db->setFetchMode(Zend_DB :: FETCH_OBJ);
            $n = $db->update('pessoa', $sql, $cond);
            $db->closeConnection();
            Return $n;
        }  
	

	/**
	 * M�todo para cadastrar proponentes
	 * @access public
	 * @param datatype paramname
	 * @return datatype description
	 */
	public static function cadastrar()
	{
		
	} // fecha cadastrar()



	/**
	 * M�todo para alterar proponentes
	 * @access public
	 * @param datatype paramname
	 * @return datatype description
	 */
	public function alteraConselheiro($tabela, $dados, $id){
			$conselheiro = new Conselheiro();
			
			$db = Zend_Registry :: get('db');
			
			$db->setFetchMode(Zend_DB :: FETCH_OBJ);
			
			// Update tabela  Nomes
			$where = "idAgente =".$id;
			$n = $db->update($tabela, $dados, $where);
			$db->closeConnection();
			
	}
	
	


	/**
	 * M�todo para excluir proponentes
	 * @access public
	 * @param datatype paramname
	 * @return datatype description
	 */
	public static function excluir()
	{
		
	} // fecha excluir()

        public static function consultarNomeAgente($cnpjcpf) {

            $sql = "select agentes.idAgente,
                            agentes.CNPJCPF,
                            agentes.CNPJCPFSuperior,
                            agentes.TipoPessoa,
                            agentes.DtCadastro,
                            agentes.DtAtualizacao,
                            agentes.DtValidade,
                            agentes.Status,
                            agentes.Usuario,
                            nomes.idNome,
                            nomes.idAgente,
                            nomes.TipoNome,
                            nomes.Descricao,
                            nomes.Status,
                            nomes.Usuario
                    from AGENTES.dbo.Agentes agentes
                    inner join AGENTES.dbo.Nomes nomes
                    on agentes.idAgente = nomes.idAgente
                    where agentes.CNPJCPF = '{$cnpjcpf}'";
            try {
                $db = Zend_Registry::get('db');
                $db->setFetchMode(Zend_DB::FETCH_ASSOC);
                return $db->fetchAll($sql);
            } catch (Zend_Exception_Db $e) {
                $this->view->message = "Erro ao buscar Nome de Agente: " . $e->getMessage();
            }
        }
} // fecha class