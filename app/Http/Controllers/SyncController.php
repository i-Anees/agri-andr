<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
//     protected $client;
//     protected $couchdbHost;
//     protected $database;



//     public function syncTableToCouchDB($tableName = 'village_quarter_tbl')
//     {
//         // Step 1: Fetch MySQL table structure
//         $columns = $this->getTableStructure($tableName);
//         // dd($columns);
//         // Step 2: Create CouchDB client
//         $client = new Client([
//             'base_uri' => env('COUCHDB_HOST'),
//             'auth' => [env('COUCHDB_USER'), env('COUCHDB_PASSWORD')],
//         ]);
//         // Step 3: Fetch all data from MySQL table
//         $tableData = DB::table($tableName)->get();
//         foreach ($tableData as $row) {
//             // Prepare data for CouchDB document
//             $document = [];
            
//             foreach ($columns as $column) {
//                 $columnName = $column->Field;
//                 $document[$columnName] = $row->$columnName;  // Add each column's value to the document
//             }
    
//             // Insert document into CouchDB
//             $response = $client->request('POST', "/agri", [
//                 'json' => $document,
//                 'timeout' => 1000,  // Insert the document with all fields
//             ]);
    
//             $responseBody = json_decode($response->getBody(), true);
//             if (isset($responseBody['ok']) && $responseBody['ok'] === true) {
//                 echo "Document inserted with ID: " . $responseBody['id'];
//             } else {
//                 echo "Error inserting document";
//             }
//         }
        
//         return response()->json(['message' => 'Sync from MySQL to CouchDB completed'], 200);
//     }




//     public function __construct()
//     {
//         // Initialize HTTP client for CouchDB
//         $this->client = new Client([
//             'base_uri' => env('COUCHDB_HOST'),
//             'auth' => [env('COUCHDB_USER'), env('COUCHDB_PASSWORD')],
//         ]);

//         $this->database = env('COUCHDB_DATABASE');
//     }

//     // Sync data from CouchDB to MySQL using raw queries
//     public function syncFromCouchDB()
//     {
//         // Fetch all documents from CouchDB
//         $response = $this->client->request('GET', "/{$this->database}/_all_docs", [
//             'query' => ['include_docs' => 'true']
//         ]);

//         $data = json_decode($response->getBody(), true);

//         foreach ($data['rows'] as $doc) {
//             $record = $doc['doc'];

//             // Use raw SQL to insert or update data in MySQL
//             DB::table('village_quarter_tbl')->updateOrInsert(
//                 ['id' => $record['_id']],  // Use CouchDB's _id as a unique key
//                 [
//                     'column1' => $record['field1'],  // Map CouchDB fields to MySQL columns
//                     'column2' => $record['field2'],
//                     // Add more fields as necessary
//                 ]
//             );
//         }

//         return response()->json(['message' => 'Sync from CouchDB completed'], 200);
//     }

//     // Sync data from MySQL to CouchDB using raw queries
//     public function syncToCouchDB()
//     {
//         // Fetch all records from MySQL
//         $mysqlRecords = DB::table('village_quarter_tbl')->get();

//         foreach ($mysqlRecords as $record) {
//             // Push each MySQL record to CouchDB
//             $this->client->request('PUT', "/{$this->database}/{$record->id}", [
//                 'json' => [
//                     'field1' => $record->column1,  // Map MySQL fields to CouchDB document structure
//                     'field2' => $record->column2,
//                     // Add more fields as necessary
//                 ]
//             ]);
//         }

//         return response()->json(['message' => 'Sync to CouchDB completed'], 200);
//     }


//     public function getTableStructure($tableName)
// {
//     // Fetch columns from the specified table
//     $columns = DB::select("DESCRIBE $tableName");

//     return $columns;
// }



public function syncToSQLite($table)
{
    $data = DB::table($table)->limit(100)->get(); // Fetch data from MySQL

    return response()->json(collect($data), 200);
}
}
