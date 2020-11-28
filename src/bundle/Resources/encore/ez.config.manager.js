const path = require('path');

module.exports = (eZConfig, eZConfigManager) => {
    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-admin-ui-layout-js',
        newItems: [
            path.resolve(__dirname, '../public/js/ezomnibox-api.js'),
            path.resolve(__dirname, '../public/js/ezomnibox-content.js'),
            path.resolve(__dirname, '../public/js/ezomnibox-command.js'),
            path.resolve(__dirname, '../public/js/ezomnibox-init.js'),
        ],
    });

    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-admin-ui-layout-css',
        newItems: [path.resolve(__dirname, '../public/css/ezomnibox.css')],
    });
};
