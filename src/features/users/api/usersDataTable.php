<?php

include '../../../core/app.php';
apiHeaders();

// use Mindtrack\Models\Users;
use Mindtrack\Utils\Php\Formatters;
use Mindtrack\Services\DataTables;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['message'] = 'Invalid usersDataTable request method';
    echo json_encode($response);
    exit;
}

try {
    // DB table to use
    $table = 'users';
    // Table's primary key
    $primaryKey = 'uuid';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        ['db' => 'firstname', 'dt' => 'firstname'],
        ['db' => 'email', 'dt' => 'email'],
        ['db' => null, 'dt' => 'role'],
        ['db' => 'location', 'dt' => 'location'],
        ['db' => 'telephone', 'dt' => 'telephone'],
        [
            'db' => 'dob',
            'dt' => 'dob',
            'formatter' => function ($d, $row) {
                return Formatters::dateToMDY($d);
            }
        ],
        [
            'db' => 'created_at',
            'dt' => 'created_at',
            'formatter' => function ($d, $row) {
                return Formatters::timeAgo($d);
            }
        ],
        // Additional Data: for array_map() data transformation
        ['db' => 'uuid', 'dt' => 'uuid'],
        ['db' => 'lastname', 'dt' => 'lastname'],
    );

    // Use $conn if defined, otherwise use the SQL server connection information 
    if (is_null($conn)) {
        $conn = array(
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'db' => $_ENV['DB_DATABASE'],
            'host' => $_ENV['DB_HOST']
        );
    }


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP
     * server-side, there is no need to edit below this line.
     */

    // Use DataTables class, otherwise use the legacy SSP class
    // require('../../../services/dataTables.php');

    $response = DataTables::simple($_GET, $conn, $table, $primaryKey, $columns);
    $response['data'] = array_map(function ($user) {
        return [
            'user_uuid' => $user['uuid'],
            'name' => $user['firstname'] . ' ' . $user['lastname'],
            'email' => $user['email'],
            'role' => 'User',
            'telephone' => $user['telephone'] ? $user['telephone'] : '...',
            'dob' => $user['dob'],
            'location' => $user['location'] ? $user['location'] : '...',
            'profile' => media($user['uuid']),
            'created_at' => $user['created_at'],
            'DT_RowAttr' => [
                'data-user-uuid' => $user['uuid'],
                'class' => 'user-item'
            ]
        ];
    }, $response['data'] ?? []);
    $response['success'] = true;
    $response['message'] = 'Users fetched successfully';

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;