const { createHigherOrderComponent } = wp.compose;

var largo_core_image_block_add_media_credit = createHigherOrderComponent( function ( BlockListBlock ) {

  return function ( props ) {

    if( props.name === 'core/image' ){

        var attachment_id = props.attributes.id;
        var media = new wp.api.models.Media( { id: attachment_id } );

        var media_response = media.fetch().then( function( media ) {

            // the original instance of the media caption
            var attachment_caption = props.attributes.caption;

            if( media.media_credit && ( media.media_credit._media_credit || media.media_credit._navis_media_credit_org ) ){

                // if both the credit and organization are present
                if( media.media_credit._media_credit && media.media_credit._navis_media_credit_org ){

                    var media_credit = media.media_credit._media_credit+' / '+media.media_credit._navis_media_credit_org;
                
                // if only the credit is present
                } else if( media.media_credit._media_credit ){

                    var media_credit = media.media_credit._media_credit;

                // if only the org is present
                } else if( media.media_credit._navis_media_credit_org ){

                    var media_credit = media.media_credit._navis_media_credit_org;

                }

                // if the media credit url exists, wrap the media credit with it
                if( media.media_credit._media_credit_url ){

                    var media_credit = '<a href="'+media.media_credit._media_credit_url+'">'+media_credit+'</a>';

                }

                // our full media credit
                var media_credit = '<p class="wp-media-credit">'+media_credit+'</p>';

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
