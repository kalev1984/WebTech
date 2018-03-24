<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <div id="menu"><a href="index.php" id="list-page-link">Nimekiri</a>  |
<a href="add.php" id="add-page-link">Lisa</a>
</div>

    <div id="content">



<form method="post" action="index.php">

    <input type="hidden" name="id" value="">

    <table class="form-table">
        <tbody>
        <tr>
            <td>Eesnimi:</td>
            <td><input name="firstName" value=""></td>
        </tr>
        <tr>
            <td>Perekonnanimi:</td>
            <td><input name="lastName" value=""></td>
        </tr>
        <tr>
            <td>Telefonid:</td>
            <td><input name="phone" value=""></td>
        </tr>
        <tr>
            <td colspan="2"><br>
                <input name="submit-button" type="submit" value="Salvesta">
            </td>
        </tr>

        </tbody>
    </table>

</form>
</div>

    <div id="footer">
        ICD0007 N&auml;idisrakendus
    </div>
</body>
</html>