<?php
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "SELECT * FROM deal_list";
$result= mysqli_query($conn, $sql);

$months = array(0,0,0,0,0,0,0,0,0,0,0,0);

$totalMonth = 0;
while($fetch = mysqli_fetch_array($result)){
    $month = date("n", strtotime($fetch['created']));
    if($month == 1){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[0] += $totalMonth;
    }
    if($month == 2){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[1] += $totalMonth;
    }
    if($month == 3){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[2] += $totalMonth;
    }
    if($month == 4){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[3] += $totalMonth;
    }
    if($month == 5){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[4] += $totalMonth;
    }
    if($month == 6){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[5] += $totalMonth;
    }
    if($month == 7){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[6] += $totalMonth;
    }
    if($month == 8){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[7] += $totalMonth;
    }
    if($month == 9){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[8] += $totalMonth;
    }
    if($month == 10){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[9] += $totalMonth;
    }
    if($month == 11){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[10] += $totalMonth;
    }
    if($month == 12){
        if($fetch['state']==1){
            $totalMonth += $fetch['total'];
        }else{
            $totalMonth -= $fetch['total'];
        }
        $array[11] += $totalMonth;
    }
}
echo $array
?>