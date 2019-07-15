const {assign} = lodash;

function largo_core_image_block_add_media_credit( element, blockType, attribute ){

    if( blockType.name === 'core/image' ){

        var attachment_id = attribute.id;
        var media = new wp.api.models.Media( { id: attachment_id } );

        var media_response = media.fetch().then( function( media ) {

            // the original instance of the media caption
            var attachment_caption = attribute.caption;

            if( media.media_credit && media.media_credit._media_credit ){

                // our default media credit, if it exists 
                var media_credit = '<p class="wp-media-credit">' + media.media_credit._media_credit + '</p>';

                // if our media credit has a url, include that also
                if( media.media_credit._navis_media_credit_org ){

                    var media_credit = '<p class="wp-media-credit">'+media.media_credit._media_credit+' / '+media.media_credit._navis_media_credit_org+'</p>';

                }

                // if our media attachment caption already includes `largo-attachment-media-credit`,
                // which is the class of our span, don't do anything more
                if( attachment_caption.includes( 'wp-media-credit' ) ){

                    return;
                
                // else, our media credit probably doesn't exist. let's add it in
                } else {

                    var attachment_caption = media_credit + attachment_caption;

                    // return our attribute with its new caption
                    return Object.assign( attribute, { caption: attachment_caption } );

                }

            }

        });
    }
}

wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'largo-core-block-customizations/get-save-content/extra-props',
    largo_core_image_block_add_media_credit
);