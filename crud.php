<?php
require 'couchdb.php';

$db = new CouchDB();
$database = 'teste';

function displayResult(string $title, $result) {
  echo "<h2>$title</h2><pre>";
  print_r($result);
  echo "</pre><hr>";
}

// $response = $db->listDocuments($database);
// if (isset($response['error']) && $response['error'] === 'not_found') {
//     displayResult('Erro: Banco de dados não encontrado', $response);
//     exit;
// }

// $response = $db->createDatabase($database);
// if (isset($response['error'])) {
//     die("Erro ao criar banco de dados: " . $response['reason']);
// }$db->createDatabase($database);


// criação
$user = ['nome' => 'Erick', 'idade' => 16, 'profissao' => 'Desenvolvedor'];
$response = $db->insertDocument($database, $user);

echo "Documentos criados:\n\n\n\n";
displayResult('Criação',$response);


// show
// echo "\nListando documentos:\n";
// $docs = $db->listDocuments($database);
// displayResult('listagem',$docs);



//update
// $docId = $response1['id'];
// $updatedDoc = ['nome' => 'João Silva', 'idade' => 31, 'profissao' => 'Engenheiro'];
// $updateResponse = $db->updateDocument($database, $docId, $updatedDoc);

// echo "\nDocumento atualizado:\n";
// print_r($updateResponse);



//delete
// $deleteResponse = $db->deleteDocument($database, $docId);
// echo "\nDocumento deletado:\n";
// print_r($deleteResponse);
