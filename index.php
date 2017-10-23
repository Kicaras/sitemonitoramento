<?php
	require_once('./vendor/autoload.php');
	use app\server\Router;
	use app\server\Upload;
	use app\server\Validate;
	use app\server\Conn;

	Router::dev();
	header('Access-Control-Allow-Origin: *');

//TEMPLATES
	Router::get('/', function(){
		Router::View("./app/client/templates/home.html");
	});

	function saveEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $entidade)
	{
		$stmt = Conn::getConn()->prepare("insert into enderecos values( ?, ?, ?, ?, ?, ?, ? )");
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
		$stmt = Conn::getConn()->prepare(" update enderecos set rua=?, numero=?, bairro=?, cidade=?, estado=?, cep=? where entidade=? ");
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
	Router::get('/motoristas/{cpf}', function($data){
		$motorista = Conn::getConn()->query("select * from motoristas where cpf=".$data->cpf)->fetch(PDO::FETCH_OBJ);
		$motorista->endereco = Conn::getConn()->query("select rua, numero, bairro, cidade, estado, cep from enderecos where entidade=".$data->cpf)->fetch(PDO::FETCH_OBJ);
		echo json_encode( $motorista );
	});

	Router::get('/motoristas', function(){
		$motoristas = Conn::getConn()->query("select * from motoristas")->fetchAll(PDO::FETCH_OBJ);
		foreach($motoristas as $motorista)
		{
			$motorista->endereco = Conn::getConn()->query("select rua, numero, bairro, cidade, estado, cep from enderecos where entidade=".$motorista->cpf)->fetch(PDO::FETCH_OBJ);
		}
		echo json_encode( $motoristas );
	});

	Router::post('/motoristas', function(){
		$motorista = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into motoristas values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $motorista->cpf);
		$stmt->bindParam(2, $motorista->nome);
		$stmt->bindParam(3, $motorista->agregado);
		$stmt->bindParam(4, $motorista->moip);
		$stmt->bindParam(5, $motorista->email);
		$stmt->bindParam(6, $motorista->vencimento_cnh);
		$stmt->bindParam(7, $motorista->numregistro_cnh);
		$stmt->bindParam(8, $motorista->categoria_cnh);
		$stmt->bindParam(9, $motorista->fone1);
		$stmt->bindParam(10,$motorista->fone2);

		saveEndereco($motorista->endereco->rua, $motorista->endereco->numero, $motorista->endereco->bairro, $motorista->endereco->cidade, $motorista->endereco->estado, $motorista->endereco->cep, $motorista->cpf);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/motoristas', function($put){
		$motorista = Router::getJson();

		$stmt = Conn::getConn()->prepare("update motoristas set nome=?, agregado=?, moip=?, email=?, vencimento_cnh=?, numregistro_cnh=?, categoria_cnh=?,  fone1=?, fone2=? where cpf=?");

		$stmt->bindParam(1, $motorista->nome);
		$stmt->bindParam(2, $motorista->agregado);
		$stmt->bindParam(3, $motorista->moip);
		$stmt->bindParam(4, $motorista->email);
		$stmt->bindParam(5, $motorista->vencimento_cnh);
		$stmt->bindParam(6, $motorista->numregistro_cnh);
		$stmt->bindParam(7, $motorista->categoria_cnh);
		$stmt->bindParam(8, $motorista->fone1);
		$stmt->bindParam(9, $motorista->fone2);
		$stmt->bindParam(10,$motorista->cpf);

		updateEndereco($motorista->endereco->rua, $motorista->endereco->numero, $motorista->endereco->bairro, $motorista->endereco->cidade, $motorista->endereco->estado, $motorista->endereco->cep, $motorista->cpf);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/motoristas/{cpf}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from motoristas where cpf=?");
		$stmt->bindParam(1, $delete->cpf);
		echo $stmt->execute() ? 200 : 501;
	});


//CRUD DE VEICULOS
	Router::get('/veiculos', function(){
		echo json_encode(Conn::getConn()->query("select * from veiculos")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/veiculos', function(){
		$veiculos = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into veiculos values( ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $veiculos->placa);
		$stmt->bindParam(2, $veiculos->chassi);
		$stmt->bindParam(3, $veiculos->categoria);
		$stmt->bindParam(4, $veiculos->tara);
		$stmt->bindParam(5, $veiculos->anofabricacao);
		$stmt->bindParam(6, $veiculos->anomodelo);
		$stmt->bindParam(7, $veiculos->meslicenciamento);
		$stmt->bindParam(8, $veiculos->statuslicenciamento);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/veiculos', function($put){
		$veiculos = Router::getJson();

		$stmt = Conn::getConn()->prepare("update veiculos set chassi=?, categoria=?, tara=?, anofabricacao=?, anomodelo=?, meslicenciamento=?, statuslicenciamento=? where placa=?");

		$stmt->bindParam(1, $veiculos->chassi);
		$stmt->bindParam(2, $veiculos->categoria);
		$stmt->bindParam(3, $veiculos->tara);
		$stmt->bindParam(4, $veiculos->anofabricacao);
		$stmt->bindParam(5, $veiculos->anomodelo);
		$stmt->bindParam(6, $veiculos->meslicenciamento);
		$stmt->bindParam(7, $veiculos->statuslicenciamento);
		$stmt->bindParam(8, $veiculos->placa);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/veiculos/{placa}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from veiculos where placa=?");
		$stmt->bindParam(1, $delete->placa);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE CATEGORIAS de VEICULOS
	Router::get('/categoriasveiculo', function(){
		echo json_encode(Conn::getConn()->query("select * from categoriasveiculo")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/categoriasveiculo', function(){
		$categoriasveiculo = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into categoriasveiculo values( null, ? )");
		$stmt->bindParam(1, $categoriasveiculo->descricao);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/categoriasveiculo/{cod}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from categoriasveiculo where cod=?");
		$stmt->bindParam(1, $delete->cod);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE CARGAS
	Router::get('/cargas', function(){
		echo json_encode(Conn::getConn()->query("select * from cargas")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/cargas', function(){
		$cargas = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into cargas values( null, ?, ?, ?, ?, ?, ? )");
		$stmt->bindParam(1, $cargas->descricao);
		$stmt->bindParam(2, $cargas->placa_veiculo);
		$stmt->bindParam(3, $cargas->cpf_motorista);
		$stmt->bindParam(4, $cargas->destino);
		$stmt->bindParam(5, $cargas->inicio);
		$stmt->bindParam(6, $cargas->status);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/cargas', function($put){
		$cargas = Router::getJson();

		$stmt = Conn::getConn()->prepare("update cargas set descricao=?, placa_veiculo=?, cpf_motorista=?, destino=?, inicio=?, status=? where cod=?");
		$stmt->bindParam(1, $cargas->descricao);
		$stmt->bindParam(2, $cargas->placa_veiculo);
		$stmt->bindParam(3, $cargas->cpf_motorista);
		$stmt->bindParam(4, $cargas->destino);
		$stmt->bindParam(5, $cargas->inicio);
		$stmt->bindParam(6, $cargas->status);
		$stmt->bindParam(7, $cargas->cod);
		
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/cargas/{cod}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from cargas where cod=?");
		$stmt->bindParam(1, $delete->cod);
		echo $stmt->execute() ? 200 : 501;
	});




//CRUD DE OCORRENCIAS
	Router::get('/ocorrencias', function(){
		echo json_encode(Conn::getConn()->query("select * from ocorrencias")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/ocorrencias', function(){
		$ocorrencias = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into ocorrencias values( null, ?, ?, ?, ? )");
		$stmt->bindParam(1, $ocorrencias->tipo);
		$stmt->bindParam(2, $ocorrencias->relatorio);
		$stmt->bindParam(3, $ocorrencias->date_time);
		$stmt->bindParam(4, $ocorrencias->carga);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/ocorrencias/{cod}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from ocorrencias where cod=?");
		$stmt->bindParam(1, $delete->cod);
		echo $stmt->execute() ? 200 : 501;
	});


//CRUD CATEGORIA DE OCORRêNCIAS
	Router::get('/categoriaocorrencias', function(){
		echo json_encode(Conn::getConn()->query("select * from categoriaocorrencias")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/categoriaocorrencias', function(){
		$categoriaocorrencias = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into categoriaocorrencias values( null, ? )");
		$stmt->bindParam(1, $categoriaocorrencias->descricao);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/categoriaocorrencias/{cod}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from categoriaocorrencias where cod=?");
		$stmt->bindParam(1, $delete->cod);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD SEGUIMENTOS EMPRESA
	Router::get('/seguimentoempresa', function(){
		echo json_encode(Conn::getConn()->query("select * from seguimentoempresa")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::post('/seguimentoempresa', function(){
		$seguimentoempresa = Router::getJson();
		$stmt = Conn::getConn()->prepare("insert into seguimentoempresa values( null, ? )");
		$stmt->bindParam(1, $seguimentoempresa->descricao);
		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/seguimentoempresa/{cod}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from seguimentoempresa where cod=?");
		$stmt->bindParam(1, $delete->cod);
		echo $stmt->execute() ? 200 : 501;
	});



//CRUD DE EMPRESAS
	Router::get('/empresas', function(){
		echo json_encode(Conn::getConn()->query("select * from empresas")->fetchAll(PDO::FETCH_OBJ));
	});

	Router::get('/empresas/{cnpj}', function($dados){
		echo json_encode(Conn::getConn()->query("select * from empresas where cnpj=".$dados->cnpj)->fetch(PDO::FETCH_OBJ));
	});

	Router::post('/empresas', function(){
		$empresas = Router::getJson();

		$stmt = Conn::getConn()->prepare("insert into empresas values( ?, ?, ?, ?, ?, ? )");
		$stmt->bindParam(1, $empresas->cnpj);
		$stmt->bindParam(2, $empresas->nome);
		$stmt->bindParam(3, $empresas->seguimento);
		$stmt->bindParam(4, $empresas->email);
		$stmt->bindParam(5, $empresas->fone1);
		$stmt->bindParam(6, $empresas->fone2);

		saveEndereco($empresas->endereco->rua, $empresas->endereco->numero, $empresas->endereco->bairro, $empresas->endereco->cidade, $empresas->endereco->estado, $empresas->endereco->cep, $empresas->cnpj);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::put('/empresas', function($put){
		$empresas = Router::getJson();
		$stmt = Conn::getConn()->prepare("update empresas set nome=?, seguimento=?, email=?, fone1=?, fone2=? where cnpj=? ");
		$stmt->bindParam(1, $empresas->nome);
		$stmt->bindParam(2, $empresas->seguimento);
		$stmt->bindParam(3, $empresas->email);
		$stmt->bindParam(4, $empresas->fone1);
		$stmt->bindParam(5, $empresas->fone2);
		$stmt->bindParam(6, $empresas->cnpj);

		updateEndereco($empresas->endereco->rua, $empresas->endereco->numero, $empresas->endereco->bairro, $empresas->endereco->cidade, $empresas->endereco->estado, $empresas->endereco->cep, $empresas->cnpj);

		echo $stmt->execute() ? 200 : 501;
	});

	Router::delete('/empresas/{cnpj}', function($delete){
		$stmt = Conn::getConn()->prepare("delete from empresas where cnpj=?");
		$stmt->bindParam(1, $delete->cnpj);
		echo $stmt->execute() ? 200 : 501;
	});



//ERROR 404
	Router::notFound(function(){
		Router::View("./app/client/templates/notFound.html");
	});