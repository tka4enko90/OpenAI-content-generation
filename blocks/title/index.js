import { addFilter } from '@wordpress/hooks'
import { createHigherOrderComponent } from '@wordpress/compose'
import { Fragment, useState } from '@wordpress/element'
import { InspectorControls } from '@wordpress/block-editor'
import { Panel, PanelBody, Button, Modal, Spinner} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { addQueryArgs } from '@wordpress/url';
import apiFetch from '@wordpress/api-fetch';
// addFilter(
//     'blocks.registerBlockType',
//     'extending-gutenberg/add-attributes',
//     (props, name) => {
//         // if not core paragraph block just return props
//         if (name !== 'core/post-title') {
//             return props
//         }
//
//         // extend attributs with the new extendedSettings object
//         const attributes = {
//             ...props.attributes,
//             extendedSettings: {
//                 type: 'object',
//                 default: {},
//             }
//         };
//         return {...props, attributes}
//     }
// );
const withInspectorControls = createHigherOrderComponent( ( BlockEdit ) => {

    return ( props ) => {

        if (props.name !== 'core/post-title') {
            return (
                <BlockEdit {
                    ...props
                }
            />
        )
        }

        const [ isOpen, setOpen ] = useState( false );
        const [ posts, setPosts ] = useState( '' );
        const [ isLoader, setLoader ] = useState( false );

        const closeModal = () => {
            setPosts([]);
            setOpen( false );
        }
        let content = useSelect( 'core/editor' ).getBlocks().filter( (i) => i.name === 'core/paragraph' || i.name === 'core/heading' );
        let temp = '';
         content.map((item) => {
             temp += item.attributes.content
        });
        const openModal = () => {
            const queryParams = { content: temp };
            console.log(queryParams);
            setOpen( true );
            setLoader( true );
            apiFetch( { path: addQueryArgs('/mopen_ai/v1/get-titles', queryParams )} ).then( ( posts ) => {
                console.log(JSON.parse(posts));
                setPosts(JSON.parse(posts));
                setLoader(false)
            } );
        };


        return (
            <Fragment>
                <BlockEdit { ...props } />
            <InspectorControls key="setting">
                <Panel>
                    <PanelBody title="Open Ai title" initialOpen={ true }>
                        <Button
                            variant="secondary"
                            onClick = {openModal}
                                >Generate titles for articles
                         </Button>

                        { isOpen && (
                        <Modal title="Most Relevant Headings" onRequestClose={ closeModal }>
                            <div class="components-modal__body">
                            {isLoader && (
                                <div class="components-modal__loader">
                                    <Spinner />
                                </div>
                              )
                            }
                            { posts && (
                                posts.map((item, i) => {
                                return (
                                    <div class='components-modal__item'>{`${i+1}) ${item}`}</div>
                               )
                            })
                            )
                            }
                            </div>

                        </Modal>
                        ) }
                     </PanelBody>
                 </Panel>
            </InspectorControls>
    </Fragment>
    )}
}, 'withInspectorControls');

addFilter(
    'editor.BlockEdit',
    'extending-gutenberg/edit',
    withInspectorControls
);

