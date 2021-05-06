<?php

// Include avatars module
include_once dirname(__FILE__) . '/avatars/functions.php';

/**
 * Determine whether or not an author has a valid gravatar image
 * see: https://codex.wordpress.org/Using_Gravatars
 *
 * @param $email string an author's email address
 * @return bool true if a gravatar is available for this user
 * @since 0.3
 */
function largo_has_gravatar( $email ) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );

	$cache_key = 'largo_has_gravatar_' . $hash;
	if ( false !== ( $cache_value = get_transient( $cache_key ) ) ) {
		return (bool) $cache_value;
	}

	$uri = 'https://www.gravatar.com/avatar/' . $hash . '?d=404';
	$response = wp_remote_head( $uri );
	if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
		$cache_value = '1';
	} else {
		$cache_value = '0';
	}
	set_transient( $cache_key, $cache_value );
	return (bool) $cache_value;
}

/**
 * Determine whether or not a user has an avatar. Fallback checks if user has a gravatar.
 *
 * @param $email string an author's email address
 * @return bool true if an avatar is available for this user
 * @since 0.4
 */
function largo_has_avatar( $email ) {
	$user = get_user_by( 'email', $email );
	if ( ! empty( $user ) ) {
		$result = largo_get_user_avatar_id( $user->ID );
		if ( ! empty ( $result ) ) {
			return true;
		} else {
			if ( largo_has_gravatar( $email ) ) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Filter the get_avatar function to allow it to return the custom
 * largo_avatar metafield value if it exists.
 * 
 * @see: https://github.com/INN/largo/issues/1864
 * 
 * @param string $avatar HTML for the user's avatar
 * @param mixed $id_or_email The (gr)avatar to retrieve
 * @param array $args Arguements passed to get_avatar_url()
 * 
 * @return string $avatar HTML for the user's avatar
 */
function largo_get_avatar_custom_avatar( $avatar, $id_or_email, $args ) {

    $user = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {

            $id = (int) $id_or_email->user_id;
			$user = get_user_by( 'id' , $id );

        }

    } else {

		$user = get_user_by( 'email', $id_or_email );	

    }

    if ( $user && is_object( $user ) ) {

		if( function_exists( 'largo_has_avatar' ) && function_exists( 'largo_get_user_avatar_id' ) ) {
			if( largo_has_avatar( $user->user_email ) ) {
				$avatar = wp_get_attachment_image( largo_get_user_avatar_id( $user->ID ), 96, false, array( 'alt' => $user->display_name ) );
			}
		}

    }

	return $avatar;

}
add_filter( 'pre_get_avatar' , 'largo_get_avatar_custom_avatar', 10 , 3 );