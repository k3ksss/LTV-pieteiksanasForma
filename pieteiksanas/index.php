<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <title>Pieteiksanas forma</title>
    <h1> Pieteikšanās Forma</h1>
</head>

<body>
    <?php
    $name = $surname = $birthday = $file = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $birthday = $_POST["birthday"];
        $file = $_POST["file"];
        if(validateAge($birthday) == true && checkIfNeededFileType($file) == true){
            saveAsJSON($name,$surname,$birthday,$file);
        }
    }

    function alert($msg){
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    function validateAge($then)
    {
        $then = strtotime($then);
        $min = strtotime('+18 years', $then);
        if(time() < $min)  {
            alert("Jums nav 18+!");
            return false;
        }else{
            return true;
        }
    }

    function checkIfNeededFileType($img){
        $img = strtolower($img);
        if (strpos($img,'.png') == true) {
            return true;
        }else if (strpos($img,'.jpg') == true) {
            return true;
        }else{
            alert("Pievienot drikst tikai .png vai .jpg failus!");
            return false;
        }
    }

    function saveAsJSON($name,$surname,$birthday,$file){
        $myObj = new \stdClass();
        $myObj->vards = $name;
        $myObj->uzvards = $surname;
        $myObj->dzimsanasdiena = $birthday;
        $myObj->bilde = $file;

        $myJSON = json_encode($myObj);
        $fp = fopen('pieteiksanas.json', 'w');
        fwrite($fp, $myJSON);
        fclose($fp);
    }
    

    ?>
    <form method="POST">
        <table>
            <tr>
                <td>vards:</td>
                <td><input id="name" type="text" name="name" required></td>
            </tr>
            <tr>
                <td>uzvards:</td>
                <td><input id="surname" type="text" name="surname" required></td>
            </tr>
            <tr>
                <td>dzimsanas gads:</td>
                <td><input type="date" id="birthday" name="birthday" value="2020-09-05"><br></td>
            </tr>
            <tr>
                <td>pievieno bildi(jpg,png)</td>
                <td><input type="file" id="myFile" name="file" required accept=".png, .jpg">
            </tr>
        </table>
        <input type="submit" value="apstirpinat">
    </form>
</body>

</html>

