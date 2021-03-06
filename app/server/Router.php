<?php namespace app\server;
	class Router
	{
		protected static $params   = array();
		protected static $folder;
		protected static $notFound = true;

		private static function compareParams($URI, $endPoint)
		{
			//valida os parametros não dinamicos
			foreach( $endPoint as $key => $u )
			{
				//se o respectivo parâmetro não é dinamico, vou testa-lo com outro array no mesmo índice
				if( !strstr($u,'{') )
				{
					//se a string for diferente estando na mesma posição, não é o endpoint correto
					if( $URI[$key] !== $endPoint[$key] ) return false;
				}
			}
			//se chegar aqui, quer dizer que os parametros não dinâmicos são iguais nas mesmas posições dos dois arrays
			return true;
		}

		//percorre os parametros dinamicos e coloca o valor passado, dentro de self:params
		private static function mountParamsDinamic($URI, $endPoint)
		{
			foreach( $endPoint as $key => $u )
			{
				if( strstr($u,'{') )
				{
					self::$params[substr( $u, 1, -1 )] = urldecode( $URI[$key] );
				}
			}
		} 

		private static function testURI($endPoint, $_callback)
		{		
			$dir = str_replace("\app\server", "", __DIR__);
			//recupera o nome do dirroot, pois esta na uri
			self::$folder = "/".basename($dir);
			

			//removo a folder root da uri
			$URI = str_replace(self::$folder, "", $_SERVER ['REQUEST_URI']);

			//criando os array's
			$arrURI      = explode("/", $URI);
			$arrEndPoint = explode("/", $endPoint);

			//preciso medir o tamanho da uri atual e do endpoint desejado
			$sizeURI      = count( $arrURI );
			$sizeEndPoint = count( $arrEndPoint );

			//são do mesmo tamanho e os parametros não dinamicos são iguais?
			if( $sizeURI == $sizeEndPoint and self::compareParams($arrURI, $arrEndPoint) )
			{
				//se chegar aqui, quer dizer que o endpoint é válido
				//basta devolver os parametros dinamicos e chamar o callback
				self::mountParamsDinamic($arrURI, $arrEndPoint);
				self::$notFound = false;

				//se o metodo for put, add o fluxo de entrada no array de parâmetros da classe
				if($_SERVER['REQUEST_METHOD'] == "PUT") 
				{
					$arrayPut = array();
					parse_str(file_get_contents("php://input"), $arrayPut);
					foreach($arrayPut as $key => $value)
					{
						self::$params[$key] = $value;
					}
				}
				//converte o array de parâmetro para objeto
				self::$params   = (object) self::$params;
				call_user_func($_callback, self::$params);
			}
		}

 		public static function get($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "GET" )self::testURI($_url, $_callback);
		}

		public static function post($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "POST" )self::testURI($_url, $_callback);
		}

		public static function put($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "PUT" )self::testURI($_url, $_callback);
		}

		public static function delete($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "DELETE" )self::testURI($_url, $_callback);
		}
		
		public static function getJson()
		{
			$input  = file_get_contents("php://input");
			return json_decode($input);
		}

		public static function notFound( $_callback )
		{
			if( self::$notFound === true )call_user_func($_callback, null);
		}

	    public static function View( $_tpl, $_flags=null )
	    {
			if($_flags == null)
				echo file_get_contents($_tpl);
			else
				echo str_replace(array_keys($_flags), array_values($_flags), file_get_contents($_tpl) );
		}	
		
		public static function dev()
		{
			error_reporting(E_ALL);
			ini_set("display_errors", 1);
		}
	}
?>
