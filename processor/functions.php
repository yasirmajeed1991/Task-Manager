<?php 

function get_loan_detail($id, $conn){
    $loan_detail = array();
    
    // Fetching loan_no
    $query = $conn->query('SELECT * FROM loan_no where id = "'.$id.'"');
    $result = $query->fetch_assoc();
    $loan_detail['loan_no'] = $result['loan_no'];
    
    // Fetching branch
    $query = $conn->query("SELECT b.branch
    FROM scrub s
    INNER JOIN loan_no ln ON s.loan_no_id = ln.id
    INNER JOIN branch b ON ln.branch = b.id
    WHERE s.loan_no_id =".$id);
    $result = $query->fetch_assoc();
    $loan_detail['branch'] = $result['branch'];
    
    // Fetching processor firstname and lastname
    $query = $conn->query("SELECT users.firstname,users.lastname
    FROM users
    JOIN loan_no ON loan_no.processor = users.id
    JOIN scrub ON scrub.loan_no_id = loan_no.id
    WHERE scrub.loan_no_id =".$id);
     $result = $query->fetch_assoc();
    $loan_detail['processor_name'] = $result['firstname'].' '.$result['lastname'];
    
    // Fetching coordinator firstname and lastname
    $query = $conn->query("SELECT loan_no.coordinator
    FROM scrub
    JOIN loan_no ON scrub.loan_no_id = loan_no.id where scrub.loan_no_id =".$id);
    $result = $query->fetch_assoc();
    $userIds = json_decode($result['coordinator']);
    $idsStr = implode(",", $userIds);
    $result = $conn->query("SELECT firstname, lastname FROM users WHERE id IN ($idsStr)");
    // Fetch the results and store them in an array of arrays
    $userData = array();
    while ($row23 = $result->fetch_assoc()) {
        $userData[] = $row23['firstname'].' '.$row23['lastname'];
    }
    $loan_detail['coordinator_names'] = $userData;
    
    // Fetching coordinator borrower
    $query = $conn->query("SELECT * FROM borrower WHERE loan_no_id=".$id." ");
    $borrower_data = array();
    while ($borrower_result = $query->fetch_assoc()) {
        $borrower_data[] = $borrower_result['borrower'];
    }
    $loan_detail['borrowers'] = $borrower_data;
    
    return $loan_detail;
}


function find_loan_id($id, $conn){
    // Fetching loan_no
    $query = $conn->query('SELECT * FROM scrub where id = "'.$id.'"');
    $result = $query->fetch_assoc();
    return $result['loan_no_id'];
    
}

function find_loan_id_orderOuts($id, $conn){
    // Fetching loan_no
    $query = $conn->query('SELECT * FROM scrub where loan_no_id = "'.$id.'"');
    $result = $query->fetch_assoc();
    return $result['loan_no_id'];
    
}

function type_of_request($id, $conn){
    // Fetching loan_no
    $query = $conn->query('SELECT * FROM type_of_request where id = "'.$id.'"');
    $result = $query->fetch_assoc();
    return $result['type_of_request'];
    
}

?>