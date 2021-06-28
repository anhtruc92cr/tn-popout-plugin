<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.tn.com
 * @since      1.0.0
 *
 * @package    tn_Popup
 * @subpackage tn_Popup/public/partials
 */


if( !function_exists('render_poup')){
	/**
	 
	 *
	 * render popup template
	 *
	 * @since 1.0
	 *
	 *
	 * @param Object $post the popup post
	 * @param integer $current_page
	 * @return void
	 */
	function render_poup($post, $current_page){
		$hide_modal_title  = get_post_meta( 'hide_modal_title', $item->ID );
		$hide_modal_footer = get_post_meta( 'hide_modal_footer', $item->ID );
		?>
		<div class="modal" tabindex="-1" role="dialog" id="modal-<?php echo $item->ID; ?>">
		  <div class="modal-dialog tn-modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<?php if (  'Yes' != $hide_modal_title  ) : ?>
				<h5 class="modal-title"><?php echo $item->post_title; ?></h5>
				<?php endif; ?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<?php echo apply_filters( 'the_content', $item->post_content ); ?>
			  </div>
			  <?php if ( 'Yes' != $hide_modal_footer  ) : ?>
			  <div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			<?php endif; ?>
			</div>
		  </div>
		</div>
		<?php		
	}
}