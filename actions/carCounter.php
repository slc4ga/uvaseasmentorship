<?    
    require_once '../classes/membership.php';
    $mysql = new mysql();
    $checked=$_GET['checked'];
    echo $checked;
?>
<html>
<input
       type=number
       name="car" min="2" max="200"
       style="margin-top: 10px;"
       <? if($checked != "X") { echo "disabled"; } ?>
       value='<? echo $mysql->getCar($_SESSION['username']) ?>' 
       >
</html>


