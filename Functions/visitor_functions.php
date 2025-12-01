<?php
include 'connectdb.php';

// bilang ng visitors ngayong araw
function countToday(){
    $conn = Connect();
    $today = date('Y-m-d'); // kunin ang current date gamit PHP
    $query = "SELECT COUNT(*) as total FROM visitors WHERE date_of_visit = '$today'";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// bilang ng visitors ayon sa purpose (Exam, Visit, Inquiry)
function countByCategory($purpose){
    $conn = Connect();
    $query = "SELECT COUNT(*) as total FROM visitors WHERE purpose='$purpose'";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// kunin lahat ng visitors
function getAllVisitors(){
    $conn = Connect();
    $query = "SELECT * FROM visitors ORDER BY date_of_visit DESC";
    $result = $conn->query($query);
    $data = [];
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    $conn->close();
    return $data;
}

// magdagdag ng bagong visitor
function addVisitor($name, $date, $contact, $address, $school, $purpose){
    $conn = Connect();
    $query = "INSERT INTO visitors (name, date_of_visit, contact_number, address, school_office, purpose)
              VALUES ('$name','$date','$contact','$address','$school','$purpose')";
    $result = $conn->query($query);
    $conn->close();
    return $result;
}

// i-update ang existing visitor
function updateVisitor($id, $name, $date, $contact, $address, $school, $purpose){
    $conn = Connect();
    $query = "UPDATE visitors 
              SET name='$name', date_of_visit='$date', contact_number='$contact',
                  address='$address', school_office='$school', purpose='$purpose'
              WHERE id='$id'";
    $result = $conn->query($query);
    $conn->close();
    return $result;
}

// burahin ang visitor
function deleteVisitor($id){
    $conn = Connect();
    $query = "DELETE FROM visitors WHERE id='$id'";
    $result = $conn->query($query);
    $conn->close();
    return $result;
}

// 🔎 bagong function: kunin visitors ayon sa date
function getVisitorsByDate($date){
    $conn = Connect();
    $query = "SELECT * FROM visitors WHERE date_of_visit = '$date' ORDER BY name ASC";
    $result = $conn->query($query);
    $data = [];
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    $conn->close();
    return $data;
}
?>
