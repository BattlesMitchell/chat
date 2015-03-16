<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="project.css">
    </head>
    <body>
        <?php
            include("../secure/database.php");

            $conn = pg_connect(HOST . " " . DBNAME . " " . USERNAME . " " . PASSWORD);
            if($conn)
            {
                if($_GET['update'] == true)
                {
                    $update_result = pg_prepare($conn, "update_query", 'INSERT INTO project.posted_to VALUES (DEFAULT, $1, $2, $3, NOW(), FALSE)');
                    $update_result = pg_execute($conn, "update_query", array($_GET['board_id'], $_GET['username'], $_GET['post']));
                }
                
                //[0]icon, [1]post, [2]year, [3]month, [4]day, [5]hour, [6]minute, [7]username
                $results = pg_prepare($conn, "my_query", "SELECT users.image, posts.post, EXTRACT('year' FROM AGE(NOW(), post_timestamp)), EXTRACT('month' FROM AGE(NOW(), post_timestamp)), EXTRACT('day' FROM AGE(NOW(), post_timestamp)), EXTRACT('hour' FROM AGE(NOW(), post_timestamp)), EXTRACT('minute' FROM AGE(NOW(), post_timestamp)), username AS post_age FROM project.users AS users INNER JOIN (SELECT * FROM project.boards AS boards INNER JOIN project.posted_to AS posted USING (board_id) WHERE boards.board_id = $1) AS posts USING (username) ORDER BY post_timestamp ASC");
                $results = pg_execute($conn, "my_query", array($_GET['board_id']));
                create_table($results);
                pg_free_result($results);
            }
            else
            {
                    echo "<p>Failed to connect</p>\n";
            }
            pg_close($conn);

            //create table
            function create_table($queryResults)
            {
                $rowCount = pg_num_rows($queryResults);
                //create table
                echo '<table id="contentbox">' . "\n";
                //create table content
                for($i = 0; $i < $rowCount; $i++)
                {
                    if($i != 0){
                        echo "\t<tr class='divide'>\n";
                        echo "\t\t<td colspan='2'>\n";
                        echo "\t\t\t<hr class='contentrail'>\n";
                        echo "\t\t</td>\n";
                        echo "\t</tr>\n";
                    }
                    
                    //need to put the username under the image
                    echo "\t<tr>\n";
                    $array = pg_fetch_array($queryResults, $i);
                    
                    //user image
                    echo "\t\t<td class='image' rowspan='2'>\n";
                    echo "\t\t\t<div class='userimage'>\n";
                    $url = $array[0];
                    echo "\t\t\t\t<img class='postimage' src='$url'>\n";
                    echo "\t\t</td>\n";
                    echo "\t\t<td>\n";
                    
                    $post_year = intval($array[2]);
                    $post_month = intval($array[3]);
                    $post_day = intval($array[4]);
                    $post_hour = intval($array[5]);
                    $post_minute = intval($array[6]);
                    if($post_year >= 1)
                    {
                        $age = "$post_year years";
                    }
                    elseif ($post_month >= 1)
                    {
                        $age = "$post_month months";
                    }
                    elseif ($post_day >= 1)
                    {
                        $age = "$post_day days";
                    }
                    elseif ($post_hour >= 1)
                    {
                        $age = "$post_hour hours";
                    }
                    elseif ($post_minute >= 1)
                    {
                        $age = "$post_minute minutes";
                    }
                    else
                    {
                        $age = "Less than one minute";
                    }
                    echo "\t\t\t<p class='age'>$age since posted</p>\n";
                    
                    echo "\t\t</td>\n";
                    echo "\t</tr>\n";
                    echo "\t<tr>\n";
                    
                    //post data
                    echo "\t\t<td rowspan='2'>\n";
                    $post_text = $array[1];
                    echo "\t\t\t<p>$post_text</p>\n";
                    echo "\t\t</td>\n";
                    echo "\t</tr>\n";
                    
                    //show username
                    echo "\t<tr>\n";
                    echo "\t\t<td>\n";
                    $username = $array[7];
                    echo "\t\t\t\t<p class='username'>$username</p>\n";
                    echo "\t\t\t</div>\n";
                    echo "\t\t</td>\n";
                    echo "\t</tr>\n";
                }

                //end table
                echo "</table>\n";
            }
        ?>
    </body>
</html>