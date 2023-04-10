import { useState, useEffect } from '@wordpress/element'
import {Notice, Button, Modal, Spinner} from '@wordpress/components';
import { useSelect, select, dispatch} from '@wordpress/data';
import { addQueryArgs } from '@wordpress/url';
import apiFetch from '@wordpress/api-fetch';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';

const MOpenAISidebar = () => {
    const [ isOpen, setOpen ] = useState( false );
    const [ isNotice, setNotice ] = useState( false );
    const [ restNotice, setRestNotice ] = useState( '' );
    const [ posts, setPosts ] = useState( [] );
    const [ excerpts, setExcerpts ] = useState( [] );
    const [ isLoader, setLoader ] = useState( false );
    const [ modalHeader, setModalHeader ] = useState( '' );
    const [ errors, setErrors ] = useState( '' );

    const closeModal = () => {
        setPosts([]);
        setExcerpts([]);
        setErrors('');
        setNotice('');
        setOpen( false );
    };
    let fetchRequest  = (param, queryParams ) => {
        return apiFetch( { path: addQueryArgs(`/mopen_ai/v1/${param}`, queryParams )} );
    };

    let content = useSelect( 'core/editor' ).getBlocks().filter( (i) => i.name === 'core/paragraph' || i.name === 'core/heading' );
    let temp = '';
    content.map((item) => {
        temp += item.attributes.content
    });
    const dispatchTitle = (title) => {
        if (title) {
            const postId = select('core/editor').getCurrentPostId();
            dispatch('core/editor').editPost({title: title, id: postId})
            const titleBlock = select('core/editor').getBlocks().find(block => block.name === 'core/post-title');
            if (titleBlock) {
                    // Update the title attribute
                    dispatch('core/block-editor').updateBlockAttributes(titleBlock.clientId, {title: title});
                    dispatch('core/editor').editPost({title: title});
                    console.log('Title updated:', title);
                } else {
                    console.log('No title block found.');
                }
        } else {
            console.log('Title is empty or null.');
        }
        setOpen( false );
    };
    const dispatchExcerpts = (excerpt) => {
        if (excerpt) {
            const postId = select('core/editor').getCurrentPostId();
            dispatch('core/editor').editPost({excerpt: excerpt, id: postId})
        }
        setOpen( false );
    };

    const getResponse = (param) => {
        setPosts([]);
        setErrors('');
        setRestNotice('');
        setExcerpts([]);
        const queryParams = { content: temp };
        console.log(queryParams);
        if (param == 'get-excerpts') {
            setModalHeader('Most Relevant Excerpts')
        }
        if (param == 'get-titles') {
            setModalHeader('Most Relevant Headings')
        }
        setOpen( true );
        setLoader( true );
        fetchRequest(param, queryParams).then( ( response ) => {
            let json_response = JSON.parse(response);
            if (json_response['error'] && json_response['error']['message']) {
                setErrors(json_response['error']['message']);
            } else {
                param === "get-titles" ? setPosts(json_response) : setExcerpts(json_response);
            }
            setLoader(false)
        } )
            .catch(error => {
                    setRestNotice(error.message);
                    setOpen( false );
                    setLoader( false );
                    setNotice( true );
            });

    };
    return (
        <>
            <PluginSidebarMoreMenuItem target="mopenai-settings-sidebar">
                Open AI
            </PluginSidebarMoreMenuItem>
            <PluginSidebar
                name="mopenai-settings-sidebar"
                title="Open Ai"
                icon="admin-settings">
                <div class="mopen-ai__body">
                    <div class="mopen-ai__buton-group">
                        <Button isSecondary onClick={() => getResponse('get-titles')}>Create titles</Button>
                        <Button isPrimary onClick={() => getResponse('get-excerpts')}>Create excerpt</Button>
                    </div>
                </div>
                { isNotice && (
                    <Notice status="error">
                        <p>{restNotice}</p>
                    </Notice>
                )}
                { isOpen && (
                    <Modal title={modalHeader} onRequestClose={ closeModal }>
                        <div class="components-modal__body">
                            { isLoader && (
                                <div class="components-modal__loader">
                                   <Spinner />
                                </div>
                            )}
                            { errors && (
                                <div class='components-modal__item'>{errors}</div>
                            )}
                            { posts && (
                                posts.map((item, i) => {
                                    return (
                                        <div class='components-modal__item' onClick={() => dispatchTitle(item) }>{`${i+1}) ${item}`}</div>
                                )})
                            )}
                            { excerpts && (
                                excerpts.map((item, i) => {
                                    return (
                                        <div class='components-modal__item' onClick={() => dispatchExcerpts(item) }>{`${i+1}) ${item}`}</div>
                                )})
                            )}
                        </div>
                    </Modal>
                )}
            </PluginSidebar>
         </>
    );
};

const MopenAIRegisterPlugin = () => {
    const { registerPlugin } = wp.plugins;
    const { getEditedPostAttribute } = select('core/editor');

    useEffect(() => {
        if (getEditedPostAttribute('type') === 'post') {
            registerPlugin('mopen-plugin-sidebar', {
                render: MOpenAISidebar,
            });
        }
    }, [getEditedPostAttribute('type')]);

    return null;
};

wp.domReady(() => {
    wp.plugins.registerPlugin('mopen-plugin', { render: MopenAIRegisterPlugin });
});