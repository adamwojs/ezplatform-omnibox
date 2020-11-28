((global, doc, eZ) => {
    doc.addEventListener('ezplatform.omnibox.init', (event) => {
        const provider = {
            name: 'command',
            displayKey: 'displayText',
            source: (query, callback) => {
                eZ.omnibox.fetchSuggestions(query, null, ['command']).then(callback);
            },
            templates: {
                suggestion: (suggestion, answer) => {
                    const iconPath = eZ.helpers.icon.getIconPath('tag');

                    return `
                            <h6 class="mt-0">${suggestion.displayText}</h6>
                            
                            <p class="aa-suggestion-meta">
                                <svg class="ez-icon ez-icon--small ez-icon--base-dark ez-icon-tag">
                                    <use xlink:href="${iconPath}"></use>
                                </svg>                                                                                                
                                Command
                            </p> 
                        `;
                }
            }
        };

        event.detail.providers.push(provider);
    })
})(window, window.document, window.eZ);
