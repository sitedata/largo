const {assign} = lodash;
const { addFilter } = wp.hooks;
const { __ } = wp.i18n;

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.editor;
const { PanelBody, SelectControl } = wp.components;

function largo_core_image_block_add_media_credit( element, blockType, attribute ){

    if( blockType.name === 'core/image' ){

        var attachment_id = attribute.id;
        var media = new wp.api.models.Media( { id: attachment_id } );

        var media_response = media.fetch().then( function( media ) {

            // the original instance of the media caption
            var attachment_caption = attribute.caption;

            if( media.media_credit && media.media_credit._media_credit ){

                // our default media credit, if it exists 
                var media_credit = '<span class="largo-attachment-media-credit">' + media.media_credit._media_credit + '</span>';

                // if our media credit has a url, include that also
                if( media.media_credit._media_credit_url ){

                    var media_credit = '<span class="largo-attachment-media-credit"><a href="'+media.media_credit._media_credit_url+'" target="_blank" rel="noopener noreferrer">'+media.media_credit._media_credit+'</a></span>';

                }

                // if our media attachment caption already includes `largo-attachment-media-credit`,
                // which is the class of our span, don't do anything more
                if( attachment_caption.includes( 'largo-attachment-media-credit' ) ){

                    return;
                
                // else, our media credit probably doesn't exist. let's add it in
                } else {

                    var attachment_caption = attachment_caption + '<br/>' + media_credit;

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