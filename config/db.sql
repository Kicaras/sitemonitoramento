create table categorias(
	cod int primary key,
	descricao varchar(20)
);

create table veiculo(
	placa varchar(10) primary key,
	chassi varchar(40) not null,
	categoria int,
	tara varchar(20),
	anofabricacao varchar(20),
	anomodelo varchar(20),
	meslicenciamento varchar(20),
	statuslicenciamento int,
	constraint fk_veicu_cate foreign key(categoria) references categorias(cod)	
);

create table morotista(
	cpf varchar(20) primary key,
	nome varchar(200) not null,
	agregado int,
	moip int,
	email varchar(200)
);

create table cargas(
	cod int primary key,
	placa_veiculo varchar(10) not null,
	cpf_motorista varchar(12) not null,
	destino varchar(20) not null,
	inicio varchar(20) not null,
	status int,
	constraint fk_carga_moto foreign key(cpf_motorista) references motorista(cpf)
);

create table seguimento(
	cod int primary key,
	descricao varchar(200)
);

create table empresas(
	cnpj varchar(20) not null primary key,
	nome varchar(100) not null,
	seguimento int,
	constraint fk_segui foreign key(seguimento) references seguimento(cod)
);

create table cnh(
	cod int primary key,
	vencimento  varchar(20) not null,
	numregistro varchar(50) not null,
	categoria varchar(5),
	motorista varchar(20),
	constraint fk_cnh_moto foreign key(motorista) references motorista(cpf)
);

create table telefones(
	cod int primary key,
	numero varchar(50) not null,
	entidade varchar(20) not null 
);

create table categoriaocorrencias(
	cod int primary key,
	descricao varchar(50)
);

create table ocorrencias(
	tipo int primary key,
	relatorio varchar(300),
	date_time date,
	carga int,
	constraint fk_ocor_tipo foreign key(tipo) references categoriaocorrencias(cod),
	constraint fk_ocor_carg foreign key(carga) references cargas(cod)
);

create table enderecos(
	rua varchar(100) not null,
	numero varchar(8) not null,
	bairro varchar(100) not null,
	cidade  varchar(100) not null,
	estado varchar(2) not null,
	cep varchar(100) not null,
	entidade varchar(20) not null
);








