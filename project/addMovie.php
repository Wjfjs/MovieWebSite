<?php
    $conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
    $user = $_POST['user'];
    $no = $_POST['no'];
    $krName = $_POST['krName'];
    $enName = $_POST['enName'];
    $drctr = $_POST['drctr'];
    $makr = $_POST['makr'];
    $incme = $_POST['incme'];
    $distb = $_POST['distb'];
    $mkDate = $_POST['mkDate'];
    $country = $_POST['country'];
    $scrnCount = $_POST['scrnCount'];
    $viewCount = $_POST['viewCount'];
    $genre = $_POST['genre'];
    $grand = $_POST['grand'];
    $poster = $_POST['poster'];
    $trailer = $_POST['trailer'];
    $story = $_POST['story'];
    $runTime = $_POST['runTime'];
    $likeNum = $_POST['likeNum'];
    $openNum = $_POST['openNum'];
    $manageId = $_POST['manageId'];

    $sqlInsertMovie = "INSERT INTO movie (NO";
    $bindNames = ":no";
    $bindValues = $no;
    
    $fields = array(
        'krName' => 'KR_NAME',
        'enName' => 'EN_NAME',
        'drctr' => 'DRCTR',
        'makr' => 'MAKR',
        'incme' => 'INCME',
        'distb' => 'DISTB',
        'mkDate' => 'MK_DATE',
        'country' => 'COUNTRY',
        'scrnCount' => 'SCRN_COUNT',
        'viewCount' => 'VIEW_COUNT',
        'genre' => 'GENRE',
        'grand' => 'GRAND',
        'poster' => 'POSTER',
        'trailer' => 'TRAILER',
        'story' => 'STORY',
        'runTime' => 'RUN_TIME',
        'likeNum' => 'LIKE_NUM',
        'openNum' => 'OPEN_NUM',
        'manageId' => 'MANAGE_MEMBER_ID'
    );

    foreach ($fields as $input => $column) {
        if (!empty($$input)) {
            $sqlInsertMovie .= ", $column";
            $bindNames .= ", :$input";
            $bindValues .= ", " . $$input;
        }
    }

    $sqlInsertMovie .= ") VALUES (" . $bindNames . ")";
    $stidInsertMovie = oci_parse($conn, $sqlInsertMovie);

    // 바인딩된 변수에 대한 처리
    $bindNamesArr = explode(", ", $bindNames);
    $bindValuesArr = explode(", ", $bindValues);

    for ($i = 0; $i < count($bindNamesArr); $i++) {
        oci_bind_by_name($stidInsertMovie, $bindNamesArr[$i], $bindValuesArr[$i]);
    }

    oci_execute($stidInsertMovie);
    oci_commit($conn);

    oci_free_statement($stidInsertMovie);
    oci_close($conn);
?>
