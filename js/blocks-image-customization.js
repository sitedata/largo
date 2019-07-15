const { createHigherOrderComponent } = wp.compose;

var largo_core_image_block_add_media_credit = createHigherOrderComponent( function ( BlockListBlock ) {

  return function ( props ) {

    if( props.name === 'core/image' ){

        var attachment_id = props.attributes.id;
        var media = new wp.api.models.Media( { id: attachment_id } );

        var media_response = media.fetch().then( function( media ) {

            // the original instance of the media caption
            var attachment_caption = props.attributes.caption;

            if( media.media_credit && media.media_credit._media_credit ){

                // our default media credit, if it exists 
                var media_credit = '<p class="wp-media-credit">' + media.media_credit._media_credit + '</p>';

                // if our media credit has a url, include that also
                if( media.media_credit._navis_media_credit_org ){

                    var media_credit = '<p class="wp-media-credit">'+media.media_credit._media_credit+' / '+media.media_credit._navis_media_credit_org+'</p>';

                }

                // if our media attachment caption already includes `largo-attachment-media-credit`,
                // which is the class of our span, don't do anything more
                if( ! attachment_caption.includes( 'wp-media-credit' ) ){

                    var attachment_caption = media_credit + attachment_caption;

                    props.attributes.caption = attachment_caption;
                    
                }

            }

        });

    }

    return React.createElement( BlockListBlock, props );

  };

}, 'largo_core_image_block_add_media_credit');
 
wp.hooks.addFilter( 
    'editor.BlockEdit', 
    'largo-core-block-customizations/editor/block-edit', 
    largo_core_image_block_add_media_credit 
);
