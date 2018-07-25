<?php

class PostTemplatesTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();
	}

	function test_get_post_templates() {
		$this->markTestIncomplete( 'This test has not yet been implemented.' );
	}

	function test_post_templates_dropdown() {
		$this->markTestIncomplete( 'This test has not yet been implemented.' );
	}

	function test_get_post_template() {
		$this->markTestIncomplete( 'This test has not yet been implemented.' );
	}

	function test_is_post_template() {
		$this->markTestIncomplete( 'This test has not yet been implemented.' );
	}

	function test_largo_remove_hero() {
		// returns unchanged when:
		//     global $post is not set
		//     the current $post does not have a featured media thumbnail
		//     of_get_option('single_template') is not normal or classic
		//     the first paragraph of the post contents doesn't have an image
		//     the image in the first paragraph has a different src and attachment id than the post's featured media thumbnail
		//     the image in the first paragraph has the same src, or has a different src but the same id, and the image's classes include 'size-small' or 'size-medium'
		//
		// Otherwise, the first paragraph is removed from the post contents

		$this->markTestIncomplete( 'This test has not yet been implemented.' );
	}

	private $ids = array();

	function test_insert_image_no_thumb() {

		$filename = ( dirname(__FILE__) .'/../mock/img/cat.jpg' );
		$contents = file_get_contents( $filename );

		$upload = wp_upload_bits( basename( $filename ), null, $contents );

		print_r( $upload['error'] );
		$this->assertTrue( empty( $upload['error'] ) );

		$attachment_id = $this->_make_attachment( $upload );

		$attachment_url = wp_get_attachment_image_src( $attachment_id, 'large' );
		$attachment_url = $attachment_url[0];

		// create our post and set it up.
		$post_id = $this->factory->post->create();
		add_post_meta( $post_id, '_thumbnail_id', $attachment_id );
		$this->go_to( '/?p=' . $post_id );

		// with a post set up like so, remove the thing
		$c1 = '<p><img src="' . $attachment_url . '" alt="1559758083_cef4ef63d2_o" width="771" height="475" class="alignnone size-large wp-image-' . $attachment_id . '" /></p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$c1final = '<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$final1 = largo_remove_hero( $c1 );
		$this->assertEquals( $c1final, $final1, "C1" );

		// with a post set up like so, remove the thing
		// @todo: how is this setup different that the above setup?
		$c2 = '<p><img src="' . $attachment_url . '" alt="1559758083_cef4ef63d2_o" width="771" height="475" class="alignnone size-medium wp-image-' . $attachment_id . '" /></p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$c2final = '<p><img src="' . $attachment_url . '" alt="1559758083_cef4ef63d2_o" width="771" height="475" class="alignnone size-medium wp-image-' . $attachment_id . '" /></p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$final2 = largo_remove_hero( $c2 );
		$this->assertEquals( $c2final, $final2, "C2" );

		// test for https://github.com/INN/largo/pull/1503#issuecomment-407901229
		// if the opening paragraph tag contains a matching image and other stuff,
		// remove the matching image but nothing else
		$c3 = '<p><img src="' . $attachment_url . '" alt="1559758083_cef4ef63d2_o" width="771" height="475" class="alignnone size-large wp-image-' . $attachment_id . '" />foo</p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$c3final = '<p>foo</p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$final3 = largo_remove_hero( $c3 );
		$this->assertEquals( $c3final, $final3, "C3" );

		// don't remove the image if it doesn't match the attachment URL
		$c4 = '<p><img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Dr._James_Naismith.jpg" alt="1559758083_cef4ef63d2_o" width="771" height="475" class="alignnone size-large wp-image-' . $attachment_id . '" /></p>
<h2>Headings</h2>
<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec sed odio dui.</p>';
		$final4 = largo_remove_hero( $c4 );
		$this->assertEquals( $c4, $final4, "C4" );
	}

	function _make_attachment( $upload, $parent_post_id = 0 ) {

		$type = '';
		if ( !empty( $upload['type'] ) ) {
			$type = $upload['type'];
		} else {
			$mime = wp_check_filetype( $upload['file'] );
			if ( $mime )
				$type = $mime['type'];
		}

		$attachment = array(
			'post_title' => basename( $upload['file'] ),
			'post_content' => '',
			'post_type' => 'attachment',
			'post_parent' => $parent_post_id,
			'post_mime_type' => $type,
			'guid' => $upload[ 'url' ],
		);

		// Save the data
		$id = wp_insert_attachment( $attachment, $upload[ 'file' ], $parent_post_id );
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

		return $this->ids[] = $id;

	}

	function test_largo_get_partial_by_post_type() {
		$ret = largo_get_partial_by_post_type( 'foo', 'bar', 'baz' );
		$this->assertEquals( $ret, 'foo' ); // dummy test so that this test will run. Mostly we're just asserting that the function doesn't cause errors.
		$this->markTestIncomplete();
	}

}
