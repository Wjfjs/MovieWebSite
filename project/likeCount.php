<?php
$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');

if (isset($_POST['movieNo']) && isset($_POST['likeNo']) && isset($_POST['checkLogin'])) {
    $movieNo = $_POST['movieNo'];
    $likeNo = explode(',', trim($_POST['likeNo']));
    $checkLogin = $_POST['checkLogin'];

    if ($checkLogin == "Y") {
        // 이미 좋아요한 영화인지 확인
        if (in_array($movieNo, $likeNo)) {
            // 좋아요 취소
            $likeImg = 'like';
            
            $unLike = implode(',', $likeNo);
            $setMovieNo = str_replace($movieNo . ',', '', $unLike);
            
            $sqlUpdateMLike = 'update member 
                                set LIKE_MOVIE_NO = :setMovieNo 
                                where USER_ID = :userId';
                                
            $stidUpdateMLike = oci_parse($conn, $sqlUpdateMLike);
            oci_bind_by_name($stidUpdateMLike, ':setMovieNo', $setMovieNo);
            oci_bind_by_name($stidUpdateMLike, ':userId', $userId);
            oci_execute($stidUpdateMLike);
            oci_free_statement($stidUpdateMLike);
            oci_commit($conn);
            
            // 영화의 좋아요 개수 업데이트
            $likeNum[0] -= 1;
            
            $sqlUpdateLike = 'update movie 
                                set LIKE_NUM = :likeCount
                                where NO = :NO';
            $stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
            oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
            oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
            oci_execute($stidUpdateLike);
            oci_free_statement($stidUpdateLike);
            oci_commit($conn);

            $response = array(
                'action' => 'unlike', // 좋아요 취소 액션
                'likeCount' => $likeCount // 업데이트된 좋아요 카운트
            );
            echo json_encode($response);
        } else {
            // 좋아요 추가
            $likeImg = 'afterLike';

            $setMovieNo = implode(',', $likeNo) . $movieNo . ',';
            
            $sqlUpdateMLike = 'update member 
                                set LIKE_MOVIE_NO = :setMovieNo 
                                where USER_ID = :userId';
                                
            $stidUpdateMLike = oci_parse($conn, $sqlUpdateMLike);
            oci_bind_by_name($stidUpdateMLike, ':setMovieNo', $setMovieNo);
            oci_bind_by_name($stidUpdateMLike, ':userId', $userId);
            oci_execute($stidUpdateMLike);
            oci_free_statement($stidUpdateMLike);
            oci_commit($conn);
            
            // 영화의 좋아요 개수 업데이트
            $likeNum[0] += 1;
            
            $sqlUpdateLike = 'update movie 
                                set LIKE_NUM = :likeCount
                                where NO = :NO';
            $stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
            oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
            oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
            oci_execute($stidUpdateLike);
            oci_free_statement($stidUpdateLike);
            oci_commit($conn);

            $response = array(
                'action' => 'like', // 좋아요 액션
                'likeCount' => $likeCount // 업데이트된 좋아요 카운트
            );
            echo json_encode($response);
        }
    } else {
        // 로그인되지 않은 경우 처리
        $likeImg = 'like';
        $response = array(
            'action' => 'login' // 로그인 필요 액션
        );
        echo json_encode($response);
    }
} else {
    // 필요한 파라미터가 전달되지 않은 경우 처리
    $response = array(
        'action' => 'error' // 에러 액션
    );
    echo json_encode($response);
}
?>
