<?php
//headers
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	header('Access-Control-Allow-Origin: *');

	require_once('./vendor/autoload.php');
	use app\server\Router;
	use app\server\Upload;
	use app\server\Validate;
	use app\server\Conn;

	// NOME DA PASTA DO PROJETO | CASO ESTIVER NA RAIZ DO SERVER, NÃO DEFINIR O MÉTODO.
	Router::dirRoot("sitemonitoramento"); 

//TEMPLATES
	Router::get('/', function(){
		Router::View("./app/client/templates/home.html");
	});

	function saveEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $entidade)
	{
		$stmt = Conn::getConn()->prepare("insert into endereco values( ?, ?, ?, ?, ?, ?, ? )");
		$stmt->bindParam(1, $rua);
		$stmt->bindParam(2, $numero);
		$stmt->bindParam(3, $bairro);
		$stmt->bindParam(4, $cidade);
		$stmt->bindParam(5, $estado);
		$stmt->bindParam(6, $cep);
		$stmt->bindParam(7, $entidade);
		return $stmt->execute();
	}

	function updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $entidade)
	{
		$stmt = Conn::getConn()->prepare(" update endereco set rua=?, numero=?, bairro=?, cidade=?, estado=?, cep=? where entidade=? ");
		$stmt->bindParam(1, $rua);
		$stmt->bindParam(2, $numero);
		$stmt->bindParam(3, $bairro);
		$stmt->bindParam(4, $cidade);
		$stmt->bindParam(5, $estado);
		$stmt->bindParam(6, $cep);
		$stmt->bindParam(7, $entidade);
		return $stmt->execute();
	}

//CRUD DE MOTORISTAS
	Router::get('/motoristas/:cpf', function($data){
		$stmt = Conn::getConn()->prepare("select * from motoristas where cpf=?")->fetch(PDO::FETCH_OBJ);
		$stmt->bindParam(1, $data['cpf']);
		echo json_encode( $stmt->execute() );
	});

	Router::get('/motoristas', function(){
		echo json_encode(Conn::getConn()->query("select * from motoristas")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/motoristas', function(){
		$stmt = Conn::getConn()->prepare("insert into motoristas values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $_POST['cpf']);
		$stmt->bindParam(2, $_POST['nome']);
		$stmt->bindParam(3, $_POST['agregado']);
		$stmt->bindParam(4, $_POST['moip']);
		$stmt->bindParam(5, $_POST['email']);
		$stmt->bindParam(6, $_POST['vencimento_cnh']);
		$stmt->bindParam(7, $_POST['numregistro_cnh']);
		$stmt->bindParam(8, $_POST['categoria_cnh']);
		$stmt->bindParam(9, $_POST['fone1']);
		$stmt->bindParam(10,$_POST['fone2']);

		saveEndereco($_POST['rua'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'], $_POST['cpf']);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/motoristas', function($put){
		$stmt = Conn::getConn()->prepare("update motoristas set nome=?, agregado=?, moip=?, email=?, vencimento_cnh=?, numregistro_cnh=?, categoria_cnh=?,  fone1=?, fone2=? where cpf=?");
		$stmt->bindParam(1, $put['nome']);
		$stmt->bindParam(2, $put['agregado']);
		$stmt->bindParam(3, $put['moip']);
		$stmt->bindParam(4, $put['email']);
		$stmt->bindParam(5, $put['vencimento_cnh']);
		$stmt->bindParam(6, $put['numregistro_cnh']);
		$stmt->bindParam(7, $put['categoria_cnh']);
		$stmt->bindParam(8, $put['fone1']);
		$stmt->bindParam(9, $put['fone2']);
		$stmt->bindParam(10, $put['cpf']);

		updateEndereco($put['rua'], $put['numero'], $put['bairro'], $put['cidade'], $put['estado'], $put['cep'], $put['cpf']);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/motoristas/:cpf', function($delete){
		$stmt = Conn::getConn()->prepare("delete from motoristas where cpf=?");
		$stmt->bindParam(1, $delete['cpf']);
		echo $stmt->execute() ? 200 : 501;
	});




//CRUD DE VEICULOS
	Router::get('/veiculos', function(){
		echo json_encode(Conn::getConn()->query("select * from veiculos")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/veiculos', function(){
		$stmt = Conn::getConn()->prepare("insert into veiculos values( ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $_POST['placa']);
		$stmt->bindParam(2, $_POST['chassi']);
		$stmt->bindParam(3, $_POST['categoria']);
		$stmt->bindParam(4, $_POST['tara']);
		$stmt->bindParam(5, $_POST['anofabricacao']);
		$stmt->bindParam(6, $_POST['anomodelo']);
		$stmt->bindParam(7, $_POST['meslicenciamento']);
		$stmt->bindParam(8, $_POST['statuslicenciamento']);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/veiculos', function($put){
		$stmt = Conn::getConn()->prepare("update veiculos set chassi=?, categoria=?, tara=?, anofabricacao=?, anomodelo=?, meslicenciamento=?, statuslicenciamento=? where placa=?");

		$stmt->bindParam(1, $put['chassi']);
		$stmt->bindParam(2, $put['categoria']);
		$stmt->bindParam(3, $put['tara']);
		$stmt->bindParam(4, $put['anofabricacao']);
		$stmt->bindParam(5, $put['anomodelo']);
		$stmt->bindParam(6, $put['meslicenciamento']);
		$stmt->bindParam(7, $put['statuslicenciamento']);
		$stmt->bindParam(8, $put['placa']);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/veiculos/:placa', function($delete){
		$stmt = Conn::getConn()->prepare("delete from veiculos where placa=?");
		$stmt->bindParam(1, $delete['placa']);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE CATEGORIAS de VEICULOS
	Router::get('/categoriasveiculo', function(){
		echo json_encode(Conn::getConn()->query("select * from categoriasveiculo")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/categoriasveiculo', function(){
		$stmt = Conn::getConn()->prepare("insert into categoriasveiculo values( null, ? )");
		$stmt->bindParam(1, $_POST['descricao']);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/categoriasveiculo/:cod', function($delete){
		$stmt = Conn::getConn()->prepare("delete from categoriasveiculo where cod=?");
		$stmt->bindParam(1, $delete['cod']);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE CARGAS
	Router::get('/cargas', function(){
		echo json_encode(Conn::getConn()->query("select * from cargas")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/cargas', function(){
		$stmt = Conn::getConn()->prepare("insert into cargas values( null, ?, ?, ?, ?, ? )");
		$stmt->bindParam(1, $_POST['placa_veiculo']);
		$stmt->bindParam(2, $_POST['cpf_motorista']);
		$stmt->bindParam(3, $_POST['destino']);
		$stmt->bindParam(4, $_POST['inicio']);
		$stmt->bindParam(5, $_POST['status']);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/cargas', function($put){
		$stmt = Conn::getConn()->prepare("update cargas set placa_veiculo=?, cpf_motorista=?, destino=?, inicio=?, status=? where cod=?");
		$stmt->bindParam(1, $put['placa_veiculo']);
		$stmt->bindParam(2, $put['cpf_motorista']);
		$stmt->bindParam(3, $put['destino']);
		$stmt->bindParam(4, $put['inicio']);
		$stmt->bindParam(5, $put['status']);
		$stmt->bindParam(6, $put['cod']);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/cargas/:cod', function($delete){
		$stmt = Conn::getConn()->prepare("delete from cargas where cod=?");
		$stmt->bindParam(1, $delete['cod']);
		echo $stmt->execute() ? 200 : 501;
	});




//CRUD DE OCORRENCIAS
	Router::get('/ocorrencias', function(){
		echo json_encode(Conn::getConn()->query("select * from ocorrencias")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/ocorrencias', function(){
		$stmt = Conn::getConn()->prepare("insert into ocorrencias values( null, ?, ?, ?, ? )");
		$stmt->bindParam(1, $_POST['tipo']);
		$stmt->bindParam(2, $_POST['relatorio']);
		$stmt->bindParam(3, $_POST['date_time']);
		$stmt->bindParam(4, $_POST['carga']);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/ocorrencias/:cod', function($delete){
		$stmt = Conn::getConn()->prepare("delete from ocorrencias where cod=?");
		$stmt->bindParam(1, $delete['cod']);
		echo $stmt->execute() ? 200 : 501;
	});


//CRUD CATEGORIA DE OCORRêNCIAS
	Router::get('/categoriaocorrencias', function(){
		echo json_encode(Conn::getConn()->query("select * from categoriaocorrencias")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/categoriaocorrencias', function(){
		$stmt = Conn::getConn()->prepare("insert into categoriaocorrencias values( null, ? )");
		$stmt->bindParam(1, $_POST['descricao']);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/categoriaocorrencias/:cod', function($delete){
		$stmt = Conn::getConn()->prepare("delete from categoriaocorrencias where cod=?");
		$stmt->bindParam(1, $delete['cod']);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD SEGUIMENTOS EMPRESA
	Router::get('/seguimentoempresa', function(){
		echo json_encode(Conn::getConn()->query("select * from seguimentoempresa")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/seguimentoempresa', function(){
		$stmt = Conn::getConn()->prepare("insert into seguimentoempresa values( null, ? )");
		$stmt->bindParam(1, $_POST['descricao']);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/seguimentoempresa/:cod', function($delete){
		$stmt = Conn::getConn()->prepare("delete from seguimentoempresa where cod=?");
		$stmt->bindParam(1, $delete['cod']);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE EMPRESAS
	Router::get('/empresas', function(){
		echo json_encode(Conn::getConn()->query("select * from empresas")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::get('/empresas/:cnpj', function($dados){
		echo json_encode(Conn::getConn()->query("select * from empresas where cnpj=".$dados["cnpj"])->fetch(PDO::FETCH_OBJ));
	});

	Router::post('/empresas', function(){
		$stmt = Conn::getConn()->prepare("insert into empresas values( ?, ?, ? )");
		$stmt->bindParam(1, $_POST['cnpj']);
		$stmt->bindParam(2, $_POST['nome']);
		$stmt->bindParam(3, $_POST['seguimento']);

		saveEndereco($_POST['rua'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'], $_POST['cpf']);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/empresas', function($put){
		$stmt = Conn::getConn()->prepare("update empresas set nome=?, seguimento=? where cnpj=? ");
		$stmt->bindParam(1, $put['nome']);
		$stmt->bindParam(2, $put['seguimento']);
		$stmt->bindParam(3, $put['cnpj']);

		updateEndereco($put['rua'], $put['numero'], $put['bairro'], $put['cidade'], $put['estado'], $put['cep'], $put['cpf']);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/empresas/:cnpj', function($delete){
		$stmt = Conn::getConn()->prepare("delete from empresas where cnpj=?");
		$stmt->bindParam(1, $delete['cnpj']);
		echo $stmt->execute() ? 200 : 501;
	});







//ERROR 404
	Router::notFound(function(){
		Router::View("./app/client/templates/notFound.html");
	});