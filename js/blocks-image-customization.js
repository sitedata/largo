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

            var attachment_caption = attribute.caption;

            if( attachment_caption.includes( media.media_credit ) ){

                return;

            } else {

                var attachment_caption = attachment_caption + '<br/><span class="largo-attachment-media-credit">' + media.media_credit + '</span>';

                return Object.assign( attribute, { caption: attachment_caption } );

            }
        });
    }
}

wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'largo-core-block-customizations/get-save-content/extra-props',
    largo_core_image_block_add_media_credit
);