import { useEffect } from '@wordpress/element'
import {  select} from '@wordpress/data';
import MOpenAISidebar from "./MOpenAISidebar";

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