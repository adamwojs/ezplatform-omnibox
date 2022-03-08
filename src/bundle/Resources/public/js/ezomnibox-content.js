((global, doc, eZ) => {
    const PROVIDER_NAME = 'content';

    doc.addEventListener('ezplatform.omnibox.init', (event) => {
        if (!eZ.omnibox.isProviderEnabled(PROVIDER_NAME)) {
            return ;
        }

        const provider = {
            name: 'content',
            displayKey: 'name',
            source: (query, callback) => {
                eZ.omnibox.fetchSuggestions(query, null, ['content']).then(callback);
            },
            templates: {
                suggestion: (suggestion, answer) => {
                    const contentTypeIcon = eZ.helpers.contentType.getContentTypeIconUrl(suggestion.contentType);
                    const contentTypeName = eZ.helpers.contentType.getContentTypeName(suggestion.contentType);

                    return `
                            <h6 class="mt-0">${suggestion.name}</h6>
                            
                            <p class="aa-suggestion-meta">
                                <svg class="ibexa-icon ibexa-icon--small ibexa-icon--base-dark ibexa-icon-${suggestion.contentType}">
                                    <use xlink:href="${contentTypeIcon}"></use>
                                </svg>                                                                                                
                                ${contentTypeName} under ${suggestion.parentName}
                            </p> 
                        `;
                }
            }
        };

        event.detail.providers.push(provider);
    })
})(window, window.document, window.eZ);
