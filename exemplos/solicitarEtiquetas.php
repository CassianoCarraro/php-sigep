<?php
require_once __DIR__ . '/bootstrap-exemplos.php';

$accessDataDeHomologacao = new \PhpSigep\Model\AccessDataHomologacao();
$usuario = trim((isset($_GET['usuario']) ? $_GET['usuario'] : $accessDataDeHomologacao->getUsuario()));
$senha = trim((isset($_GET['senha']) ? $_GET['senha'] : $accessDataDeHomologacao->getSenha()));
$cnpjEmpresa = $accessDataDeHomologacao->getCnpjEmpresa();

$accessData = new \PhpSigep\Model\AccessData();
$accessData->setUsuario($usuario);
$accessData->setSenha($senha);
$accessData->setCnpjEmpresa($cnpjEmpresa);

$params = new \PhpSigep\Model\SolicitaEtiquetas();
$params->setQtdEtiquetas(1);
$params->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_E_SEDEX_STANDARD);
$params->setAccessData($accessData);

$phpSigep = new PhpSigep\Services\SoapClient\Real();

?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Exemplo Rastrear Objetos - PHP Sigep</title>
    </head>
    <body>
        <div style="display:inline-block;color: red;font-weight: bold;border: 1px solid silver;padding: 20px;background-color: #fffcfc">
            O Correios sempre retorna "A autenticacao de sigep falhou!" quando solicitamos etiquetas
            <u>usando o servidor de homologação</u>.
            <br/>
            Por esse motivo, você deve informar um usuário e senha real para este exemplo funcionar corretamente.
        </div>
        <br/>
        <br/>
        <form action="" method="get">
            O usuário e senha abaixo são do ambiente de homologação.
            <br/>
            Troque estes dados por um usuário e senha real para, caso contrario o Correios responderá que não foi possível autentificar o usuário.
            <br/>
            <br/>
            <label for="usuario">Usuário</label>
            <input type="text" name="usuario" value="<?php echo htmlspecialchars($accessData->getUsuario(), ENT_QUOTES); ?>"/>
            <br/>
            <label for="senha">Senha</label>
            <input type="text" name="senha" value="<?php echo htmlspecialchars($accessData->getSenha(), ENT_QUOTES); ?>"/>
            <br/>
            <button type="submit">Gerar etiquetas</button>
        </form>
        <br/>
        <h1>Resposta</h1>
        <hr/>
        <pre><?php var_dump($phpSigep->solicitaEtiquetas($params)); ?></pre>
    </body>
</html>