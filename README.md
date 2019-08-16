
	<h2>INICIANDO</h2>
 
	<hr>
		<h4>Configurações iniciais #1:</h4>
		<p>Para começar a utilizar, primeiro você precisará acessar <code>inc/Connection.class.php</code>, abrir e alterar os dados de dados;</p>
		<pre style="margin-left: 0px;">
			private $host = "localhost";
			private $user = "root";
			private $senha = "minhasenha";
			private $banco = "meubanco";
		</pre>
		<p>Após alterar, salve e pronto! Já está pronto para começar!</p>
	<hr>

	<h4>Configurações Iniciais #2:</h4>
		<p>Agora para utilização de URL Amigável, paginação entre outros, você precisará configurar a <b>base</b>, onde seu site estará acessível. Para editar acesse <code>includes/topo.php</code>, abra e altere a seguinte linha:</p>
		<pre>
			&lt;base href="http://localhost/controller/"&gt;
		</pre>
		<p>Altere o <code>http://localhost/controller/</code> para o url do seu site, sempre mantendo a barra no final afim de evitar erros;</p>
	<hr>

	<h4>CRIAÇÃO DE CLASSES E OBJETOS:</h4>
	<p>Todas as classes e objetos deverão ser criadas dentro do diretório <code>inc/</code> sempre mantendo a primeira letra maiúscula e extensão <b>.class.php</b> no final;
	Ex: <b>Client.class.php</b></p>

	<hr>
	<h4>Views:</h4>
	<p>Todas as views deverão ser criadas dentro do diretório <code>views/</code> com a extensão final <b>.php</b>, não precisa herdar ou ser incluida dentro de nenhum controller ou classe, a menos que queira, podendo ser chamada direto no navegador.<br>
	Ex: criei um arquivo em <b>views/contato.php</b>; agora posso chamar ela na url <code>http://localhost/controller/contato</code></p>

	<hr>
	<h2>FUNÇÕES DE OBJETOS:</h2>
	<hr>

	<h4 style="text-transform: none;">Connection:: <small>A classe Connection contém todos as funções relacionados a consultas ao banco de dados, seja insert, update, delete ...</small></h4>

	<hr>
	<p><b>FUNÇÃO: <code>CONNECTION::QUERY($query,[params])</code></b><br>
	Esta função utiliza o prepare do pdo para realizar consultas do banco de dados, sendo necessário passar dois parâmetros: O primeiro a query e o segundo os parâmetros em um array, caso não tenha, setar como null;
	<pre>
		$con = new Connection();
		$con->query(query, [params]);
	</pre>
	</p>

	<hr>
	<p><b>Exemplo de utilização #1:</b> Selecionando e listando apenas um registro específico utilizando parâmetros:
	<pre>
		//Exemplo de views/meu-perfil.php
		$con = new Connection();
		$dados = $con->query("SELECT * FROM usuarios WHERE id = :id", [':id' => 1]);
		echo $dados['nome']; //Retornará: Thiago Sales
	</pre>
	</p>

	<hr>
	<p><b>Exemplo de utilização #2:</b> Selecionando e listando diversos dados do banco sem parâmetro:
	<pre>
		//Exemplo de: views/posts.php
		&lt;?php
			$con = new Connection();
			$dados = $con->query("SELECT * FROM posts ORDER BY id DESC", null);
		?&gt;

		&lt;?php foreach($dados as $key){ ?&gt;
			&lt;h1&gt;&lt;?php echo $key['titulo'];?&gt;&lt;/h1&gt;
			&lt;p&gt;&lt;?php echo $key['postagem'];?&gt;&lt;/p&gt; 
			&lt;p&gt;&lt;?php echo $key['data'];?&gt;&lt;/p&gt;
			&lt;hr&gt;
		&lt;?php };?&gt;
	</pre>
	</p>

	<hr>
	<p><b>FUNÇÃO: <code>CONNECTION::UPDATE($query, [params])</code></b><br>
	Esta função utiliza o prepare do pdo para alterar registros do banco de dados, sendo necessário passar dois parâmetros: O primeiro a query e o segundo os parâmetros em um array, caso não tenha, setar como null;
	<pre>
		$novo_nome = "Thiago Sales";
		$con = new Connection();
		$con->update("UPDATE usuarios SET nome = :nome WHERE id = :id", [':nome' => $novo_nome, ':id' => 1]);
	</pre>
	</p>

	<hr>
	<p><b>FUNÇÃO: <code>CONNECTION::DELETE($tabela, $coluna, $valor)</code></b><br>
	Esta função utiliza o prepare do pdo para deletar registros do banco de dados, sendo necessário passar três parâmetros: O primeiro a tabela que será efetuado o delete, em segundo a coluna que será comparada e em terceiro o valor que será comparado com a coluna;
	<pre>
		//Exemplo: views/deletar-usuario.php
		$con = new Connection();
		$con->delete("usuarios", "id", 1);

		//Ele simplifica a query:
		-> DELETE FROM usuarios WHERE id = :id
	</pre>
	</p>

	<hr>
	<h4 style="text-transform: none;">Sessions:: <small>A classe Sessions contém duas funções, uma responsável por criar sessões e outra por deletar</small></h4>

	<hr>
	<p><b>FUNÇÃO: <code>SESSIONS::SETSESSIONS($id, $nome, $usuario, $senha)</code></b><br>
	Esta função é utiliza para criar determinadas sessões, seguindo uma ordem de <b>(id, nome, usuario, senha)</b>; Por padrão só adicionamos esses quatro campos, mas a função pode ser editada e inserido diversas outras sessões, conforme o desejado;

	<pre>
		//Exemplo: view/login.php
		$sess = new Sessions();
		$sess->setSessions(id, nome, usuario, senha);

		//Ele preencherá os valores de:
		-> $_SESSION['authId']
		-> $_SESSION['authNome']
		-> $_SESSION['authUsuario']
		-> $_SESSION['authSenha']
	</pre>
	<p>Caso queira apenas trabalhar com uma sessão, nesse exemplo um nome de usuário, você precisará setar o restante como null. Exemplo:</p>
	<pre>
		//Exemplo: view/login.php
		$sess = new Sessions();
		$sess->setSessions(null, null, "thsales061", null);

		//Exibindo em outra página após logar:
		-> echo "Bem vindo: ".$_SESSION['authUsuario']; //Retornará: thsales061
	</pre>
	</p>

	<hr>
	<p><b>FUNÇÃO: <code>SESSIONS::SESSIONDESTROY([$tempo, $url] / null)</code></b><br>
	Esta função é utiliza para destruir todas as sessões e com parâmetros em array de redirecionamento, podendo ser setado um tempo para redirecionamento e uma página</b>;

	<pre>
		$sess = new Sessions();
		$sess->sessionDestroy([params]);
	</pre>

	<hr>
	<p><b>Exemplo #1</b> - Sem redirect</p>
	<pre>
		//Exemplo: view/logout.php - Sem rediret
		$sess = new Sessions();
		$sess->sessionDestroy(null);

		//A função destruirá todas as sessões mas não fará nada, pois nenhum campo foi passado
	</pre>

	<p><b>Exemplo #2</b> - Com Redirect</p>
	<pre>
		//Exemplo: view/logout.php - Sem rediret
		$sess = new Sessions();
		$sess->sessionDestroy([3,'/login']);

		//A função destruirá todas as sessões e após 3 segundo será redirecionará o usuário para a página /login
	</pre>

	<hr>
	<h4 style="text-transform: none;">Utils:: <small>A classe Utils contém algumas funções de utilitários, tais como data, alerta SweetAlert2 e alerta Bootstrap</small></h4>
	<br> 
	Por padrão o <code>date_default_timezone_set('America/Sao_Paulo');</code> está setado como: <b>'America/Sao_Paulo'</b>, podendo ser alterado em <code>inc/Utils.class.php</code>;

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::GetData()</code></b><br>
	Esta função é utiliza para retornar apenas a data no formato <b>d/m/Y</b>;

	<pre>
		$util = new Utils();
		echo $util->getData();

		//Retornará: 16/08/2019
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::getFullData()</code></b><br>
	Esta função é utiliza para retornar apenas a data e a hora no formato <b>d/m/Y H:i</b>;

	<pre>
		$util = new Utils();
		echo $util->getFullData();

		//Retornará: 16/08/2019 07:44
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::getFullDataWithSeconds()</code></b><br>
	Esta função é utiliza para retornar a data completa no formato <b>d/m/Y H:i:s</b>;

	<pre>
		$util = new Utils();
		echo $util->getFullDataWithSeconds();

		//Retornará: 16/08/2019 07:44:21
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::getHora()</code></b><br>
	Esta função é utiliza para retornar apenas a hora no formato <b>H:i</b>;

	<pre>
		$util = new Utils();
		echo $util->getHora();

		//Retornará: 07:44
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::getHoraWithSeconds()</code></b><br>
	Esta função é utiliza para retornar a hora, minutos e segundos no formato <b>H:i:s</b>;

	<pre>
		$util = new Utils();
		echo $util->getHoraWithSeconds();

		//Retornará: 07:44:21
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::getHoraWithSeconds()</code></b><br>
	Esta função é utiliza para retornar a hora, minutos e segundos no formato <b>H:i:s</b>;

	<pre>
		$util = new Utils();
		echo $util->getHoraWithSeconds();

		//Retornará: 07:44:21
	</pre>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::alert(type, msg)</code></b><br>
	Esta função é utiliza para retornar uma div com um determinado alerta, podendo ser passado os parâmetros(info, success, danger, warning, dark, primary, ...): <b>Boostrap 4.3.1 - Alerts</b>;

	<pre>
		$util = new Utils();
		echo $util->alert($type, $msg);
	</pre>
	<hr>

	<p><b>Exemplos:</b> Listando Determinados alertas; Obs: Não há necessidade de passar um echo na frente da função, ele já retorna por padrão com echo</p>
	<pre>
		$util = new Utils();
		$util->alert("success", "Pode prosseguir!");
		$util->alert("warning", "Atenção!");
		$util->alert("danger", "Pare!!");
		

		//Retornará:
	</pre>
	<div class="alert alert-success col-sm-4" style="margin-left: 10px">Pode prosseguir!</div>
	<div class="alert alert-warning col-sm-4" style="margin-left: 10px">Atenção!</div>
	<div class="alert alert-danger col-sm-4" style="margin-left: 10px">Pare!!</div>

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::swAlert(tipo, titulo, msg)</code></b><br>
	Esta função é utiliza para retornar um modal de alerta no centro da tela podendo ser utilizado com apenas dois tipos: (<span class='text-success'>success</span>,<span class='text-danger'> error</span>) que desaparecerá automaticamente em 1.5s(Podendo ser alterado na função); <br>
	Caso não queira preencher um título ou descrição, coloque o campo por padrão como <b>null</b>;<br>
	Não precisa retornar com echo, pois por padrão ele já é retornado com echo

	<pre>
		$util = new Utils();
		$util->swAlert(tipo, titulo, msg);
	</pre>

	<hr>
	<p><b>Exemplo #1: </b> Success completo</p>
	<pre>
		$util = new Utils();
		$util->swAlert("success", "Muito bem", "Parece que você fez seu dever de casa :)");

		//Retornará:
	</pre>
	<img src="images/success-complete.png">

	<p><b>Exemplo #2: </b> Success apenas título</p>
	<pre>
		$util = new Utils();
		$util->swAlert("success", "Muito bem", false);

		//Retornará:
	</pre>
	<img src="images/success-onlytitle.png">

	<p><b>Exemplo #3: </b> Success apenas mensagem</p>
	<pre>
		$util = new Utils();
		$util->swAlert("success", false, "Parece que você fez seu dever de casa :)");

		//Retornará:
	</pre>
	<img src="images/success-onlymsg.png">

	<p><b>Exemplo #4: </b> Error completo</p>
	<pre>
		$util = new Utils();
		$util->swAlert("error", "Ops", "Parece que algo deu errado :(");

		//Retornará:
	</pre>
	<img src="images/error-complete.png">

	<p><b>Exemplo #5: </b> Error apenas mensagem</p>
	<pre>
		$util = new Utils();
		$util->swAlert("error", false, "Parece que algo deu errado :(");

		//Retornará:
	</pre>
	<img src="images/error-onlymsg.png">

	<hr>
	<p><b>FUNÇÃO: <code>UTILS::redirect(tempo, url)</code></b><br>
	Esta função é utiliza redirecionar o usuário para alguma página em um determinado tempo <br>
	Ambos os campos precisam ser preenchidos, caso queira redirecionar direto, adicionar 0 no tempo;

	<pre>
		$util = new Utils();
		$util->redirect(tempo, url);
	</pre>

	<p><b>Exemplo #1: </b> Com tempo</p>
	<pre>
		$util = new Utils();
		$util->redirect(3, "/dashboard");

		//Após 3 segundo será redirecionado para o views/dashboard.php
	</pre>

	<p><b>Exemplo #2: </b> Sem tempo</p>
	<pre>
		$util = new Utils();
		$util->redirect(0, "/dashboard");

		//Será redirecionado imediatamente para o views/dashboard.php
	</pre>

	<hr>
	<h4 style="text-transform: none;">Website:: <small>A classe Website contém as funções mais importantes do projeto, arquivos de paginação. Tendo duas, uma para site e outra para Painel de controle autentiticado</small></h4>

	<hr>
	<p><b>FUNÇÃO: <code>WEBSITE::pagination()</code></b><br>
	Caso esteja utilizando um site comum, onde não precise de autenticação;<br>
	Todas as alterações deverão ser feitas no <code>index.php</code>;<br>
	Por padrão ele pedirá a página <b>inicio.php</b> que deverá ser criada em <code>views/</code>

	<pre>
		//index.php
		include_once("inc/autoload.php");
		include("includes/topo.php");
		$website = new Website(); 
		$website->pagination();
		include("includes/footer.php");
	</pre>

	A função também pode ser chamada de forma estática passando direto a classe e o nome da função:

	<pre>
		//index.php
		include_once("inc/autoload.php");
		include("includes/topo.php");
		website::pagination();
		include("includes/footer.php");
	</pre>

	Caso retorne: <b>Página não encontrada</b>; Provavelmente você não criou o arquivo <b>inicio.php</b> no diretório <code>views/</code>

	<hr>
	<p><b>FUNÇÃO: <code>WEBSITE::paginationAuth()</code></b><br>
	Esta função deve ser inserira no index.php caso esteja utilizando um sitema de autenticação como: Painel de controle, ADMCP entre outros;<br>
	Todas as alterações deverão ser feitas no <code>index.php</code>;<br>
	Por padrão ele pedirá a página <b>login.php</b> que deverá ser criada em <code>views/</code>;<br>

	O usuário não terá acesso a nenhuma outra página a menos que tenha uma sessão com <code>$_SESSION['authId']</code> iniciada;<br>

	<pre>
		//index.php
		include_once("inc/autoload.php");
		include("includes/topo.php");
		$website = new Website(); 
		$website->paginationAuth();
		include("includes/footer.php");
	</pre>

	A função também pode ser chamada de forma estática passando direto a classe e o nome da função:

	<pre>
		//index.php
		include_once("inc/autoload.php");
		include("includes/topo.php");
		website::paginationAuth();
		include("includes/footer.php");
	</pre>

	Caso retorne: <b>Página não encontrada</b>; Provavelmente você não criou o arquivo <b>login.php</b> no diretório <code>views/</code><br>

	<b>Obs: Caso crie as sessões com a função <code>::Sessions->setSessions(id, nome, usuario, senha)</code>, a sessão deverá ter um id para funcionar, ou ser alterado para outra sessão em <code>inc/Website.class.php</code>. Exemplo:</b><br><br>

	<pre>
		//Alterado de $_SESSION['authId'] para $_SESSION['authUsuario']
		
		public static function paginationAuth(){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'login';
			$explode = explode('/', $url);
			$dir = 'views/';
			$ext = '.php';

			if(file_exists($dir.$explode[0].$ext) && isset($_SESSION['authUsuario'])){
				include($dir.$explode[0].$ext);
			}else{
				include($dir.'login'.$ext);
			}
		}
	</pre>

  
