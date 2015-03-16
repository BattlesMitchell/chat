<html>
    <head>
        <!--Get title from table's title-->
        <!--Should really be a php page and load the title texts when the page loads.-->
        <title>Project</title>
        <link rel="stylesheet" type="text/css" href="project.css">
        <script src="chatUpdater.js"></script>
    </head>
    <body>
        <?php
            include("../secure/database.php");
            
            //starting scripts
            //need table and username selection
            echo "" . '<script>' . "\n";
            //should use sessionStorage for some of this
            echo "\t\t" . 'setBoardInStorage("1");' . "\n";
            echo "\t\t" . 'setUsernameInStorage("jlhthd");' . "\n";
            echo "\t\t" . 'getUsernameInStorage();' . "\n";
            echo "\t\t" . 'startUpdating();' . "\n";
            echo "\t" . '</script>' . "\n";
            
            $connection = pg_connect(HOST . " " . DBNAME . " " . USERNAME . " " . PASSWORD);
            
            //side bar menu
            createSideMenu($connection);
            
            echo "\t" . '<div id="titletext">' . "\n";
            
            //set page title and title text from server
            set_titles($connection);
            
            echo "\t" . '</div>' . "\n";
            echo "\t" . '<div id="bodybox" class="center">' . "\n";
            echo "\t\t" . '<table id="textbox">' . "\n";
            echo "\t\t\t" . '<tr>' . "\n";
            echo "\t\t\t\t" . '<td colspan="3">' . "\n";
            echo "\t\t\t\t\t" . '<div id="textscroll">' . "\n";
            
            //chat created dynamically
            echo "\t\t\t\t\t\t" . "<div id='contentbox'><!--Chat goes here--></div>" . "\n";
            
            echo "\t\t\t\t\t" . '</div>' . "\n";
            echo "\t\t\t\t" . '</td>' . "\n";
            echo "\t\t\t" . '</tr>' . "\n";
            echo "\t\t\t" . '<tr class="divide">' . "\n";
            echo "\t\t\t\t" . '<td colspan="3">' . "\n";
            echo "\t\t\t\t\t" . '<hr>' . "\n";
            echo "\t\t\t\t" . '</td>' . "\n";
            echo "\t\t\t" . '</tr>' . "\n";
            echo "\t\t\t" . '<tr class="input">' . "\n";
            echo "\t\t\t\t" . '<td class="image">' . "\n";
            echo "\t\t\t\t\t" . '<div class="userimage">' . "\n";
            
            //set user image
            echo "\t\t\t\t\t\t" . '<img class="postimage" src="http://placehold.it/100" />' . "\n";
            
            echo "\t\t\t\t\t" . '</div>' . "\n";
            echo "\t\t\t\t" . '</td>' . "\n";
            echo "\t\t\t\t" . '<td>' . "\n";
            
            //user post input
            echo "\t\t\t\t\t" . '<textarea id="post"></textarea>' . "\n";
            echo "\t\t\t\t" . '</td>' . "\n";
            echo "\t\t\t\t" . '<td class="post">' . "\n";
            
            echo "\t\t\t\t\t" . '<input class="myButton" type="button" value="Post"' . " onclick='sendData(" . 'getPost()' . ")'/>" . "\n";
            
            echo "\t\t\t\t" . '</td>' . "\n";
            echo "\t\t\t" . '</tr>' . "\n";
            echo "\t\t" . '</table>' . "\n";
            echo "\t" . '</div>' . "\n";
            
            pg_close($connection);
            
            function set_titles($conn)
            {
                try
                {
                    if($conn)
                    {
                        //need dynamic table selection
                        //will need to put in an ajax it would seem
                        $result = pg_prepare($conn, "title_query", "SELECT board_name FROM project.boards WHERE board_id = 1");
                        $result = pg_execute($conn, "title_query", array());
                        
                        if($result)
                        {
                            $array = pg_fetch_array($result, 0);
                            $title = $array[0];
                            echo "\t\t" . "$title" . "\n";
                            echo "\t\t" . "<script>document.title = 'Chat Group: $title'</script>" . "\n";
                        }
                        else
                        {
                            throw new Exception('Query failed');
                        }
                    }
                    else
                    {
                        throw new Exception('Could not connect');
                    }
                }
                catch(Exception $e)
                {
                    echo "\t\t" . "<p>Error: " . $e->getMessage() . "</p>\n";
                }
            }
            
            function createSideMenu($conn)
            {
                echo "\t" . '<table id="sidemenu">' . "\n";
                
                getBoards($conn);
                
                echo "\t\t" . '<tr>' . "\n";
                echo "\t\t\t" . '<td>' . "\n";
                echo "\t\t\t" . '</td>' . "\n";
                echo "\t\t" . '</tr>' . "\n";
                echo "\t" . '</table>' . "\n";
            }
            
            //need to ajax this as well
            function getBoards($conn)
            {
                if($conn)
                {
                    $results = pg_prepare($conn, "board_query", "SELECT board_name, board_id FROM project.boards AS boards INNER JOIN project.belongs_to AS belong USING (board_id) WHERE username = 'jlhthd' ORDER BY board_name ASC");
                    $results = pg_execute($conn, "board_query", array());
                    
                    if($results)
                    {
                        $num_rows = pg_num_rows($results);
                        
                        for($i = 0; $i < $num_rows; $i++)
                        {
                            $array = pg_fetch_array($results, $i);
                            
                            echo "\t\t" . '<tr class="board">' . "\n";
                            echo "\t\t\t" . '<td>' . "\n";
                            
                            $board = $array[0];
                            $boardId = $array[1];
                            echo "\t\t\t\t" . "<input type='button' value='$board' onclick=" . '"setBoardInStorage(' . "'" . "$boardId" . "'" . ');" />' . "\n";
                            
                            echo "\t\t\t" . '</td>' . "\n";
                            echo "\t\t" . '</tr>' . "\n";
                        }
                    }
                }
            }
        ?>
    </body>
</html>