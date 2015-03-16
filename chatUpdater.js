var set_delay = 5000;
var boardId = "";
var username = "";

function startUpdating()
{
    setInterval(getData, 5000);
}

function getData()
{
    getBoardInStorage();
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("contentbox").innerHTML = xmlhttp.responseText;
            scrollBottom();
        }
    };
    xmlhttp.open("GET","temp.php?board_id=" + boardId,true);
    xmlhttp.send();
}

function sendData(post)
{
    getBoardInStorage();
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("contentbox").innerHTML = xmlhttp.responseText;
            scrollBottom();
        }
    };
    xmlhttp.open("GET","temp.php?board_id=" + boardId + "&username=" + username + "&post=" + post + "&update=true",true);
    xmlhttp.send();
}

function getPost()
{
    var post_string = document.getElementById("post").value;
    document.getElementById("post").value = '';
    return post_string;
}

function scrollBottom()
{
    var objDiv = document.getElementById("contentbox");
    objDiv.scrollTop = objDiv.scrollHeight;
}

function getUsernameInStorage()
{
    if(sessionStorage.boardUsername)
    {
        username = sessionStorage.boardUsername;
    }
    else
    {
        username = null;
    }
}

function getUsernameFromStorage()
{
    if(sessionStorage.boardUsername)
    {
        return sessionStorage.boardUsername;
    }
    else
    {
        return null;
    }
}

function setUsernameInStorage(username)
{
    if(typeof(Storage) !== "undefined") {
        sessionStorage.boardUsername = username;
    }
}

function getBoardInStorage()
{
    if(sessionStorage.boardBoard)
    {
        boardId = sessionStorage.boardBoard;
    }
    else
    {
        boardId = null;
    }
}

function setBoardInStorage(boardName)
{
    if(typeof(Storage) !== "undefined") {
        sessionStorage.boardBoard = boardName;
        getData();
    }
}