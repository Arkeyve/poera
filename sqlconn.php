<?php
session_start();

function getconn() {
	return mysqli_connect("localhost", "root", "Ownedu@11", "poera");
}

function filter( &$value ) {
	$value = mysqli_real_escape_string( getconn(), $value );
}

function signup( $name, $phone, $email, $password ) {
	$query = mysqli_query( getconn(), "
		SELECT user_id 
		FROM users 
		WHERE email = '".$email."'" 
	);
	if( mysqli_num_rows($query) > 0 ) {
		return false;
	} else {
		if( $query = mysqli_query( getconn(), "insert into users(`email`, `password`, `name`, `phone`, `user_type`) values('".$email."', '".$password."', '".$name."', '".$phone."', 0)" ) ) {
			return true;	
		} else {
			return false;
		}
	}
}

function login( $email, $password ) {
	$query = mysqli_query( getconn(), "
		SELECT user_id 
		FROM users 
		WHERE email = '".$email."' and password = '".$password."'
	");
	if( mysqli_num_rows( $query ) == 1 ) {
		$row = mysqli_fetch_array( $query );
		$_SESSION['user_id'] = $row['user_id'];
		return true;
	} else {
		return false;
	}
}

function is_valid() {
	if( isset( $_SESSION['user_id'] ) ) {
		return true;
	} else {
		return false;
	}
}

function insert_poem( $user_id, $title, $content, $genre_id ) {
	if( mysqli_query( getconn(), "
		INSERT INTO `poems`(`user_id`, `title`, `content`, `time_of_post`, `genre_id`, `likes`, `dislikes`) 
		VALUES (".$user_id.", '".$title."','".$content."',CURRENT_TIMESTAMP, ".$genre_id.",0,0)
	") ) {
		return true;
	} else {
		return false;
	}
}

function update_user_genre_visit( $user_id, $genre_id ) {
	$query = mysqli_query( getconn(), "
		SELECT * 
		FROM user_genre_visits 
		WHERE user_id = ".$user_id." AND genre_id = ".$genre_id 
	);
	if( mysqli_num_rows( $query ) == 0 ) {
		mysqli_query( getconn(), "
			INSERT INTO user_genre_visits 
			VALUES(".$user_id.", ".$genre_id.", 1)" 
		);
	} else {
		mysqli_query( getconn(), "
			UPDATE user_genre_visits 
			SET count = count + 1 
			WHERE user_id = ".$user_id." AND genre_id = ".$genre_id 
		);
	}
}

function add_comment( $user_id, $poem_id, $comment ) {
	mysqli_query( getconn(), "
		INSERT INTO `comments`(`user_id`, `poem_id`, `comment`) 
		VALUES (".$user_id.",".$poem_id.",'".$comment."')
	");
}

function like( $user_id, $poem_id ) {
	$check_user = mysqli_query( getconn(), "
		SELECT * 
		FROM user_likes 
		WHERE user_id = ".$user_id." AND poem_id = ".$poem_id 
	);
	if( mysqli_num_rows( $check_user ) == 0 ) {
		mysqli_query( getconn(), "
			INSERT INTO user_likes 
			VALUES(".$user_id.", ".$poem_id.")
		");
		mysqli_query( getconn(), "
			UPDATE poems 
			SET likes = likes + 1 
			WHERE poem_id = ".$poem_id 
		);
	} else {
		return false;
	}
}

function dislike( $user_id, $poem_id ) {
	$check_user = mysqli_query( getconn(), "
		SELECT * 
		FROM user_dislikes 
		WHERE user_id = ".$user_id." AND poem_id = ".$poem_id 
	);
	if( mysqli_num_rows( $check_user ) == 0 ) {
		mysqli_query( getconn(), "
			INSERT INTO user_dislikes 
			VALUES(".$user_id.", ".$poem_id.")
		");
		mysqli_query( getconn(), "
			UPDATE poems 
			SET dislikes = dislikes + 1 
			WHERE poem_id = ".$poem_id 
		);
	} else {
		return false;
	}
}

function send_pm( $user_id, $email, $message ) {
	$to_user_id = mysqli_fetch_array( 
		mysqli_query( getconn(), "
			SELECT user_id 
			FROM users 
			WHERE email = '".$email."'
		")
	)[0];
	if( empty($to_user_id) ) {
		return false;
	} else {
		if( mysqli_query( getconn(), "
			INSERT INTO user_pm(`from_user_id`, `to_user_id`, `message`) 
			VALUES(".$user_id.", ".$to_user_id.", '".$message."')
		") ) {
			return true;
		} else {
			return false;
		}
	}
} 

?>