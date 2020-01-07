<?php
                // incluye la conexión
                include_once('connection.php');
                //echo $_SESSION['privilegio'];

                $database = new Connection();
                $db = $database->open();
                $array = [];
                try {
                    $sql = 'SELECT * FROM members';
                        foreach ($db->query($sql) as $row) {
<<<<<<< HEAD
                            ?><?php echo $row['estado']; ?><?php
                            
=======
                             echo $row['estado'];  
>>>>>>> 3638f1a01a0c20d4a5c8889e51e841a32338e585
                    }
                } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //cerrar conexión
                $database->close();

?>