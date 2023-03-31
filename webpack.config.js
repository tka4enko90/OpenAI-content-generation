const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const { getWebpackEntryPoints } = require( '@wordpress/scripts/utils/config' );
module.exports = {
    ...defaultConfig,
    entry : {
        ...getWebpackEntryPoints(),
        blocks: './blocks/mopen-ai-sidebar/index.js'
    }
}