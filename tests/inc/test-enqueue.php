<?php

class EnqueueTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();
	}

	function test_largo_enqueue_js() {
		// Modernizr
		$this->markTestIncomplete('This test has not been implemented yet.');
		// the jquery plugins
		$this->markTestIncomplete('This test has not been implemented yet.');
		// our main JS file
		$this->markTestIncomplete('This test has not been implemented yet.');
		// only load jquery tabs for the related content box if it's active
		$this->markTestIncomplete('This test has not been implemented yet.');
		// Load the child theme's style.css if we're actually running a child theme of Largo
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_largo_enqueue_admin_scripts() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_largo_header_js() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_largo_footer_js() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function largo_google_analytics() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
}

class EnqueueTestFunctions_Gutenberg extends WP_UnitTestCase {
	function setUp() {
		if ( getenv( 'GUTENBERG' ) != 1 ) {
			$this->markTestSkipped( 'Skipping Gutenberg tests in non-gutenberg environment' );
		}

		parent::setUp();
	}

	// helper to activate gutenberg
	function activate_gutenberg() {
	}

	// helper to deactivate gutenberg
	function deactivate_gutenberg() {
	}

	function test_activate_gutenberg() {
		$this->activate_gutenberg();

		// test that Gutenberg exists as we expect it to exist
		$this->assertTrue(
			function_exists( 'the_gutenberg_project' ),
			'Attempted to activate Gutenberg, but it looks like the function `the_gutenberg_project()` was not defined. Did that function name change? It is what we use to decide whether to enqueue css/gutenberg.css'
		);
		$this->activate_gutenberg();
		$this->deactivate_gutenberg();
	}

	function test_largo_gutenberg_frontend_css_js() {
		$this->activate_gutenberg();
		largo_gutenberg_frontend_css_js();
		// assertTrue that the stylesheet 'largo-stylesheet-gutenberg' is enqueued
		$this->deactivate_gutenberg();
	}

	function test_largo_gutenberg_editor_css_js() {
		$this->activate_gutenberg();
		largo_gutenberg_editor_css_js();
		$this->deactivate_gutenberg();
	}
}
