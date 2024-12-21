<?php
	session_start();
	
	$userId = isset($_SESSION["FId"]) ? $_SESSION["FId"] : "";
	$movieNo = $_POST['movieNO'];
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'AL32UTF8');
	$sqlSelectMember = 'select CHECK_LOGIN, LIKE_MOVIE_NO
					from member
					where USER_ID = :id';

	$stidSelectMember = oci_parse($conn, $sqlSelectMember);
	oci_bind_by_name($stidSelectMember, ':id', $userId);
	oci_execute($stidSelectMember);

	$count = 0;
	while (($row = oci_fetch_array($stidSelectMember, OCI_ASSOC)) != false) {    
		$checkLogin[$count] = $row["CHECK_LOGIN"];
		$likeMovie[$count] = $row["LIKE_MOVIE_NO"];
		$count++;
	}
	
	oci_free_statement($stidSelectMember);
	
	$likeNo = explode(',', trim($likeMovie[0]));
	
	if ($checkLogin[0] == "Y" AND $userId != '') {

		// 이미 좋아요한 영화인지 확인
		if (in_array($movieNo, $likeNo)) {	//한 번더 눌르면 좋아요가 사라진다
			
			$delete .= ','.$movieNo;
			$setMovieNo = implode(',', $likeNo);
			$setMovieNo = str_replace($delete, '', $setMovieNo);
			
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
			if ($likeNum[0] == 1) {
				$likeNum[0] = 0;
			}
			else {
				$likeNum[0]--;
			}
			
			$sqlUpdateLike = 'update movie 
						set LIKE_NUM = :likeCount
						where NO = :NO';
			$stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
			oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
			oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
			oci_execute($stidUpdateLike);
			oci_free_statement($stidUpdateLike);
			oci_commit($conn);
			oci_close($conn);
		}
		else {	//좋아요 추가
			$response = 'afterLike';
			// 좋아요한 영화번호에 현재 영화번호 추가
			$setMovieNo = implode(',', $likeNo);	//배열인 likeNo를 문자열로 변환
			$setMovieNo .= ','.$movieNo;

			// 회원의 좋아요한 영화번호 업데이트
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
			$likeNum[0]++;
			
			$sqlUpdateLike = 'update movie 
						set LIKE_NUM = :likeCount
						where NO = :NO';
			$stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
			oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
			oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
			oci_execute($stidUpdateLike);
			oci_free_statement($stidUpdateLike);
			oci_commit($conn);
			oci_close($conn);
		}
		
	}
	echo "
		<script type=\"text/javascript\">
			alert(\"로그인해야 사용가능합니다.\");		
			history.back();
		</script>
	";	
	oci_close($conn);
?>