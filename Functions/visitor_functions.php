<?php
include 'Functions/connectdb.php';

// ✅ Get all visitors
function getAllVisitors() {
    $conn = Connect();
    $sql = "SELECT * FROM visitors ORDER BY date_of_visit DESC";
    $result = $conn->query($sql);
    $visitors = [];
    while ($row = $result->fetch_assoc()) {
        $visitors[] = $row;
    }
    return $visitors;
}

// ✅ Get visitors by specific date
function getVisitorsByDate($date) {
    $conn = Connect();
    $stmt = $conn->prepare("SELECT * FROM visitors WHERE DATE(date_of_visit) = ? ORDER BY date_of_visit DESC");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $visitors = [];
    while ($row = $result->fetch_assoc()) {
        $visitors[] = $row;
    }
    return $visitors;
}

// ✅ Count visitors today OR by filter date
function countToday($date = null) {
    $conn = Connect();
    if ($date) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM visitors WHERE DATE(date_of_visit) = ?");
        $stmt->bind_param("s", $date);
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM visitors WHERE DATE(date_of_visit) = CURDATE()");
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'];
}

// ✅ Count visitors by category (Exam, Visit, Inquiry) with optional filter date
function countByCategory($category, $date = null) {
    $conn = Connect();
    if ($date) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM visitors WHERE purpose = ? AND DATE(date_of_visit) = ?");
        $stmt->bind_param("ss", $category, $date);
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM visitors WHERE purpose = ? AND DATE(date_of_visit) = CURDATE()");
        $stmt->bind_param("s", $category);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'];
}

// ✅ Delete visitor
function deleteVisitor($id) {
    $conn = Connect();
    $stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// ✅ Add new visitor
function addVisitor($name, $contact, $address, $school_office, $purpose, $date_of_visit) {
    $conn = Connect();
    $stmt = $conn->prepare("INSERT INTO visitors (name, contact_number, address, school_office, purpose, date_of_visit) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $contact, $address, $school_office, $purpose, $date_of_visit);
    return $stmt->execute();
}

// ✅ Update visitor
function updateVisitor($id, $name, $contact, $address, $school_office, $purpose, $date_of_visit) {
    $conn = Connect();
    $stmt = $conn->prepare("UPDATE visitors 
                            SET name=?, contact_number=?, address=?, school_office=?, purpose=?, date_of_visit=? 
                            WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $contact, $address, $school_office, $purpose, $date_of_visit, $id);
    return $stmt->execute();
}

// ✅ Get single visitor by ID (for edit form)
function getVisitorById($id) {
    $conn = Connect();
    $stmt = $conn->prepare("SELECT * FROM visitors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
