const path = require('path');

module.exports = (eZConfig, eZConfigManager) => {
    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-admin-ui-layout-js',
        newItems: [path.resolve(__dirname, '../public/js/ezomnibox.js')],
    });

    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-admin-ui-layout-css',
        newItems: [path.resolve(__dirname, '../public/css/ezomnibox.css')],
    });
};
