<?php
                // incluye la conexión
                include_once('connection.php');
                //echo $_SESSION['privilegio'];

                $database = new Connection();
                $db = $database->open();
                try {
                    $sql = 'SELECT * FROM members';
                        foreach ($db->query($sql) as $row) {
                            ?><?php echo $row['estado']; ?><?php
                            
                    }
                } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //cerrar conexión
                $database->close();

?>