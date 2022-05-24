<!DOCTYPE html>
<html>
    <head>
        <title>Datatable</title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>

        <script src="js/jQuery.js" type="text/javascript"></script>
        <script src="js/manageEmployee.js" type="text/javascript"></script>
    </head>
    <body>
        <h1>Datatable</h1>
        <table id="tabella">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Hire Date</th>
                </tr>
            </thead>
        </table>

        <?php
            $host = "172.17.0.1:3306";
            $user = "root";
            $password = "my-secret-pw";
            $database = "mydb";
            
            $mysql = mysqli_connect($host, $user, $password, $database);

            $page = $_GET['page'];
            $size = $_GET['size'];
            
            switch($_SERVER['REQUEST_METHOD']){

                case 'GET':
                    $SQL = "SELECT * FROM employees LIMIT " . $page * $size . "," . $size;
                    $scelta = mysqli_query($mysql, $SQL);
                    if(mysqli_query($mysql, $SQL)){
                        for($i = 0; $i < 20; $i++){
                            $row = mysqli_fetch_array($scelta, MYSQLI_ASSOC);
                            echo json_encode($row) . "<br><br>";
                        }
                    }
                break;

                case 'POST':
                    $momentanea = file_get_contents('php://input');
                    $dati = json_decode($momentanea);
                    $SQL = "INSERT INTO employees VALUES(DEFAULT, '$dati->birthDate', '$dati->firstName', '$dati->lastName', '$dati->gender', '$dati->hireDate');";
                    $scelta = mysqli_query($mysql, $SQL);
                    if(mysqli_query($mysql, $SQL)){
                        for($i = 0; $i < 20; $i++){
                            $row = mysqli_fetch_array($scelta, MYSQLI_ASSOC);
                            echo json_encode($row) . "<br><br>";
                        }
                    }
                break;
        
                case 'PUT':
                    $momentanea = file_get_contents('php://input');
                    $dati = json_decode($momentanea);
                    $SQL = "UPDATE employees SET birth_date = '$dati->birthDate', first_name = '$dati->firstName', last_name = '$dati->lastName', gender = '$dati->gender', hire_date = '$dati->hireDate' WHERE id = '$dati->id';";
                    $scelta = mysqli_query($mysql, $SQL);
                    if(mysqli_query($mysql, $SQL)){
                        for($i = 0; $i < 20; $i++){
                            $row = mysqli_fetch_array($scelta, MYSQLI_ASSOC);
                            echo json_encode($row) . "<br><br>";
                        }
                    }
                break;
        
                case 'DELETE':
                    $momentanea = file_get_contents('php://input');
                    $dati = json_decode($momentanea);
                    $SQL = "DELETE FROM employees WHERE id = '$dati->id';";
                    $scelta = mysqli_query($mysql, $SQL);
                    if(mysqli_query($mysql, $SQL)){
                        for($i = 0; $i < 20; $i++){
                            $row = mysqli_fetch_array($scelta, MYSQLI_ASSOC);
                            echo json_encode($row) . "<br><br>";
                        }
                    }
                break;

                default:
                    //404 status
                    header("HTTP/1.1 404 Not Found");
                break;

            }
        ?>

    </body>
</html>