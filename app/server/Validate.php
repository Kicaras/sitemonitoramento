<?php  namespace app\server; 

	class Validate
	{
		/**
		 * RETORNA UM JWT PARA COMPARAR, VALIDAR
		 * Retorna Obj JSON
		 */
/* EX:
	{
	"payload": {
		"username": "soriano"
	},
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InNvcmlhbm8ifQ==.0lZCTSxokRm5dYf7eo1IuJoBl4YzMfYx5flhjJNniRo="
	}
*/
		public static function Jwt($payload)
		{
			$key       = 'soriano.dev';
			$header    = array('typ'  => 'JWT','alg'  => 'HS256');
			$header    = json_encode($header);
			$header    = base64_encode($header);
			$dados     = json_encode($payload);
			$dados     = base64_encode($dados);
			$signature = hash_hmac('sha256', "$header.$dados", $key, true);
			$signature = base64_encode($signature);
			$token     = "$header.$dados.$signature";
			$token     = str_replace("/", "-xx-", $token);
			$token     = str_replace("+", "-ww-", $token);
			return array('payload' => $payload, 'token' => $token );
		}



		/**
		 * VALIDA JWT
		 * return Bool
		 * $credenciais | obj json
		 */
/* EX:
	{
	"payload": {
		"username": "soriano"
	},
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InNvcmlhbm8ifQ==.0lZCTSxokRm5dYf7eo1IuJoBl4YzMfYx5flhjJNniRo="
	}
*/
		public static function validateJwt($credenciais)
		{
			$credenciais =  json_decode( $credenciais );
			return $credenciais->token === json_decode( self::jwt( $credenciais->payload ) )->token;
		}





		/**
		 * Valida email | retorna bool
		 * 
		 */
		public static function Email($_email)
		{
			if (preg_match("/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/", $_email))
				return true;
			else
				return false;
		}
		
		/**
		 * Valida data no formato (dia-mes-ano) ou (dia/mes/ano) | retorna bool
		 * 
		 */
		public static function Data($_data)
		{
			$_data = $cpf = str_replace("-", "/", $_data);
			$_data = explode("/", $_data);
			if (!checkdate($_data[0], $_data[1], $_data[2]))
				return false;
			else
				return true;
		}
		
		/**
		 * Testa conexão com internet | retorna bool
		 * 
		 */
		public static function Conection()
		{
			if (!$sock = @fsockopen('www.google.com.br', 80, $num, $error, 5))
				return false;
			else
				return true;
		}
		
		/**
		 * Recebe uma string e um modelo de mascara, então retorna a string com a mascara
		 * 
		 */
		public static function setMask($val, $mask)
		{
			$maskared = '';
			$k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++)
			{
				if($mask[$i] == '#')
				{
					if(isset($val[$k]))
					$maskared .= $val[$k++];
				}
				else
				{
					if(isset($mask[$i]))
					$maskared .= $mask[$i];
				}
			}
			return $maskared;
		}


	
		/**
		 * Valida CNPJ
		 * @param string $cnpj 
		 * @return bool true para CNPJ correto
		 */
		public static function Cnpj ( $cnpj ) {
			// Deixa o CNPJ com apenas números
			$cnpj = preg_replace( '/[^0-9]/', '', $cnpj );

			// Garante que o CNPJ é uma string
			$cnpj = (string)$cnpj;

			// O valor original
			$cnpj_original = $cnpj;

			// Captura os primeiros 12 números do CNPJ
			$primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );

			/**
			 * Multiplicação do CNPJ
			 * @param string $cnpj Os digitos do CNPJ
			 * @param int $posicoes A posição que vai iniciar a regressão
			 * @return int O
			 */
			if ( ! function_exists('multiplica_cnpj') ) {
				function multiplica_cnpj( $cnpj, $posicao = 5 ) {
					// Variável para o cálculo
					$calculo = 0;
					
					// Laço para percorrer os item do cnpj
					for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
						// Cálculo mais posição do CNPJ * a posição
						$calculo = $calculo + ( $cnpj[$i] * $posicao );
						
						// Decrementa a posição a cada volta do laço
						$posicao--;
						
						// Se a posição for menor que 2, ela se torna 9
						if ( $posicao < 2 ) {
							$posicao = 9;
						}
					}
					// Retorna o cálculo
					return $calculo;
				}
			}

			// Faz o primeiro cálculo
			$primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );

			// Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
			// Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
			$primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );

			// Concatena o primeiro dígito nos 12 primeiros números do CNPJ
			// Agora temos 13 números aqui
			$primeiros_numeros_cnpj .= $primeiro_digito;

			// O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
			$segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
			$segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );

			// Concatena o segundo dígito ao CNPJ
			$cnpj = $primeiros_numeros_cnpj . $segundo_digito;

			// Verifica se o CNPJ gerado é idêntico ao enviado
			if ( $cnpj === $cnpj_original ) {
				return true;
			}
		}


		
		/**
		 * Valida CPF
		 * @param string $cpf O CPF com ou sem pontos e traço
		 * @return bool True para CPF correto - False para CPF incorreto
		 */
		public static function Cpf( $cpf = null ) {
			if(empty($cpf))return false;
			
			// Elimina possivel mascara
			$cpf = trim($cpf);
			$cpf = str_replace(".", "", $cpf);
			$cpf = str_replace(",", "", $cpf);
			$cpf = str_replace("-", "", $cpf);
			$cpf = str_replace("/", "", $cpf);
			 
			// Verifica se o numero de digitos informados é igual a 11 
			if (strlen($cpf) != 11)return false;

			
			
			// Verifica se nenhuma das sequências invalidas abaixo 
			// foi digitada. Caso afirmativo, retorna falso
			if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
				return false;
			else{   
				 // Calcula os digitos verificadores para verificar se o
				 // CPF é válido
				for ($t = 9; $t < 11; $t++) {
					for ($d = 0, $c = 0; $c < $t; $c++) {
						$d += $cpf{$c} * (($t + 1) - $c);
					}
					$d = ((10 * $d) % 11) % 10;
					if ($cpf{$c} != $d)return false;
				}
				return true;
			}
		}
	}
?>	