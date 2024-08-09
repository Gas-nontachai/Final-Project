<?php
require("../condb.php");
$sql = "SELECT * FROM zone_detail ORDER BY zone_name";
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
                                    <div class="mt-2 ">
                                       <div class="row ">
                                            <div class="col">
                                                <div class="d-flex justify-content-start">
                                                        <div class="">
                                                        <p class="zone_detail" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="right" 
                                                            title="รายวัน ' . $row["pricePerDate"] . '฿<br>รายเดือน ' . $row["pricePerMonth"] . '฿">
                                                            โซน: <strong>' . $row["zone_name"] . '</strong><br>(' . $row["zone_detail"] . ')
                                                        </p>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                                    ';
            $sql2 = "SELECT * FROM locks WHERE zone_id = " . $row["zone_id"];
            if ($result2 = $conn->query($sql2)) {
                if ($result2->num_rows > 0) {
                    echo '<div class="d-flex flex-wrap container-md">';
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<div class="mx-2 ">
                                                        <p>';
                        if ($row2["available"] == 0) {
                            echo '
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                    </svg>';
                        } else if ($row2["available"] == 1) {
                            echo '
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z"/>
                                                </svg>';
                        }
                        echo '</p>
                                                        </div>';
                    }
                    echo '</div>';
                } else {
                    echo "<p>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</p>";
                }
                $result2->free();
            } else {
                echo "<p>Error in nested query: " . $conn->error . "</p>";
            }
        }
    } else {
        echo "<p><strong>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</strong></p>";
    }
    $result->free();
} else {
    echo "<p>Error in main query: " . $conn->error . "</p>";
}
?>

<!-- Available and Unavailable status legend -->
<div class="container-md d-flex justify-content-center p-2 m-2">
    <div class="px-2 mx-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
        </svg>
        <strong>ว่าง</strong>
    </div>
    <div class="px-2 mx-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z" />
        </svg>
        <strong>ไม่ว่าง</strong>
    </div>
</div>