<?php
    session_start();
    require_once(__DIR__.'/../database/connec.php');

    $conditions = array();
    $params = array();

    if (!empty($_POST['date'])) {
        $conditions[] = 'published >= :start_date AND published <= :end_date';
        $start_date = date('Y-m-d H:i:s', strtotime($_POST['date'] . ' UTC'));
        $end_date = date('Y-m-d H:i:s', strtotime($_POST['date'] . ' +1 day UTC'));
        $params[':start_date'] = $start_date;
        $params[':end_date'] = $end_date;
    }
    
    if (!empty($_POST['agent'])) {
        $conditions[] = 'agent = :agent';
        $params[':agent'] = $_POST['agent'];
    }
    
    if (!empty($_POST['status'])) {
        $conditions[] = 'status = :status';
        $params[':status'] = $_POST['status'];
    }
    
    if (!empty($_POST['priority'])) {
        $conditions[] = 'priority = :priority';
        $params[':priority'] = $_POST['priority'];
    }

    if ($_SESSION['type'] == 'agent') {
        $department = $_SESSION['id'];
        $dept = $conn->prepare('SELECT name FROM departments WHERE id = :department');
        $dept->bindParam(":department", $department);
        $dept->execute();
        $department = $dept->fetchColumn();
        if (!empty($department)) {
            $conditions[] = 'department = :department';
            $params[':department'] = $department;
        }
    }
    if (!empty($_POST['hashtag'])) {
        $hashtag = $_POST['hashtag'];
        if (!empty($hashtag)) {
            // Retrieve the hashtag ID based on the text
            $stmt = $conn->prepare('SELECT id FROM hashtag WHERE text = :hashtag');
            $stmt->bindParam(":hashtag", $hashtag);
            $stmt->execute();
            $hashtagId = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // If the hashtag ID exists, add it to the conditions
            if (!empty($hashtagId)) {
                $stmt = $conn->prepare('SELECT ticket_id FROM ticket_hashtag WHERE hashtag_id IN (SELECT id FROM hashtag WHERE text = :hashtag)');
                $stmt->bindParam(":hashtag",$hashtag);
                $stmt->execute();
                $ticketsIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $conditions[] = 'id IN (SELECT ticket_id FROM ticket_hashtag WHERE hashtag_id IN (SELECT id FROM hashtag WHERE text = :hashtag))';
                $params[':hashtag'] = $hashtag;
            }
        }
    }
    
    $where = '';
    if (!empty($conditions)) {
        $where = ' WHERE ' . implode(' AND ', $conditions);
    }
    
    $stmt = $conn->prepare("SELECT * FROM ticket $where");
    $stmt->execute($params);
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $hashtags_array = array();
    foreach($tickets as $ticket){
        $stmt = $conn->prepare('SELECT h.text FROM hashtag h
        INNER JOIN ticket_hashtag th ON h.id = th.hashtag_id
        WHERE th.ticket_id = :ticket_id');
        $stmt->bindParam(":ticket_id", $ticket['id']);
        $stmt->execute();
        $hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);//hashtag from the current ticket;
        $hashtags_array[] = $hashtags;
    }
    $data = array($tickets,$hashtags_array);

    echo json_encode($data);