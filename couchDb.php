<?php
class CouchDB {
    private $url;

    public function __construct($url = 'http://127.0.0.1:5984') {
        $this->url = rtrim($url, '/');
    }

    private function request($method, $endpoint, $data = null) {
        $ch = curl_init();
        $url = $this->url . $endpoint;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin');
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ]);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return json_decode($response, true);
    }

    public function createDatabase($dbName) {
        return $this->request('PUT', '/' . $dbName);
    }

    public function insertDocument($dbName, $data) {
        return $this->request('POST', '/' . $dbName, $data);
    }

    public function getDocument($dbName, $docId) {
        return $this->request('GET', '/' . $dbName . '/' . $docId);
    }

    public function updateDocument($dbName, $docId, $data) {
        $doc = $this->getDocument($dbName, $docId);
        $data['_rev'] = $doc['_rev']; 
        return $this->request('PUT', '/' . $dbName . '/' . $docId, $data);
    }

    public function deleteDocument($dbName, $docId) {
        $doc = $this->getDocument($dbName, $docId);
        $rev = $doc['_rev'];
        return $this->request('DELETE', '/' . $dbName . '/' . $docId . '?rev=' . $rev);
    }

    public function listDocuments($dbName) {
        return $this->request('GET', '/' . $dbName . '/_all_docs?include_docs=true');
    }
}
